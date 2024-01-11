<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchAreaRequest;
use App\Models\ResearchArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResearchAreaController extends Controller
{

    public function show(ResearchArea $researchArea)
    {
        $user = Auth::user();
        $this->authorize('view', $user);

        // Display research area page
        return view('researchArea.show', compact('researchArea'));
    }

    public function edit(ResearchArea $researchArea) {

        $user = Auth::user();
        $this->authorize('edit', $user);

        // Display edit form
        return view('researchArea.edit', compact('researchArea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResearchAreaRequest $request, ResearchArea $researchArea)
    {
        $user = Auth::user();
        $this->authorize('update', $user);
        // retrieves validated form data
        $formData = collect($request->validated());

        // update research area data and submit to DB
        $researchArea->fill($formData->toArray());
        $researchArea->save();

        // redirect to research area page
        return redirect()->route('research-area.show', $researchArea->id)->with('message', 'Research Area successfully updated.');
    }
}
