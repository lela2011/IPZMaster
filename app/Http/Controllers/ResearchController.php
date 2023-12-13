<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchRequest;
use App\Models\ExternalContact;
use App\Models\ResearchArea;
use App\Models\ResearchProject;
use App\Models\User;
use App\Models\TransversalReserachPrio;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Webpatser\Countries\Countries;

class ResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        //dd($request->all());

        // validates filter to reduce the danger of SQL injections
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|string'
        ]);

        // checks if validation failed
        if ($validator->fails()) {
            // redirects to index page to display error message
            return redirect()->route('research.index')->withErrors($validator)->withInput();
        }

        // prepares query for managable projects
        $manageableQuery = Auth::user()->projects()->wherePivot('role', 'leader');
        // prepares query for viewable projects
        $memberQuery = Auth::user()->projects()->wherePivot('role', 'member');

        // checks if filter is set
        if($request->has('filter')) {
            // prepares filter value
            $filterValue = "%" . $request->input('filter') . "%";
            // applies filter to both queries
            $manageableQuery->where('title', 'like', $filterValue);
            $memberQuery->where('title', 'like', $filterValue);
        }

        // retrieves all editable projects for a given user after filter was applied
        $manageableProjects = $manageableQuery->get();
        // retrieves all usable projects for a given user after filter was applied
        $memberProjects = $memberQuery->get();

        // displays list page
        return view('research.index', [
            'manageableProjects' => $manageableProjects,
            'memberProjects' => $memberProjects,
            'filter' => $request->input('filter')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // retrieves all transversal research priorities
        $transvResearchPrios = TransversalReserachPrio::select('id', 'english')->get();
        // retrieves all research areas
        $researchAreas = ResearchArea::select('id', 'english')->get();
        // retrieves all internal contacts
        $ipzMembers = User::select('uid', 'first_name', 'last_name')->get();
        // retrieves all external contacts
        $externalContacts = ExternalContact::select('id', 'name')->get();

        // displays create page
        return view('research.create', [
            'ipzMembers' => $ipzMembers,
            'externalContacts' => $externalContacts,
            'transvResearchPrios' => $transvResearchPrios,
            'researchAreas' => $researchAreas
        ]);
    }

    public function createContact(Request $request) {

        // retrieves entered name into modal
        $name = $request->input('name');
        // retrieves entered email into modal
        $email = $request->input('email');

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
            // tries to create external contact
            $newContact = ExternalContact::create([
                'name' => $name,
                'email' => $email
            ]);

            // returns success as well as details
            return response()->json([
                'isValid' => true,
                'contactId' => $newContact->id,
                'contactName' => $newContact->name . " (external)"
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
     * Store a newly created resource in storage.
     */
    public function store(ResearchRequest $request)
    {
        // validate data
        $formData = collect($request->validated());

        // creates new research project and saves it in DB
        $researchProject = new ResearchProject($formData->except(['leaders', 'members', 'contacts', 'transv_research_prios', 'research_areas'])->toArray());
        $researchProject->save();

        // sets relation between leaders and research project
        $syncLeaderData = array_fill_keys($formData['leaders'], ['role' => 'leader']);
        $researchProject->leaders()->attach($syncLeaderData);

        // sets relation between members and research project
        $syncMemberData = array_fill_keys($formData['members'], ['role' => 'member']);
        $researchProject->members()->attach($syncMemberData);

        // sets relation between transversal research priorities and research project
        $researchProject->transversalResearchPrios()->attach($formData['transv_research_prios']);

        // sets relation between research areas and research project
        $researchProject->researchAreas()->attach($formData['research_areas']);

        // sorts contact ids into internal and external contacts
        $contactIds = array_reduce($formData['contacts'], function ($result, $id) {
            [$idValue, $extension] = explode('.', $id);
            $result[$extension][] = $idValue;
            return $result;
        }, []);

        $intContacts = $contactIds['int'] ?? [];
        $extContacts = $contactIds['ext'] ?? [];

        // sets relation between contacts and research project
        $researchProject->internalContacts()->attach($intContacts);
        $researchProject->externalContacts()->attach($extContacts);

        // redirects to index page to display success message
        return redirect()->route('research.index')->with('message', 'Research project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ResearchProject $research)
    {
        // loads all realtions
        $research->load('internalContacts', 'externalContacts', 'researchAreas', 'transversalResearchPrios');

        // displays show page
        return view('research.show', compact('research'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResearchProject $research)
    {
        // checks if user is authorized to edit the research project
        $this->authorize('edit', $research);

        // retrieves all transversal research priorities
        $transvResearchPrios = TransversalReserachPrio::select('id', 'english')->get();
        // retrieves all research areas
        $researchAreas = ResearchArea::select('id', 'english')->get();
        // retrieves all internal contacts
        $ipzMembers = User::select('uid', 'first_name', 'last_name')->get();
        // retrieves all external contacts
        $externalContacts = ExternalContact::select('id', 'name')->get();
        // loads all relations
        $research->load('leaders', 'members', 'internalContacts', 'externalContacts', 'researchAreas', 'transversalResearchPrios');

        // displays edit page
        return view('research.edit', [
            'researchProject' => $research,
            'ipzMembers' => $ipzMembers,
            'externalContacts' => $externalContacts,
            'transvResearchPrios' => $transvResearchPrios,
            'researchAreas' => $researchAreas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResearchRequest $request, string $id)
    {
        // retrieves research project
        $researchProject = ResearchProject::find($id);

        // checks if user is authorized to update the research project
        $this->authorize('update', $researchProject);

        // validate data
        $formData = collect($request->validated());

        // updates research project
        $researchProject->update($formData->except(['leaders', 'members', 'contacts', 'transv_research_prios', 'research_areas'])->toArray());

        // sets relation between leaders and research project
        $syncLeaderData = array_fill_keys($formData['leaders'], ['role' => 'leader']);
        $researchProject->leaders()->sync($syncLeaderData);

        // sets relation between members and research project
        $syncMemberData = array_fill_keys($formData['members'], ['role' => 'member']);
        $researchProject->members()->sync($syncMemberData);

        // sets relation between transversal research priorities and research project
        $researchProject->transversalResearchPrios()->sync($formData['transv_research_prios']);

        // sets relation between research areas and research project
        $researchProject->researchAreas()->sync($formData['research_areas']);

        // sorts contact ids into internal and external contacts
        $contactIds = array_reduce($formData['contacts'], function ($result, $id) {
            [$idValue, $extension] = explode('.', $id);
            $result[$extension][] = $idValue;
            return $result;
        }, []);

        $intContacts = $contactIds['int'] ?? [];
        $extContacts = $contactIds['ext'] ?? [];

        // sets relation between contacts and research project
        $researchProject->internalContacts()->sync($intContacts);
        $researchProject->externalContacts()->sync($extContacts);

        $researchProject->save();

        // redirects to index page to display success message
        return redirect()->route('research.index')->with('message', 'Research project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResearchProject $research)
    {
        // checks if user is authorized to delete the research project
        $this->authorize('delete', $research);
        // deletes the research Project
        $research->delete();

        // redirects to index page to display success message
        return redirect()->route('research.index')->with('message', 'Research project deleted successfully');
    }
}
