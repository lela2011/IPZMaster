<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Monitor;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all the data for the dropdowns
        $manufacturers = Manufacturer::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // validate the request
        $params = collect($request->validate([
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'size' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'notes' => 'nullable|string',
            'location_id' => 'nullable|integer|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'warranty_date' => 'nullable|date',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'user_id' => 'nullable|string|exists:users,uid',
            'sort' => 'nullable|string|in:type_id,manufacturer_id,model,size,serial_number,product_number,notes,location_id,purchase_date,warranty_date,supplier_id,user_id',
            'direction' => 'nullable|string|in:asc,desc'
        ]));

        $filters = $params->except(['sort', 'direction'])->all();
        $sort = $params->only(['sort', 'direction'])->all();

        // create the query
        $monitorsQuery = Monitor::query()->with('manufacturer', 'location', 'supplier', 'person');

        // apply the filters
        foreach($filters as $field => $value) {
            if($value) {
                if(str_ends_with($field, '_id')) {
                    $monitorsQuery->where($field, $value);
                } else {
                    $monitorsQuery->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        // apply sort
        if($sort) {
            $sortKey = $sort['sort'];
            $sortDirection = $sort['direction'] ?? 'asc';

            if($sortKey === 'manufacturer_id') {
                $monitorsQuery->join('manufacturers', 'monitors.manufacturer_id', '=', 'manufacturers.id')
                    ->orderBy('manufacturers.name', $sortDirection);
            } else if($sortKey === 'location_id') {
                $monitorsQuery->join('locations', 'monitors.location_id', '=', 'locations.id')
                    ->orderBy('locations.name', $sortDirection);
            } else if($sortKey === 'supplier_id') {
                $monitorsQuery->join('suppliers', 'monitors.supplier_id', '=', 'suppliers.id')
                    ->orderBy('suppliers.name', $sortDirection);
            } else if($sortKey === 'user_id') {
                $monitorsQuery->join('users', 'monitors.user_id', '=', 'users.uid')
                    ->orderBy('users.last_name', $sortDirection)
                    ->orderBy('users.first_name', $sortDirection);
            } else {
                $monitorsQuery->orderBy($sortKey, $sortDirection);
            }
        }

        // get the results
        $monitors = $monitorsQuery->paginate(10);

        // return the view
        return view('admin.monitor.index', compact('monitors', 'manufacturers', 'locations', 'suppliers', 'people', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all the data for the dropdowns
        $manufacturers = Manufacturer::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.monitor.create', compact('manufacturers', 'locations', 'suppliers', 'people'));

    }

    public function copy(Monitor $monitor)
    {
        // get all the data for the dropdowns
        $manufacturers = Manufacturer::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.monitor.copy', compact('monitor', 'manufacturers', 'locations', 'suppliers', 'people'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $formdata = $request->validate([
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'size' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'location_id' => 'nullable|integer|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'warranty_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'invoice' => 'nullable|file|mimes:pdf,doc,docx',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'user_id' => 'nullable|string|exists:users,uid',
        ],[
            'manufacturer_id.exists' => 'The selected manufacturer does not exist',
            'location_id.exists' => 'The selected location does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'user_id.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
            'warranty_date.date' => 'The warranty date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Monitor not created. Please fill at least one field.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;
        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/monitors', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // create the computer
        Monitor::create($formdata);

        // redirect to the index
        return redirect()->route('monitor.index')->with('message', 'Monitor created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Monitor $monitor)
    {
        // loads all realtionships
        $monitor->load('manufacturer', 'location', 'supplier', 'person');

        // return the view
        return view('admin.monitor.show', compact('monitor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monitor $monitor)
    {
        // get all the data for the dropdowns
        $manufacturers = Manufacturer::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.monitor.edit', compact('monitor', 'manufacturers', 'locations', 'suppliers', 'people'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monitor $monitor)
    {
        // validate the request
        $formdata = $request->validate([
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'size' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'location_id' => 'nullable|integer|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'warranty_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'remove_invoice_input' => 'required|boolean',
            'invoice' => 'nullable|file|mimes:pdf,doc,docx',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'user_id' => 'nullable|string|exists:users,uid',
        ],[
            'manufacturer_id.exists' => 'The selected manufacturer does not exist',
            'location_id.exists' => 'The selected location does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'user_id.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
            'warranty_date.date' => 'The warranty date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Monitor not updated. Please fill at least one field or delete it.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;

        // checks if the remove invoice was clicked or a new file was uploaded
        if($formdata['remove_invoice_input'] || $file) {
            // checks if the invoice exists
            if ($monitor->invoice && Storage::disk('secure')->exists($monitor->invoice)) {
                // delete the invoice
                Storage::disk('secure')->delete($monitor->invoice);
                $monitor->invoice = null;
                $monitor->save();
            }
        }

        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/monitors', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // update the computer
        $monitor->update($formdata);

        // redirect to the index
        return redirect()->route('monitor.index')->with('message', 'Monitor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitor $monitor)
    {
        // checks if the invoice exists
        if ($monitor->invoice && Storage::disk('secure')->exists($monitor->invoice)) {
            // delete the invoice
            Storage::disk('secure')->delete($monitor->invoice);
        }

        // delete the computer
        $monitor->delete();

        // redirect to the index
        return redirect()->route('monitor.index')->with('success', 'Monitor deleted successfully');
    }
}
