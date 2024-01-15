<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalDataRequest;
use App\Models\EmploymentType;
use App\Models\ResearchArea;
use App\Models\TransversalReserachPrio;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        // load research areas and transversal research priorities
        $user->load('researchAreas', 'transversalResearchPriorities', 'employmentType');

        // Display personal data
        return view('user.show', compact('user'));
    }

    public function edit(User $user) {

        $this->authorize('edit', $user);

        // retrieve all possible research areas from DB
        $researchAreaOptions = ResearchArea::all();
        // retrieve selected research areas form DB
        $researchAreas = $user->researchAreas()->pluck('id')->all();

        // retrieve all possible transversal reserach priorities from DB
        $transvResearchPrioOptions = TransversalReserachPrio::all();
        // retrieve selected research areas from DB
        $transvResearchPrios = $user->transversalResearchPriorities()->pluck('id')->all();

        // retrieve all possible employment types from DB
        $employmentTypes = EmploymentType::orderBy('order')->get();
        // retrieve selected employment type from DB
        $user->load('employmentType');

        // retrieve orcid from DB and convert to array
        $orcid = explode('-', $user->orcid);

        // Display edit form
        return view('user.edit', [
            'user' => $user,
            'researchAreaOptions' => $researchAreaOptions,
            'researchAreas' => $researchAreas,
            'transvResearchPrioOptions' => $transvResearchPrioOptions,
            'transvResearchPrios' => $transvResearchPrios,
            'orcid' => $orcid,
            'employmentTypes' => $employmentTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonalDataRequest $request, string $id)
    {
        // retrieves validated form data
        $formData = collect($request->validated());

        // update user data and submit to DB
        $user = User::findOrFail($id);

        $this->authorize('view', $user);

        // check if phone is empty
        $isPhoneEmpty = empty($formData['phone']);
        if($isPhoneEmpty) {
            // sets phone contact method to false
            $user->media_phone = false;
        }

        $user->employmentType()->associate($formData['employment_type']);

        $user->fill($formData->except(['research_areas', 'transv_research_prios', 'employment_type'])->toArray());
        $user->save();

        // compare current database state and remove/insert research areas
        $newResearchAreas = $formData['research_areas'];
        $user->researchAreas()->sync($newResearchAreas);

        // compare current databasae state and remove/insert transversal research priorities
        $newTransvResearchPrios = $formData['transv_research_prios'];
        $user->transversalResearchPriorities()->sync($newTransvResearchPrios);

        // redirect to personal data page
        return redirect()->route('personal.show', $id)->with('message', 'Personal Data successfully updated.');
    }
}
