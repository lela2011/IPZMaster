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
use Illuminate\View\View;
use Webpatser\Countries\Countries;

class ResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        // retrieves all editable projects for a given user
        $manageableProjects = Auth::user()->projects()->wherePivot('role', 'leader')->get();
        // retrieves all usable projects for a given user
        $memberProjects = Auth::user()->projects()->wherePivot('role', 'member')->get();

        // displays list page
        return view('research.list', [
            'manageableProjects' => $manageableProjects,
            'memberProjects' => $memberProjects
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
        foreach ($formData['leaders'] as $leader) {
            $researchProject->associates()->attach($leader, ['role' => 'leader']);
        }

        // sets relation between members and research project
        foreach ($formData['members'] as $member) {
            $researchProject->associates()->attach($member, ['role' => 'member']);
        }

        // sets relation between transversal research priorities and research project
        $transvResearchPrios = $formData->only('transv_research_prios')->toArray();
        foreach ($transvResearchPrios as $prio) {
            $researchProject->transversalResearchPrios()->attach($prio);
        }

        // sets relation between research areas and research project
        $researchAreas = $formData->only('research_areas')->toArray();
        foreach ($researchAreas as $area) {
            $researchProject->researchAreas()->attach($area);
        }

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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
