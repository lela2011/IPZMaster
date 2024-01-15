<?php

namespace App\Http\Controllers;

use App\Models\ResearchArea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminResearchAreaController extends Controller
{
    public function index() {
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
    public function create(Request $request) {
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

    public function delete(ResearchArea $researchArea) {
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
