<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmploymentTypeRequest;
use App\Models\EmploymentType;
use App\Models\ResearchArea;
use App\Models\ResearchProject;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request)
    {
        $request->session()->put('mode', 'admin');
        return view('admin.dashboard');
    }

    public function personal(Request $request) : View {

        // validates filter to reduce the danger of SQL injections
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|string'
        ]);

        // checks if validation failed
        if ($validator->fails()) {
            // redirects to index page to display error message
            return redirect()->route('user.index')->withErrors($validator)->withInput();
        }

        $userQuery = User::query();

        if($request->has('filter')) {
            // prepares filter value
            $filterValue = "%" . $request->input('filter') . "%";
            // applies filter to query
            $userQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["$filterValue"]);
        }

        // gets all external contacts from DB
        $users = $userQuery->get();

        // returns index view with external contacts
        return view('admin.personal', [
            'users' => $users,
            'filter' => $request->input('filter')
        ]);
    }

    public function promote(User $user)
    {
        $this->authorize('promote', $user);

        // promotes user to admin
        $user->adminLevel = 1;
        $user->save();

        return redirect()->back()->with('message', $user->first_name . ' ' . $user->last_name . ' promoted to admin.');
    }

    public function demote(User $user)
    {
        $this->authorize('demote', $user);

        if($user->uid == Auth::user()->uid) {
            return redirect()->back()->with('errorMessage', 'You cannot demote yourself.');
        }

        // demotes user to normal user
        $user->adminLevel = 0;
        $user->save();

        return redirect()->back()->with('message', $user->first_name . ' ' . $user->last_name . ' demoted.');
    }

    public function syncUsers() {

        // sync all users from ldap to database
        Artisan::call('ldap:import', [ // IPZ group
            'provider' => 'users',
            '--no-interaction',
            '--scopes' => 'App\Ldap\Scopes\OnlyIPZ'
        ]);
        Artisan::call('ldap:import', [ // PWI group
            'provider' => 'users',
            '--no-interaction',
            '--scopes' => 'App\Ldap\Scopes\OnlyPWI'
        ]);

        Log::info('Users synchronized successfully');

        // redirects to previous page with success message
        return redirect()->route('admin.personal')->with('message', 'Users synchronized successfully.');
    }

    /**
     * Display a listing of the resource.
     */
    public function research(Request $request) : View
    {
        // validates filter to reduce the danger of SQL injections
        $filters = $request->validate([
            'title' => 'nullable|string',
            'user_id' => 'nullable|string|exists:users,uid',
        ]);

        // retrieves all users
        $people = User::all();

        // prepares query for managable projects
        $projectQuery = ResearchProject::query();

        // applies filters to query
        foreach($filters as $field => $value) {
            // checks if filter is set
            if($value) {
                // handles id filters
                if(str_ends_with($field, '_id')) {
                    // checks if filter is for user_id
                    if($field == 'user_id') {
                        // filters for projects where user is leader or member
                        $projectQuery->whereHas('leaders', function($query) use ($value) {
                            $query->where('uid', $value);
                        })
                        ->orWhereHas('members', function($query) use ($value) {
                            $query->where('uid', $value);
                        });
                    } else {
                        // filters for projects with specific id
                        $projectQuery->where($field, $value);
                    }
                } else {
                    // filters for projects where field contains value
                    $projectQuery->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        // orders projects by start date and end date
        $projectQuery->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'asc');

        // retrieves all projects after filter was applied
        $projects = $projectQuery->paginate(20);

        // displays list page
        return view('admin.research', compact('projects', 'people', 'filters'));
    }

    public function media(Request $request) : View {

        // validates filter to reduce the danger of SQL injections
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|string'
        ]);

        // checks if validation failed
        if ($validator->fails()) {
            // redirects to index page to display error message
            return redirect()->route('user.index')->withErrors($validator)->withInput();
        }

        $userQuery = User::query();

        if($request->has('filter')) {
            // prepares filter value
            $filterValue = "%" . $request->input('filter') . "%";
            // applies filter to query
            $userQuery->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["$filterValue"]);
        }

        // gets all external contacts from DB
        $users = $userQuery->get();

        // returns index view with external contacts
        return view('admin.media', [
            'users' => $users,
            'filter' => $request->input('filter')
        ]);
    }

    public function inventoryDashboard() {
        return view('admin.inventoryDashboard');
    }
}
