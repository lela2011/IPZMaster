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
        $externalContacts = ExternalContact::select('id', 'name', 'organization')->get();

        // displays create page
        return view('research.create', [
            'ipzMembers' => $ipzMembers,
            'externalContacts' => $externalContacts,
            'transvResearchPrios' => $transvResearchPrios,
            'researchAreas' => $researchAreas
        ]);
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
        if(Auth::user()->adminLevel > 0) {
            return redirect()->route('admin.research')->with('message', 'Research project created successfully');
        } else {
            return redirect()->route('research.index')->with('message', 'Research project created successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ResearchProject $researchProject)
    {
        // loads all realtions
        $researchProject->load('internalContacts', 'externalContacts', 'researchAreas', 'transversalResearchPrios');

        // displays show page
        return view('research.show', compact('researchProject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResearchProject $researchProject)
    {
        // checks if user is authorized to edit the research project
        $this->authorize('edit', $researchProject);

        // retrieves all transversal research priorities
        $transvResearchPrios = TransversalReserachPrio::select('id', 'english')->get();
        // retrieves all research areas
        $researchAreas = ResearchArea::select('id', 'english')->get();
        // retrieves all internal contacts
        $ipzMembers = User::select('uid', 'first_name', 'last_name')->get();
        // retrieves all external contacts
        $externalContacts = ExternalContact::select('id', 'name', 'organization')->get();
        // loads all relations
        $researchProject->load('leaders', 'members', 'internalContacts', 'externalContacts', 'researchAreas', 'transversalResearchPrios');

        // displays edit page
        return view('research.edit', [
            'researchProject' => $researchProject,
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
        $researchProject = ResearchProject::findOrFail($id);

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
        if(Auth::user()->adminLevel > 1) {
            return redirect()->route('admin.research')->with('message', 'Research project updated successfully');
        } else {
            return redirect()->route('research.index')->with('message', 'Research project updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResearchProject $researchProject)
    {
        // checks if user is authorized to delete the research project
        $this->authorize('delete', $researchProject);
        // deletes the research Project
        $researchProject->delete();

        // redirects to index page to display success message
        if(Auth::user()->adminLevel > 1) {
            return redirect()->route('admin.research')->with('message', 'Research project deleted successfully');
        } else {
            return redirect()->route('research.index')->with('message', 'Research project deleted successfully');
        }
    }
}
