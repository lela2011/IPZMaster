<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the types
        $locations = Location::orderBy('name')->paginate(20);

        // display the index page
        return view('admin.location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // display the create form
        return view('admin.location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('locations', 'name')]
        ],[
            'name.required' => 'Location name is required',
            'name.unique' => 'Location name already exists'
        ]);

        // create
        Location::create($formdata);

        // redirect to index page
        return redirect()->route('location.index')->with('message', 'Location created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        // display the edit form
        return view('admin.location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('locations', 'name')->ignore($location->id)]
        ],[
            'name.required' => 'Location name is required',
            'name.unique' => 'Location name already exists'
        ]);

        // update the  type
        $location->update($formdata);

        // redirect to index page
        return redirect()->route('location.index')->with('message', 'Location updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        // delete the type
        $location->delete();

        // redirect to type index
        return redirect()->route('location.index')->with('message', 'Location deleted successfully');
    }
}
