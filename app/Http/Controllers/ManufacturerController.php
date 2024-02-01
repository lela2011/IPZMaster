<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the types
        $manufacturers = Manufacturer::orderBy('name')->paginate(20);

        // display the index page
        return view('admin.manufacturer.index', compact('manufacturers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // display the create form
        return view('admin.manufacturer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('manufacturers', 'name')],
            'url' => 'nullable|url',
        ],[
            'name.required' => 'Manufacturer name is required',
            'name.unique' => 'Manufacturer name already exists',
            'url.url' => 'URL must be a valid URL'
        ]);

        // create
        Manufacturer::create($formdata);

        // redirect to index page
        return redirect()->route('manufacturer.index')->with('message', 'Manufacturer created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacturer $manufacturer)
    {
        // display the edit form
        return view('admin.manufacturer.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('manufacturers', 'name')->ignore($manufacturer->id)],
            'url' => 'nullable|url',
        ],[
            'name.required' => 'Manufacturer name is required',
            'name.unique' => 'Manufacturer name already exists',
            'url.url' => 'URL must be a valid URL'
        ]);

        // update the  type
        $manufacturer->update($formdata);

        // redirect to index page
        return redirect()->route('manufacturer.index')->with('message', 'Manufacturer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturer $manufacturer)
    {
        // delete the type
        $manufacturer->delete();

        // redirect to type index
        return redirect()->route('manufacturer.index')->with('message', 'Manufacturer deleted successfully');
    }
}
