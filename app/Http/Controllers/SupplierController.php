<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the types
        $suppliers = Supplier::orderBy('name')->paginate(20);

        // display the index page
        return view('admin.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // display the create form
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('suppliers', 'name')],
            'url' => 'nullable|url',
        ],[
            'name.required' => 'Supplier name is required',
            'name.unique' => 'Supplier name already exists',
            'url.url' => 'URL must be a valid URL'
        ]);

        // create
        Supplier::create($formdata);

        // redirect to index page
        return redirect()->route('supplier.index')->with('message', 'Supplier created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        // display the edit form
        return view('admin.supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('suppliers', 'name')->ignore($supplier->id)],
            'url' => 'nullable|url',
        ],[
            'name.required' => 'Supplier name is required',
            'name.unique' => 'Supplier name already exists',
            'url.url' => 'URL must be a valid URL'
        ]);

        // update the  type
        $supplier->update($formdata);

        // redirect to index page
        return redirect()->route('supplier.index')->with('message', 'Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // delete the type
        $supplier->delete();

        // redirect to type index
        return redirect()->route('supplier.index')->with('message', 'Supplier deleted successfully');
    }
}
