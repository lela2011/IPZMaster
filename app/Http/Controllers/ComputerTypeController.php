<?php

namespace App\Http\Controllers;

use App\Models\ComputerType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ComputerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the computer types
        $computerTypes = ComputerType::orderBy('name')->paginate(10);

        // display the index page
        return view('admin.computerType.index', compact('computerTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // display the create form
        return view('admin.computerType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('computer_types', 'name')]
        ],[
            'name.required' => 'Computer Type name is required',
            'name.unique' => 'Computer Type name already exists'
        ]);

        // create a computer type
        ComputerType::create($formdata);

        // redirect to computer type index
        return redirect()->route('computer-type.index')->with('message', 'Computer Type created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComputerType $computerType)
    {
        // display the edit form
        return view('admin.computerType.edit', compact('computerType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComputerType $computerType)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('computer_types', 'name')->ignore($computerType->id)]
        ],[
            'name.required' => 'Computer Type name is required',
            'name.unique' => 'Computer Type name already exists'
        ]);

        // update the computer type
        $computerType->update($formdata);

        // redirect to computer type index
        return redirect()->route('computer-type.index')->with('message', 'Computer Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComputerType $computerType)
    {
        // delete the computer type
        $computerType->delete();

        // redirect to computer type index
        return redirect()->route('computer-type.index')->with('message', 'Computer Type deleted successfully');
    }
}
