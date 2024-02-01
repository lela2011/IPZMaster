<?php

namespace App\Http\Controllers;

use App\Models\MobileDeviceType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MobileDeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the mobile device types
        $mobileDeviceTypes = MobileDeviceType::orderBy('name')->paginate(10);

        // display the index page
        return view('admin.mobileDeviceType.index', compact('mobileDeviceTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // display the create form
        return view('admin.mobileDeviceType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('mobile_device_types', 'name')]
        ],[
            'name.required' => 'Mobile Device Type name is required',
            'name.unique' => 'Mobile Device Type name already exists'
        ]);

        // create a mobile device type
        MobileDeviceType::create($formdata);

        // redirect to mobile device type index
        return redirect()->route('mobile-device-type.index')->with('message', 'Mobile Device Type created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MobileDeviceType $mobileDeviceType)
    {
        // display the edit form
        return view('admin.mobileDeviceType.edit', compact('mobileDeviceType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MobileDeviceType $mobileDeviceType)
    {
        // validate the form data
        $formdata = $request->validate([
            'name' => ['required','string', Rule::unique('mobile_device_types', 'name')->ignore($mobileDeviceType->id)]
        ],[
            'name.required' => 'Mobile Device Type name is required',
            'name.unique' => 'Mobile Device Type name already exists'
        ]);

        // update the mobile device type
        $mobileDeviceType->update($formdata);

        // redirect to mobile device type index
        return redirect()->route('mobile-device-type.index')->with('message', 'Mobile Device Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MobileDeviceType $mobileDeviceType)
    {
        // delete the computer type
        $mobileDeviceType->delete();

        // redirect to computer type index
        return redirect()->route('mobile-device-type.index')->with('message', 'Mobile Device Type deleted successfully');
    }
}
