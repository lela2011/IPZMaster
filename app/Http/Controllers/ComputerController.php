<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\ComputerType;
use App\Models\KeyboardLayout;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\OperatingSystem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all the data for the dropdowns
        $types = ComputerType::all();
        $manufacturers = Manufacturer::all();
        $operatingSystems = OperatingSystem::all();
        $keyboardLayouts = KeyboardLayout::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // validate the request
        $params = collect($request->validate([
            'type_id' => 'nullable|integer|exists:computer_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'network_name' => 'nullable|string',
            'operating_system_id' => 'nullable|integer|exists:operating_systems,id',
            'cpu' => 'nullable|string',
            'ram' => 'nullable|string',
            'storage' => 'nullable|string',
            'color' => 'nullable|string',
            'keyboard_layout_id' => 'nullable|integer|exists:keyboard_layouts,id',
            'notes' => 'nullable|string',
            'location_id' => 'nullable|integer|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'warranty_date' => 'nullable|date',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'user_id' => 'nullable|string|exists:users,uid',
            'sort' => 'nullable|string|in:type_id,manufacturer_id,model,serial_number,product_number,mac_address,network_name,operating_system_id,cpu,ram,storage,color,keyboard_layout_id,notes,location_id,purchase_date,warranty_date,supplier_id,user_id',
            'direction' => 'nullable|string|in:asc,desc'
        ]));

        $filters = $params->except(['sort', 'direction'])->all();
        $sort = $params->only(['sort', 'direction'])->all();

        // create the query
        $computersQuery = Computer::query()->with('type', 'manufacturer', 'operatingSystem', 'location', 'supplier', 'person');

        // apply the filters
        foreach($filters as $field => $value) {
            if($value) {
                if(str_ends_with($field, '_id')) {
                    $computersQuery->where($field, $value);
                } else {
                    $computersQuery->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        // apply sorting
        if($sort) {
            $sortKey = $sort['sort'];
            $sortDirection = $sort['direction'] ?? 'asc';

            if($sortKey === 'type_id') {
                $computersQuery->join('computer_types', 'computers.type_id', '=', 'computer_types.id')
                    ->orderBy('computer_types.name', $sortDirection);
            } else if($sortKey === 'manufacturer_id') {
                $computersQuery->join('manufacturers', 'computers.manufacturer_id', '=', 'manufacturers.id')
                    ->orderBy('manufacturers.name', $sortDirection);
            } else if($sortKey === 'operating_system_id') {
                $computersQuery->join('operating_systems', 'computers.operating_system_id', '=', 'operating_systems.id')
                    ->orderBy('operating_systems.name', $sortDirection);
            } else if($sortKey === 'keyboard_layout_id') {
                $computersQuery->join('keyboard_layouts', 'computers.keyboard_layout_id', '=', 'keyboard_layouts.id')
                    ->orderBy('keyboard_layouts.name', $sortDirection);
            } else if($sortKey === 'location_id') {
                $computersQuery->join('locations', 'computers.location_id', '=', 'locations.id')
                    ->orderBy('locations.name', $sortDirection);
            } else if($sortKey === 'supplier_id') {
                $computersQuery->join('suppliers', 'computers.supplier_id', '=', 'suppliers.id')
                    ->orderBy('suppliers.name', $sortDirection);
            } else if($sortKey === 'user_id') {
                $computersQuery->join('users', 'computers.user_id', '=', 'users.uid')
                    ->orderBy('users.last_name', $sortDirection)
                    ->orderBy('users.first_name', $sortDirection);
            } else {
                $computersQuery->orderBy($sortKey, $sortDirection);
            }
        }

        // get the results
        $computers = $computersQuery->paginate(10);

        // return the view
        return view('admin.computer.index', compact('computers', 'types', 'manufacturers', 'operatingSystems', 'keyboardLayouts', 'locations', 'suppliers', 'people', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all the data for the dropdowns
        $types = ComputerType::all();
        $manufacturers = Manufacturer::all();
        $operatingSystems = OperatingSystem::all();
        $keyboardLayouts = KeyboardLayout::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.computer.create', compact('types', 'manufacturers', 'operatingSystems', 'keyboardLayouts', 'locations', 'suppliers', 'people'));

    }

    public function copy(Computer $computer)
    {
        // get all the data for the dropdowns
        $types = ComputerType::all();
        $manufacturers = Manufacturer::all();
        $operatingSystems = OperatingSystem::all();
        $keyboardLayouts = KeyboardLayout::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.computer.copy', compact('computer','types', 'manufacturers', 'operatingSystems', 'keyboardLayouts', 'locations', 'suppliers', 'people'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $formdata = $request->validate([
            'type_id' => 'nullable|integer|exists:computer_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'network_name' => 'nullable|string',
            'operating_system_id' => 'nullable|integer|exists:operating_systems,id',
            'cpu' => 'nullable|string',
            'ram' => 'nullable|string',
            'storage' => 'nullable|string',
            'color' => 'nullable|string',
            'keyboard_layout_id' => 'nullable|integer|exists:keyboard_layouts,id',
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
            'operating_system_id.exists' => 'The selected operating system does not exist',
            'keyboard_layout_id.exists' => 'The selected keyboard layout does not exist',
            'location_id.exists' => 'The selected location does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'user_id.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
            'warranty_date.date' => 'The warranty date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Computer not created. Please fill at least one field.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;
        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/computers', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // create the computer
        Computer::create($formdata);

        // redirect to the index
        return redirect()->route('computer.index')->with('message', 'Computer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Computer $computer)
    {
        // loads all realtionships
        $computer->load('type', 'manufacturer', 'operatingSystem', 'keyboardLayout', 'location', 'supplier', 'person');

        // return the view
        return view('admin.computer.show', compact('computer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Computer $computer)
    {
        // get all the data for the dropdowns
        $types = ComputerType::all();
        $manufacturers = Manufacturer::all();
        $operatingSystems = OperatingSystem::all();
        $keyboardLayouts = KeyboardLayout::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.computer.edit', compact('computer', 'types', 'manufacturers', 'operatingSystems', 'keyboardLayouts', 'locations', 'suppliers', 'people'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Computer $computer)
    {
        // validate the request
        $formdata = $request->validate([
            'type_id' => 'nullable|integer|exists:computer_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'network_name' => 'nullable|string',
            'operating_system_id' => 'nullable|integer|exists:operating_systems,id',
            'cpu' => 'nullable|string',
            'ram' => 'nullable|string',
            'storage' => 'nullable|string',
            'color' => 'nullable|string',
            'keyboard_layout_id' => 'nullable|integer|exists:keyboard_layouts,id',
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
            'operating_system_id.exists' => 'The selected operating system does not exist',
            'keyboard_layout_id.exists' => 'The selected keyboard layout does not exist',
            'location_id.exists' => 'The selected location does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'user_id.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
            'warranty_date.date' => 'The warranty date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Computer not updated. Please fill at least one field or delete it.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;

        // checks if the remove invoice was clicked or a new file was uploaded
        if($formdata['remove_invoice_input'] || $file) {
            // checks if the invoice exists
            if ($computer->invoice && Storage::disk('secure')->exists($computer->invoice)) {
                // delete the invoice
                Storage::disk('secure')->delete($computer->invoice);
                $computer->invoice = null;
                $computer->save();
            }
        }

        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/computers', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // update the computer
        $computer->update($formdata);

        // redirect to the index
        return redirect()->route('computer.index')->with('message', 'Computer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Computer $computer)
    {
        // checks if the invoice exists
        if ($computer->invoice && Storage::disk('secure')->exists($computer->invoice)) {
            // delete the invoice
            Storage::disk('secure')->delete($computer->invoice);
        }

        // delete the computer
        $computer->delete();

        // redirect to the index
        return redirect()->route('computer.index')->with('success', 'Computer deleted successfully');
    }
}
