<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmploymentTypeRequest;
use App\Models\EmploymentType;
use Illuminate\Http\Request;

class AdminEmploymentTypeController extends Controller
{
    public function index() {
        // retrieves all employment types
        $employmentTypes = EmploymentType::orderBy('order')->get();
        // displays employment type page
        return view('admin.employmentType.index', compact('employmentTypes'));
    }

    public function show(EmploymentType $employmentType) {
        // displays employment type page
        return view('admin.employmentType.show', compact('employmentType'));
    }

    public function create() {
        // displays create employment type page
        return view('admin.employmentType.create');
    }

    public function store(EmploymentTypeRequest $request) {
        $formdata = $request->validated();
        $order = EmploymentType::count() + 1;
        $formdata['order'] = $order;

        // creates new employment type
        EmploymentType::create($formdata);

        // redirects back to employment type page with success message
        return redirect()->route('admin.employment-type.index')->with('message', 'Employment type created successfully.');
    }

    public function edit(EmploymentType $employmentType) {
        // displays edit employment type page
        return view('admin.employmentType.edit', compact('employmentType'));
    }

    public function update(EmploymentTypeRequest $request, EmploymentType $employmentType) {
        $formdata = $request->validated();

        // updates employment type
        $employmentType->update($formdata);

        // redirects back to employment type page with success message
        return redirect()->route('admin.employment-type.show', $employmentType->id)->with('message', 'Employment type updated successfully.');
    }

    public function delete(EmploymentType $employmentType) {
        // deletes employment type
        $employmentType->delete();

        // redirects back to employment type page with success message
        return redirect()->route('admin.employment-type.index')->with('message', 'Employment type deleted successfully.');
    }

    public function updateOrder(Request $request) {
        // retrieves all employment types
        $employmentTypes = EmploymentType::orderBy('order')->get();
        // displays employment type page
        return view('admin.employmentType.updateOrder', compact('employmentTypes'));
    }

    public function submitOrder(Request $request) {

        // creates array with id as key and order as value
        $orderPairs = $request->validate([
            'order' => 'required|array',
            'order.*' => 'distinct|exists:employment_types,id',
        ])['order'];

        // loops through all employment types
        foreach($orderPairs as $order => $id) {
            // updates order of employment type
            $employmentType = EmploymentType::find($id);
            if($employmentType) {
                $employmentType->update(['order' => $order]);
            }
        }
        // redirects back to employment type page with success message
        return redirect()->back()->with('message', 'Order updated successfully.');
    }
}
