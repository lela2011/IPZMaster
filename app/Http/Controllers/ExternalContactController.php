<?php

namespace App\Http\Controllers;

use App\Models\EmploymentType;
use App\Models\ExternalContact;
use App\Models\ResearchArea;
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
        // retrieve all possible research areas from DB
        $researchAreaOptions = ResearchArea::all();

        // retrieve all possible employment types from DB
        $employmentTypes = EmploymentType::orderBy('order')->get();

        return view('externalContact.create', compact('researchAreaOptions', 'employmentTypes'));
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
            'url' => 'nullable|url',
            'url_en' => 'nullable|url',
            'organization' => 'nullable|string',
            'research_areas' => 'nullable|array',
            'research_areas.*' => 'exists:research_areas,id',
            'employment_type' => 'nullable|exists:employment_types,id'
        ],[
            'name.required' => 'Please enter a name.',
            'email.required' => 'Please enter an email.',
            'email.email' => 'The entered email is not valid.',
            'email.unique' => 'A user with the entered email already exists.',
            'url.url' => "The entered url is not valid",
            'url_en.url' => "The entered url is not valid",
            'research_areas.*.exists' => 'The selected research area is invalid.',
            'employment_type.exists' => 'The selected employment type is invalid.'
        ]);

        if (!isset($formData['organization'])) {
            // Remove 'organization' from the array
            unset($formData['organization']);
        }

        $formData = collect($formData);

        // creates external contact
        $externalContact = ExternalContact::create($formData->except('research_areas')->toArray());
        // attaches research areas to external contact
        $externalContact->researchAreas()->attach($formData->get('research_areas'));

        // redirects to index page with success message
        return redirect()->route('externalContact.index')->with('message', 'External Contact created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalContact $externalContact)
    {
        // retrieve all possible research areas from DB
        $researchAreaOptions = ResearchArea::all();
        // loads research areas
        $researchAreas = $externalContact->researchAreas()->pluck('id')->all();

        // retrieve all possible employment types from DB
        $employmentTypes = EmploymentType::orderBy('order')->get();
        // retrieve selected employment type from DB
        $externalContact->load('employmentType');

        return view('externalContact.edit', compact('externalContact', 'researchAreaOptions', 'researchAreas', 'employmentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validates form data
        $formData = collect($request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'url' => 'nullable|url',
            'url_en' => 'nullable|url',
            'organization' => 'nullable|string',
            'research_areas' => 'nullable|array',
            'research_areas.*' => 'exists:research_areas,id',
            'employment_type' => 'nullable|exists:employment_types,id'
        ],[
            'name.required' => 'Please enter a name.',
            'email.required' => 'Please enter an email.',
            'email.email' => 'The entered email is not valid.',
            'url.url' => "The entered url is not valid",
            'url_en.url' => "The entered url is not valid",
            'research_areas.*.exists' => 'The selected research area is invalid.',
            'employment_type.exists' => 'The selected employment type is invalid.'
        ]));

        // current external contact
        $externalContact = ExternalContact::findOrFail($id);

        // updates external contact
        $externalContact->update($formData->except('research_areas')->toArray());
        // syncs research areas with external contact
        $externalContact->researchAreas()->sync($formData->get('research_areas'));

        // redirects to index page with success message
        return redirect()->route('externalContact.index')->with('message', 'External Contact updated successfully.');
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
        return redirect()->route('externalContact.index')->with('message', 'External Contact deleted successfully.');
    }
}
