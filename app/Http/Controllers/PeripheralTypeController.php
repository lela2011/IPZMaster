<?php

namespace App\Http\Controllers;

use App\Models\Peripheral;
use App\Models\PeripheralType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeripheralTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the types
        $peripheralTypes = PeripheralType::orderBy('name')->paginate(10);

        // display the index page
        return view('admin.peripheralType.index', compact('peripheralTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // display the create form
        return view('admin.peripheralType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('peripheral_types', 'name')]
        ],[
            'name.required' => 'Peripheral Type name is required',
            'name.unique' => 'Peirpheral Type name already exists'
        ]);

        // create
        PeripheralType::create($formdata);

        // redirect to index page
        return redirect()->route('peripheral-type.index')->with('message', 'Peripheral Type created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeripheralType $peripheralType)
    {
        // display the edit form
        return view('admin.peripheralType.edit', compact('peripheralType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PeripheralType $peripheralType)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('peripheral_types', 'name')->ignore($peripheralType->id)]
        ],[
            'name.required' => 'Peripheral Type name is required',
            'name.unique' => 'Peripheral Type name already exists'
        ]);

        // update the  type
        $peripheralType->update($formdata);

        // redirect to index page
        return redirect()->route('peripheral-type.index')->with('message', 'Peripheral Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeripheralType $peripheralType)
    {
        // delete the type
        $peripheralType->delete();

        // redirect to type index
        return redirect()->route('peripheral-type.index')->with('message', 'Peripheral Type deleted successfully');
    }
}
