<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalDataRequest;
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
        // retrieve research areas form DB and check for empty array
        $research_areas = Auth::user()->research_areas ?? [] ;
        // retrieve transversal reserach priorities from DB
        $transv_research_prios = TransversalReserachPrio::all();
        // retrieve orcid from DB and convert to array
        $orcid = explode('-', Auth::user()->orcid);

        // Display edit form
        return view('user.show', [
            'research_areas' => $research_areas,
            'transv_research_prios' => $transv_research_prios,
            'orcid' => $orcid
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonalDataRequest $request)
    {
        // retrieves validated form data
        $formData = $request->validated();

        // update user data and submit to DB
        $user = Auth::user();
        $user->fill($formData);
        $user->save();

        return redirect()->back()->with('message', 'Personal data successfully updated.');
    }
}
