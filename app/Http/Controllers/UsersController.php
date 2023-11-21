<?php

namespace App\Http\Controllers;

use App\Models\TransversalReserachPrio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // retrieve research areas form DB and check for empty List
        $research_areas = Auth::user()->employeeProfile->research_areas ?? [] ;
        // retrieve transversal reserach priorities from DB
        $transv_research_prios = TransversalReserachPrio::all();

        // Display edit form
        return view('user.show', [
            'research_areas' => $research_areas,
            'transv_research_prios' => $transv_research_prios
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        // retrieve form data
        $formData = $request->except('_token');
        // remove empty input field from research areas array
        array_pop($formData['research_areas']);

        /*
        // check if ORCID has valid check digit (https://support.orcid.org/hc/en-us/articles/360006897674-Structure-of-the-ORCID-Identifier)
        $validORCID = $this->validateORCID($formData['orcid']);
        if(!$validORCID) {

        }*/

        // update user data and submit to DB
        $user = Auth::user()->employeeProfile;
        $user->fill($formData);
        $user->save();

        return redirect()->back();
    }

    // function that validates ORCID Checksum.
    public function validateORCID(String $orcid) {

        // Remove hyphens
        $cleanedOrcid = str_replace('-', '', $orcid);
        // Remove check digit
        $orcidNoFinal = substr($cleanedOrcid, 0, -1);

        // Generate check digit. Copied from https://support.orcid.org/hc/en-us/articles/360006897674-Structure-of-the-ORCID-Identifier
        $total = 0;
        foreach(str_split($orcidNoFinal) as $char) {
            $digit = intval($char);
            $total = ($total + $digit) * 2;
        }
        $remainder = $total % 11;
        $result = (12 - $remainder) % 11;
        $checkDigit = $result == 10 ? "X" : strval($result);

        // Compare if generated check digit is equal to provided one
        return substr($cleanedOrcid, -1) === $checkDigit;
    }
}
