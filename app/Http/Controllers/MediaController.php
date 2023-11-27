<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaInfoRequest;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(MediaInfoRequest $request)
    {
        $formdata = $request->validated();

        $currentCompetences = Auth::user()->competences()->pluck('competence')->toArray();
        $newCompetences = $formdata['media_competences'];

        $insert = array_diff($newCompetences, $currentCompetences);
        $remove = array_diff($currentCompetences, $newCompetences);

        $userContact = [
            'media_mail' => in_array("mail", $formdata['contact_method'], true),
            'media_phone' => in_array("phone", $formdata['contact_method'], true),
            'media_secretariat' => in_array("secretariat", $formdata['contact_method'], true)
        ];

        $user = Auth::user();

        $user->competences()->attach($insert);
        $user->competences()->detach($remove);

        $user->fill($userContact);
        $user->save();

        return redirect()->back()->with('message', 'Media competences successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
