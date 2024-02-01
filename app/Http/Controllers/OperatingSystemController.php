<?php

namespace App\Http\Controllers;

use App\Models\OperatingSystem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OperatingSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the mobile device types
        $operatingSystems = OperatingSystem::orderBy('name')->paginate(20);

        // display the index page
        return view('admin.operatingSystem.index', compact('operatingSystems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // display the create form
        return view('admin.operatingSystem.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('operating_systems', 'name')]
        ],[
            'name.required' => 'Operating System name is required',
            'name.unique' => 'Operating System name already exists'
        ]);

        // create a mobile device type
        OperatingSystem::create($formdata);

        // redirect to mobile device type index
        return redirect()->route('operating-system.index')->with('message', 'Operating System created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OperatingSystem $operatingSystem)
    {
        // display the edit form
        return view('admin.operatingSystem.edit', compact('operatingSystem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OperatingSystem $operatingSystem)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('operating_systems', 'name')->ignore($operatingSystem->id)]
        ],[
            'name.required' => 'Operating System name is required',
            'name.unique' => 'Operating System name already exists'
        ]);

        // update the mobile device type
        $operatingSystem->update($formdata);

        // redirect to mobile device type index
        return redirect()->route('operating-system.index')->with('message', 'Operating System updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperatingSystem $operatingSystem)
    {
        // delete the computer type
        $operatingSystem->delete();

        // redirect to computer type index
        return redirect()->route('operating-system.index')->with('message', 'Operating System deleted successfully');
    }
}
