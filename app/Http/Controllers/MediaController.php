<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaInfoRequest;
use App\Models\Competence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MediaController extends Controller
{

    public function show(User $user) : View {
        $this->authorize('view', $user);

        $user->load('competences');
        return view('media.show', compact('user'));
    }

    public function edit(User $user) : View {
        $this->authorize('edit', $user);

        $userCompetences = $user->competences()->pluck('name')->toArray();
        $allCompetences = Competence::all();

        $selectedContact = [
            $user->media_mail ? "mail" : NULL,
            $user->media_phone ? "phone" : NULL,
            $user->media_secretariat ? "secretariat" : NULL,
        ];
        $selectedContact = array_filter($selectedContact, fn ($value) => !is_null($value));

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

        $formdata = $request->validated();

        $newCompetences = $formdata['media_competences'];

        $userContact = [
            'media_mail' => in_array("mail", $formdata['contact_method'], true),
            'media_phone' => in_array("phone", $formdata['contact_method'], true),
            'media_secretariat' => in_array("secretariat", $formdata['contact_method'], true)
        ];

        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $user->competences()->sync($newCompetences);

        $user->fill($userContact);
        $user->save();

        return redirect()->route('media.show', $user->uid)->with('message', 'Media competences successfully updated.');
    }
}
