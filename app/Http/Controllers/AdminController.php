<?php

namespace App\Http\Controllers;

use App\Models\ResearchArea;
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

    public function researchArea() {
        // retrieves all research areas
        $researchAreas = ResearchArea::all();
        // loads manager for each research area
        $researchAreas->load('manager');
        // retrieves all users
        $users = User::doesntHave('managedResearchArea')->get();
        // displays research area page
        return view('admin.researchArea', compact('researchAreas', 'users'));
    }

    // creates new research area
    public function createResearchArea(Request $request) {
        // validates input
        $formdata = collect($request->validate([
            'english' => 'required|string|unique:research_areas,english',
            'german' => 'required|string|unique:research_areas,german',
            'url_english' => 'required|url',
            'url_german' => 'required|url',
            'manager_uid' => 'nullable|exists:users,uid|unique:research_areas,manager_uid'
        ],[
            'english.required' => 'Please enter an english name.',
            'english.string' => 'English name must be a string.',
            'english.unique' => 'English name already exists.',
            'german.required' => 'Please enter a german name.',
            'german.string' => 'German name must be a string.',
            'german.unique' => 'German name already exists.',
            'manager_uid.exists' => 'Manager does not exist.',
            'manager_uid.unique' => 'Manager already exists.'
        ]));

        // creates new research area
        $researchArea = new ResearchArea($formdata->except('manager_uid')->toArray());

        // saves research area and sets relationshp
        $manager = User::find($formdata->get('manager_uid'));
        $manager->managedResearchArea()->save($researchArea);

        // redirects back to research area page with success message
        return redirect()->back()->with('message', 'Research area created successfully.');
    }

    public function deleteResearchArea(ResearchArea $researchArea) {
        // deletes research area
        $researchArea->delete();

        // redirects back to research area page with success message
        return redirect()->back()->with('message', 'Research area deleted successfully.');
    }

    // updates manager of research area
    public function updateManager(Request $request, ResearchArea $researchArea) {
        // validates input
        $validator = Validator::make($request->all(), [
            'manager_uid' => 'nullable|exists:users,uid|unique:research_areas,manager_uid' // checks if manager exists
        ]);

        // checks if validation failed
        if($validator->fails()) {
            // redirects back to research area page with error message
            return redirect()->back()->with('errorMessage', 'Could not update manager.');
        }

        // updates manager
        $researchArea->manager()->associate($request->input('manager_uid'));
        $researchArea->save();
        // redirects back to research area page with success message
        return redirect()->back()->with('message', 'Manager updated successfully.');
    }
}
