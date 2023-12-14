<?php

namespace App\Http\Controllers;

use App\Models\ExternalContact;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExternalContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // validates filter to reduce the danger of SQL injections
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|string'
        ]);

        // checks if validation failed
        if ($validator->fails()) {
            // redirects to index page to display error message
            return redirect()->route('externalContact.index')->withErrors($validator)->withInput();
        }

        $externalContactQuery = ExternalContact::query();

        if($request->has('filter')) {
            // prepares filter value
            $filterValue = "%" . $request->input('filter') . "%";
            // applies filter to query
            $externalContactQuery->where('name', 'like', $filterValue);
        }

        // gets all external contacts from DB
        $externalContacts = $externalContactQuery->get();

        // returns index view with external contacts
        return view('externalContact.index', [
            'externalContacts' => $externalContacts,
            'filter' => $request->input('filter')
        ]);
    }

    public function createJSON(Request $request) {

        // retrieves entered name into modal
        $name = $request->input('name');
        // retrieves entered email into modal
        $email = $request->input('email');
        // retrieves entered organization into modal
        $organization = $request->input('organization');

        // checks if name is empty
        $emptyName = empty($name);
        // checks if email is empty
        $emptyMail = empty($email);
        // checks if email is valid
        $invalidMail = !filter_var($email, FILTER_VALIDATE_EMAIL);

        // sets failure messages
        if($emptyName || $emptyMail ||$invalidMail) {
            $responseData = [
                'isValid' => false,
                'errorMessages' => [
                    'emptyNameError' => $emptyName,
                    'emptyMailError' => $emptyMail,
                    'invalidMailError' => !$emptyMail && $invalidMail,
                    'duplicateMailError' => false
                ]
            ];

            // returns failure and errors
            return response()->json($responseData);
        }
        try {

            $data = [
                'name' => $name,
                'email' => $email,
            ];

            if (!empty($organization)) {
                $data['organization'] = $organization;
            }

            // tries to create external contact
            $newContact = ExternalContact::create($data);

            // returns success as well as details
            return response()->json([
                'isValid' => true,
                'contactId' => $newContact->id,
                'contactName' => $newContact->name,
                'organization' => $newContact->organization
            ]);
        } catch (UniqueConstraintViolationException) { // handles already existing email
            // sets errors
            $responseData = [
                'isValid' => false,
                'errorMessages' => [
                    'emptyNameError' => false,
                    'emptyMailError' => false,
                    'invalidMailError' => false,
                    'duplicateMailError' => true
                ]
            ];
             // returns failure and errors
            return response()->json($responseData);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('externalContact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validates form data
        $formData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:external_contacts,email',
            'organization' => 'nullable|string'
        ],[
            'name.required' => 'Please enter a name.',
            'email.required' => 'Please enter an email.',
            'email.email' => 'The entered email is not valid.',
            'email.unique' => 'A user with the entered email already exists.'
        ]);

        if (!isset($formData['organization'])) {
            // Remove 'organization' from the array
            unset($formData['organization']);
        }

        // creates external contact
        ExternalContact::create($formData);

        // redirects to index page with success message
        return redirect()->route('externalContact.index')->with('message', 'External contact created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalContact $externalContact)
    {
        return view('externalContact.edit', [
            'externalContact' => $externalContact
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validates form data
        $formData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'organization' => 'nullable|string'
        ],[
            'name.required' => 'Please enter a name.',
            'email.required' => 'Please enter an email.',
            'email.email' => 'The entered email is not valid.',
        ]);

        // current external contact
        $externalContact = ExternalContact::findOrFail($id);

        // updates external contact
        $externalContact->update($formData);

        // redirects to index page with success message
        return redirect()->route('externalContact.index')->with('message', 'External contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalContact $externalContact)
    {
        // checks if external contact is used in a research project
        $isUsed = count($externalContact->contactProjects()->get()) != 0;

        if ($isUsed) {
            // redirects to index page with error message
            return redirect()->route('externalContact.index')->with('errorMessage', 'The external contact is used in a research project and cannot be deleted.');
        }

        // deletes external contact
        $externalContact->delete();

        // redirects to index page with success message
        return redirect()->route('externalContact.index')->with('message', 'External contact deleted successfully.');
    }
}
