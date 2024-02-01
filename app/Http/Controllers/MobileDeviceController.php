<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\MobileDevice;
use App\Models\MobileDeviceType;
use App\Models\OperatingSystem;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all the data for the dropdowns
        $types = MobileDeviceType::all();
        $manufacturers = Manufacturer::all();
        $operatingSystems = OperatingSystem::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // validate the request
        $filters = $request->validate([
            'type_id' => 'nullable|integer|exists:mobile_device_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'network_name' => 'nullable|string',
            'imei' => 'nullable|string',
            'operating_system_id' => 'nullable|integer|exists:operating_systems,id',
            'storage' => 'nullable|string',
            'color' => 'nullable|string',
            'notes' => 'nullable|string',
            'location_id' => 'nullable|integer|exists:locations,id',
            'purchase_date' => 'nullable|date',
            'warranty_date' => 'nullable|date',
            'supplier_id' => 'nullable|integer|exists:suppliers,id',
            'user_id' => 'nullable|string|exists:users,uid',
        ]);

        // create the query
        $mobileDevicesQuery = MobileDevice::query()->with('type', 'manufacturer', 'operatingSystem', 'location', 'supplier', 'person');

        // apply the filters
        foreach($filters as $field => $value) {
            if($value) {
                if(str_ends_with($field, '_id')) {
                    $mobileDevicesQuery->where($field, $value);
                } else {
                    $mobileDevicesQuery->where($field, 'like', '%' . $value . '%');
                }
            }
        }

        // get the results
        $mobileDevices = $mobileDevicesQuery->paginate(10);

        // return the view
        return view('admin.mobileDevice.index', compact('mobileDevices', 'types', 'manufacturers', 'operatingSystems', 'locations', 'suppliers', 'people', 'filters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all the data for the dropdowns
        $types = MobileDeviceType::all();
        $manufacturers = Manufacturer::all();
        $operatingSystems = OperatingSystem::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.mobileDevice.create', compact('types', 'manufacturers', 'operatingSystems', 'locations', 'suppliers', 'people'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $formdata = $request->validate([
            'type_id' => 'nullable|integer|exists:mobile_device_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'network_name' => 'nullable|string',
            'imei' => 'nullable|string',
            'operating_system_id' => 'nullable|integer|exists:operating_systems,id',
            'storage' => 'nullable|string',
            'color' => 'nullable|string',
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
            'location_id.exists' => 'The selected location does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'user_id.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
            'warranty_date.date' => 'The warranty date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Mobile Device not created. Please fill at least one field.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;
        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/mobile-devices', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // create the mobile device
        MobileDevice::create($formdata);

        // redirect to the index
        return redirect()->route('mobile-device.index')->with('message', 'Mobile Device created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MobileDevice $mobileDevice)
    {
        // loads all realtionships
        $mobileDevice->load('type', 'manufacturer', 'operatingSystem', 'location', 'supplier', 'person');

        // return the view
        return view('admin.mobileDevice.show', compact('mobileDevice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MobileDevice $mobileDevice)
    {
        // get all the data for the dropdowns
        $types = MobileDeviceType::all();
        $manufacturers = Manufacturer::all();
        $operatingSystems = OperatingSystem::all();
        $locations = Location::all();
        $suppliers = Supplier::all();
        $people = User::all();

        // return the view
        return view('admin.mobileDevice.edit', compact('mobileDevice', 'types', 'manufacturers', 'operatingSystems', 'locations', 'suppliers', 'people'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MobileDevice $mobileDevice)
    {
        // validate the request
        $formdata = $request->validate([
            'type_id' => 'nullable|integer|exists:mobile_device_types,id',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
            'model' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'product_number' => 'nullable|string',
            'network_name' => 'nullable|string',
            'imei' => 'nullable|string',
            'operating_system_id' => 'nullable|integer|exists:operating_systems,id',
            'storage' => 'nullable|string',
            'color' => 'nullable|string',
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
            'location_id.exists' => 'The selected location does not exist',
            'supplier_id.exists' => 'The selected supplier does not exist',
            'user_id.exists' => 'The selected person does not exist',
            'purchase_date.date' => 'The purchase date must be a valid date',
            'warranty_date.date' => 'The warranty date must be a valid date',
        ]);

        // checks if the form is empty
        if(!array_filter($formdata)) {
            return redirect()->back()->with('errorMessage', 'Mobile Device not updated. Please fill at least one field or delete it.');
        }

        // store the invoice file
        $file = $formdata['invoice'] ?? null;

        // checks if the remove invoice was clicked or a new file was uploaded
        if($formdata['remove_invoice_input'] || $file) {
            // checks if the invoice exists
            if ($mobileDevice->invoice && Storage::disk('secure')->exists($mobileDevice->invoice)) {
                // delete the invoice
                Storage::disk('secure')->delete($mobileDevice->invoice);
                $mobileDevice->invoice = null;
                $mobileDevice->save();
            }
        }

        // checks if the file is not empty
        if($file) {
            // generate a filename with the original filename and a timestamp
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "_" . now()->timestamp . "." . $file->getClientOriginalExtension();
            // store the file
            $path = $file->storeAs('invoices/mobile-devices', $fileName, 'secure');
            // set the path in the formdata
            $formdata['invoice'] = $path;
        }

        // update the mobile device
        $mobileDevice->update($formdata);

        // redirect to the index
        return redirect()->route('mobile-device.index')->with('message', 'Mobile Device updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MobileDevice $mobileDevice)
    {
        // checks if the invoice exists
        if ($mobileDevice->invoice && Storage::disk('secure')->exists($mobileDevice->invoice)) {
            // delete the invoice
            Storage::disk('secure')->delete($mobileDevice->invoice);
        }

        // delete the mobile device
        $mobileDevice->delete();

        // redirect to the index
        return redirect()->route('mobile-device.index')->with('success', 'Mobile Device deleted successfully');
    }
}
