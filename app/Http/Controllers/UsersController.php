<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalDataRequest;
use App\Models\ResearchArea;
use App\Models\TransversalReserachPrio;
use App\Rules\OrcidValidation;
use Faker\Provider\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // retrieve all possible research areas from DB
        $researchAreaOptions = ResearchArea::all();
        // retrieve selected research areas form DB
        $researchAreas = Auth::user()->researchAreas()->pluck('id')->all();

        // retrieve all possible transversal reserach priorities from DB
        $transvResearchPrioOptions = TransversalReserachPrio::all();
        // retrieve selected research areas from DB
        $transvResearchPrios = Auth::user()->transversalResearchPriorities()->pluck('id')->all();

        // retrieve orcid from DB and convert to array
        $orcid = explode('-', Auth::user()->orcid);

        // Display edit form
        return view('user.show', [
            'researchAreaOptions' => $researchAreaOptions,
            'researchAreas' => $researchAreas,
            'transvResearchPrioOptions' => $transvResearchPrioOptions,
            'transvResearchPrios' => $transvResearchPrios,
            'orcid' => $orcid
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonalDataRequest $request)
    {
        // retrieves validated form data
        $formData = collect($request->validated());

        // update user data and submit to DB
        $user = Auth::user();
        $user->fill($formData->except(['research_areas', 'transv_research_prios'])->toArray());
        $user->save();

        // compare current database state and remove/insert research areas
        $currentResearchAreas = $user->researchAreas()->pluck('id')->all();
        $newResearchAreas = $formData['research_areas'];
        $insertResearchAreas = array_diff($newResearchAreas, $currentResearchAreas);
        $removeResearchAreas = array_diff($currentResearchAreas, $newResearchAreas);
        $user->researchAreas()->attach($insertResearchAreas);
        $user->researchAreas()->detach($removeResearchAreas);

        // compare current databasae state and remove/insert transversal research priorities
        $currentTransvResearchPrios = Auth::user()->transversalResearchPriorities()->pluck('id')->all();
        $newTransvResearchPrios = $formData['transv_research_prios'];
        $insertTransvResearchPrios = array_diff($newTransvResearchPrios, $currentTransvResearchPrios);
        $removeTransvResearchPrios = array_diff($currentTransvResearchPrios, $newTransvResearchPrios);
        $user->transversalResearchPriorities()->attach($insertTransvResearchPrios);
        $user->transversalResearchPriorities()->detach($removeTransvResearchPrios);

        return redirect()->back()->with('message', 'Personal data successfully updated.');
    }
}
