<?php

namespace App\Http\Controllers;

use App\Models\TransversalReserachPrio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminTransvResearchPrioController extends Controller
{
    // display a list of all transversal research priorities
    public function index(Request $request) {
        $prios = TransversalReserachPrio::all();

        return view('admin.transvResearchPrio.index', compact('prios'));
    }

    // create a new transversal research priority
    public function create(Request $request) {
        return view('admin.transvResearchPrio.create');
    }

    // store a new transversal research priority in the DB
    public function store(Request $request) {
        // validates input
        $formdata = $request->validate([
            'english' => 'required|string|unique:transv_research_prios,english',
            'german' => 'required|string|unique:transv_research_prios,german',
        ], [
            'english.required' => 'English name is required',
            'english.string' => 'English name must be a string',
            'english.unique' => 'English name must be unique',
            'german.required' => 'German name is required',
            'german.string' => 'German name must be a string',
            'german.unique' => 'German name must be unique',
        ]);

        // creates the priority
        TransversalReserachPrio::create($formdata);

        // redirects to the index page
        return redirect()->route('admin.transversal-research-prio.index')->with('message', 'Transversal Research priority created successfully');
    }

    // display a specific transversal research priority
    public function show(TransversalReserachPrio $prio) {
        return view('admin.transvResearchPrio.show', compact('prio'));
    }

    // edit a specific transversal research priority
    public function edit(TransversalReserachPrio $prio) {
        return view('admin.transvResearchPrio.edit', compact('prio'));
    }

    // update a specific transversal research priority in the DB
    public function update(Request $request, TransversalReserachPrio $prio) {
        // validates input
        $formdata = $request->validate([
            'english' => 'required', 'string', Rule::unique('transv_research_prios', 'english')->ignore($prio->id),
            'german' => 'required', 'string', Rule::unique('transv_research_prios', 'german')->ignore($prio->id),
        ],[
            'english.required' => 'English name is required',
            'english.string' => 'English name must be a string',
            'english.unique' => 'English name must be unique',
            'german.required' => 'German name is required',
            'german.string' => 'German name must be a string',
            'german.unique' => 'German name must be unique',
        ]);

        // updates the priority
        $prio->update($formdata);

        // redirects to the index page
        return redirect()->route('admin.transversal-research-prio.show', $prio->id)->with('message', 'Transversal Research priority updated successfully');
    }

    // delete a specific transversal research priority from the DB
    public function delete(TransversalReserachPrio $prio) {
        // deletes the priority
        $prio->delete();

        // redirects to the index page
        return redirect()->route('admin.transversal-research-prio.index')->with('message', 'Transversal Research priority deleted successfully');
    }
}
