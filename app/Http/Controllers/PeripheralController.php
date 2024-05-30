<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Peripheral;
use App\Models\PeripheralType;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeripheralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all the data for the dropdowns
        $types = PeripheralType::all();
        $manufacturers = Manufacturer::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // validate the request
        $params = collect($request->validate([
            'type_id' => 'nullable|integer|exists:peripheral_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'location_id' => 'nullable|integer|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'warranty_date' => 'nullable|date',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'user_id' => 'nullable|string|exists:users,uid',
            'sort' => 'nullable|string|in:type_id,manufacturer_id,model,serial_number,product_number,mac_address,notes,location_id,purchase_date,warranty_date,supplier_id,user_id',
            'direction' => 'nullable|string|in:asc,desc'
        ]));

        $filters = $params->except(['sort', 'direction'])->all();
        $sort = $params->only(['sort', 'direction'])->all();

        // create the query
        $peripheralsQuery = Peripheral::query()->with('type', 'manufacturer', 'location', 'supplier', 'person');

        // apply the filters
        foreach($filters as $field => $value) {
            if($value) {
                if(str_ends_with($field, '_id')) {
                    $peripheralsQuery->where($field, $value);
                } else {
                    $peripheralsQuery->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        // apply sorting
        if($sort) {
            $sortKey = $sort['sort'];
            $sortDirection = $sort['direction'] ?? 'asc';

            if($sortKey === 'type_id') {
                $peripheralsQuery->join('peripheral_types', 'peripherals.type_id', '=', 'peripheral_types.id')
                    ->orderBy('peripheral_types.name', $sortDirection);
            } else if($sortKey === 'manufacturer_id') {
                $peripheralsQuery->join('manufacturers', 'peripherals.manufacturer_id', '=', 'manufacturers.id')
                    ->orderBy('manufacturers.name', $sortDirection);
            } else if($sortKey === 'location_id') {
                $peripheralsQuery->join('locations', 'peripherals.location_id', '=', 'locations.id')
                    ->orderBy('locations.name', $sortDirection);
            } else if($sortKey === 'supplier_id') {
                $peripheralsQuery->join('suppliers', 'peripherals.supplier_id', '=', 'suppliers.id')
                    ->orderBy('suppliers.name', $sortDirection);
            } else if($sortKey === 'user_id') {
                $peripheralsQuery->join('users', 'peripherals.user_id', '=', 'users.uid')
                    ->orderBy('users.name', $sortDirection);
            } else {
                $peripheralsQuery->orderBy($sortKey, $sortDirection);
            }
        }

        //dd($peripheralsQuery->get()->pluck('type.name'));

        // get the results
        $peripherals = $peripheralsQuery->paginate(10);

        // return the view
        return view('admin.peripheral.index', compact('peripherals', 'types', 'manufacturers', 'locations', 'suppliers', 'people', 'filters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all the data for the dropdowns
        $types = PeripheralType::all();
        $manufacturers = Manufacturer::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.peripheral.create', compact('types', 'manufacturers', 'locations', 'suppliers', 'people'));
    }

    public function copy(Peripheral $peripheral)
    {
        // get all the data for the dropdowns
        $types = PeripheralType::all();
        $manufacturers = Manufacturer::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.peripheral.copy', compact('peripheral', 'types', 'manufacturers', 'locations', 'suppliers', 'people'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $formdata = $request->validate([
            'type_id' => 'nullable|integer|exists:peripheral_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'location_id' => 'nullable|integer|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'warranty_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'invoice' => 'nullable|file|mimes:pdf,doc,docx',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'user_id' => 'nullable|string|exists:users,uid',
        ],[
            'type_id.exists' => 'The selected type does not exist',
            'manufacturer_id.exists' => 'The selected manufacturer does not exist',
            'location_id.exists' => 'The selected location does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'user_id.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
            'warranty_date.date' => 'The warranty date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Peripheral not created. Please fill at least one field.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;
        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/peripherals', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // create the Peripheral
        Peripheral::create($formdata);

        // redirect to the index
        return redirect()->route('peripheral.index')->with('message', 'Peripheral created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peripheral $peripheral)
    {
        // loads all realtionships
        $peripheral->load('type', 'manufacturer', 'location', 'supplier', 'person');

        // return the view
        return view('admin.peripheral.show', compact('peripheral'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peripheral $peripheral)
    {
        // get all the data for the dropdowns
        $types = PeripheralType::all();
        $manufacturers = Manufacturer::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.peripheral.edit', compact('peripheral', 'types', 'manufacturers', 'locations', 'suppliers', 'people'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peripheral $peripheral)
    {
        // validate the request
        $formdata = $request->validate([
            'type_id' => 'nullable|integer|exists:peripheral_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'location_id' => 'nullable|integer|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'warranty_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'remove_invoice_input' => 'required|boolean',
            'invoice' => 'nullable|file|mimes:pdf,doc,docx',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'user_id' => 'nullable|string|exists:users,uid',
        ],[
            'type_id.exists' => 'The selected type does not exist',
            'manufacturer_id.exists' => 'The selected manufacturer does not exist',
            'location_id.exists' => 'The selected location does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'user_id.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
            'warranty_date.date' => 'The warranty date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Peripheral not updated. Please fill at least one field or delete it.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;

        // checks if the remove invoice was clicked or a new file was uploaded
        if($formdata['remove_invoice_input'] || $file) {
            // checks if the invoice exists
            if ($peripheral->invoice && Storage::disk('secure')->exists($peripheral->invoice)) {
                // delete the invoice
                Storage::disk('secure')->delete($peripheral->invoice);
                $peripheral->invoice = null;
                $peripheral->save();
            }
        }

        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/peripherals', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // update the Peripheral
        $peripheral->update($formdata);

        // redirect to the index
        return redirect()->route('peripheral.index')->with('message', 'Peripheral updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peripheral $peripheral)
    {
        // checks if the invoice exists
        if ($peripheral->invoice && Storage::disk('secure')->exists($peripheral->invoice)) {
            // delete the invoice
            Storage::disk('secure')->delete($peripheral->invoice);
        }

        // delete the peripheral
        $peripheral->delete();

        // redirect to the index
        return redirect()->route('peripheral.index')->with('success', 'Peripheral deleted successfully');
    }
}
