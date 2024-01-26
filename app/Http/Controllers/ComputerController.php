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
        $filters = $request->validate([
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
            'user_id' => 'nullable|integer|exists:users,uid',
        ]);

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
            'invoice' => 'nullable|file|mimes:pdf,doc,docx,txt',
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

        // replaces the new lines with <br>
        //$formdata['notes'] = nl2br($formdata['notes']);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Computer not created. Please fill at least one field.');
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
        $computer->load('type', 'manufacturer', 'operatingSystem', 'location', 'supplier', 'person');

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
            'invoice' => 'nullable|file|mimes:pdf,doc,docx,txt',
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

        // replaces the new lines with <br>
        //$formdata['notes'] = nl2br($formdata['notes']);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Computer not updated. Please fill at least one field or delete it.');
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
        // delete the computer
        $computer->delete();

        // redirect to the index
        return redirect()->route('computer.index')->with('success', 'Computer deleted successfully');
    }
}
