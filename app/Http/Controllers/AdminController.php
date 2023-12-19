<?php

namespace App\Http\Controllers;

use App\Models\ResearchProject;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
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

    /**
     * Display a listing of the resource.
     */
    public function research(Request $request) : View
    {
        // validates filter to reduce the danger of SQL injections
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|string'
        ]);

        // checks if validation failed
        if ($validator->fails()) {
            // redirects to index page to display error message
            return redirect()->route('admin.research')->withErrors($validator)->withInput();
        }

        // prepares query for managable projects
        $projectQuery = ResearchProject::query();

        // checks if filter is set
        if($request->has('filter')) {
            // prepares filter value
            $filterValue = "%" . $request->input('filter') . "%";
            // applies filter to both queries
            $projectQuery->where('title', 'like', $filterValue);
        }

        // retrieves all projects after filter was applied
        $projects = $projectQuery->get();

        // displays list page
        return view('admin.research', [
            'projects' => $projects,
            'filter' => $request->input('filter')
        ]);
    }
}
