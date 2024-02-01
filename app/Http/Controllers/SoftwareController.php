<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Software;
use App\Models\Supplier;
use App\Models\User;
use App\Rules\MaxUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all the data for the dropdowns
        $manufacturers = Manufacturer::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // validate the request
        $filters = $request->validate([
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'name' => 'nullable|string',
            'license_type' => 'nullable|string',
            'notes' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'people' => 'nullable|array',
            'people.*' => 'nullable|string|exists:users,uid',
        ]);

        // create the query
        $softwaresQuery = Software::query()->with('manufacturer', 'supplier', 'people');

        // apply the filters
        foreach($filters as $field => $value) {
            if($value) {
                if($field === 'people') {
                    $softwaresQuery->whereHas('people', function($query) use ($value) {
                        $query->whereIn('uid', $value);
                    });
                } elseif(str_ends_with($field, '_id')) {
                    $softwaresQuery->where($field, $value);
                } else {
                    $softwaresQuery->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        // get the results
        $softwares = $softwaresQuery->paginate(10);

        // return the view
        return view('admin.software.index', compact('softwares', 'manufacturers', 'suppliers', 'people', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all the data for the dropdowns
        $manufacturers = Manufacturer::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.software.create', compact('manufacturers', 'suppliers', 'people'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $formdata = $request->validate([
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'name' => 'nullable|string',
            'license_type' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'invoice' => 'nullable|file|mimes:pdf,doc,docx',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'quantity' => 'nullable|integer',
            'people' => ['nullable','array', new MaxUsers($request->input('quantity') ?? 0)],
            'people.*' => 'nullable|string|exists:users,uid',
        ],[
            'manufacturer_id.exists' => 'The selected manufacturer does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'people.max' => 'The number of people assigned to this software cannot exceed the quantity',
            'people.*.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Software not created. Please fill at least one field.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;
        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/softwares', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // create the mobile device
        $software = Software::create($formdata);

        // associate the users
        $software->people()->attach($formdata['people'] ?? []);

        // redirect to the index
        return redirect()->route('software.index')->with('message', 'Software created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Software $software)
    {
        // loads all realtionships
        $software->load('manufacturer', 'supplier', 'people');

        // return the view
        return view('admin.software.show', compact('software'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Software $software)
    {
        // loads all assigned users
        $software->load('people');

        // get all the data for the dropdowns
        $manufacturers = Manufacturer::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.software.edit', compact('software', 'manufacturers', 'suppliers', 'people'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Software $software)
    {
        // validate the request
        $formdata = $request->validate([
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'name' => 'nullable|string',
            'license_type' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'invoice' => 'nullable|file|mimes:pdf,doc,docx',
            'remove_invoice_input' => 'required|boolean',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'quantity' => 'nullable|integer',
            'people' => ['nullable','array', new MaxUsers($request->input('quantity') ?? 0)],
            'people.*' => 'nullable|string|exists:users,uid',
        ],[
            'manufacturer_id.exists' => 'The selected manufacturer does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'people.max' => 'The number of people assigned to this software cannot exceed the quantity',
            'people.*.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Software not updated. Please fill at least one field or delete it.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;

        // checks if the remove invoice was clicked or a new file was uploaded
        if($formdata['remove_invoice_input'] || $file) {
            // checks if the invoice exists
            if ($software->invoice && Storage::disk('secure')->exists($software->invoice)) {
                // delete the invoice
                Storage::disk('secure')->delete($software->invoice);
                $software->invoice = null;
                $software->save();
            }
        }

        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/softwares', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // update the mobile device
        $software->update($formdata);

        // sync the users
        $software->people()->sync($formdata['people'] ?? []);

        // redirect to the index
        return redirect()->route('software.index')->with('message', 'Software updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Software $software)
    {
        // checks if the invoice exists
        if ($software->invoice && Storage::disk('secure')->exists($software->invoice)) {
            // delete the invoice
            Storage::disk('secure')->delete($software->invoice);
        }

        // delete the mobile device
        $software->delete();

        // redirect to the index
        return redirect()->route('software.index')->with('success', 'Software deleted successfully');
    }
}
