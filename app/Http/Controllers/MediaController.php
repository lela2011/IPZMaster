<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaInfoRequest;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $userCompetences = Auth::user()->competences()->pluck('competence')->toArray();
        $allCompetences = Competence::all();

        $user = Auth::user();
        $selectedContact = [
            $user->media_mail ? "mail" : NULL,
            $user->media_phone ? "phone" : NULL,
            $user->media_secretariat ? "secretariat" : NULL,
        ];
        $selectedContact = array_filter($selectedContact, fn ($value) => !is_null($value));

        return view('media.list', [
            'userCompetences' => $userCompetences,
            'allCompetences' => $allCompetences,
            'selectedContact' => $selectedContact
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MediaInfoRequest $request)
    {
        $formdata = $request->validated();

        $newCompetences = $formdata['media_competences'];

        $userContact = [
            'media_mail' => in_array("mail", $formdata['contact_method'], true),
            'media_phone' => in_array("phone", $formdata['contact_method'], true),
            'media_secretariat' => in_array("secretariat", $formdata['contact_method'], true)
        ];

        $user = Auth::user();

        $user->competences()->sync($newCompetences);

        $user->fill($userContact);
        $user->save();

        return redirect()->back()->with('message', 'Media competences successfully updated.');
    }

    public function createCompetence(Request $request) {
        // retrieves entered competence
        $name = $request->input('competence');

        try{
            Competence::create([
                'competence' => $name
            ]);

            return response()->json([
                'success' => true,
                'competence' => $name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }
}