<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaInfoRequest;
use App\Models\Competence;
use App\Models\User;
use Illuminate\View\View;

class MediaController extends Controller
{
    // displays media competence for specific user
    public function show(User $user) : View {
        // checks if user is allowed to access the resource
        $this->authorize('view', $user);
        // loads the competences of the user
        $user->load('competences');
        // displays the view
        return view('media.show', compact('user'));
    }

    // displays the edit form for media competence
    public function edit(User $user) : View {
        // checks if user is allowed to access the resource
        $this->authorize('edit', $user);
        // loads the competences of the user
        $userCompetences = $user->competences()->pluck('name')->toArray();
        // loads all competences that are available
        $allCompetences = Competence::all();

        // checks which contact methods are selected
        $selectedContact = [
            $user->media_mail ? "mail" : NULL,
            $user->media_phone ? "phone" : NULL,
            $user->media_secretariat ? "secretariat" : NULL,
        ];
        // removes all NULL values from the array
        $selectedContact = array_filter($selectedContact, fn ($value) => !is_null($value));

        // displays the view
        return view('media.edit', [
            'user' => $user,
            'userCompetences' => $userCompetences,
            'allCompetences' => $allCompetences,
            'selectedContact' => $selectedContact
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MediaInfoRequest $request, string $id)
    {
        // validates the request
        $formdata = $request->validated();
        // gets the new competences
        $newCompetences = $formdata['media_competences'];
        // gets the contact methods
        $userContact = [
            'media_mail' => in_array("mail", $formdata['contact_method'], true),
            'media_phone' => in_array("phone", $formdata['contact_method'], true),
            'media_secretariat' => in_array("secretariat", $formdata['contact_method'], true)
        ];

        // gets the user
        $user = User::findOrFail($id);
        // checks if user is allowed to access the resource
        $this->authorize('update', $user);
        // updates the competences
        $user->competences()->sync($newCompetences);

        // updates the contact methods
        $user->fill($userContact);
        $user->save();

        // redirects to the overview page
        return redirect()->route('media.show', $user->uid)->with('message', 'Media competences successfully updated.');
    }
}
