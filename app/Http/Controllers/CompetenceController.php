<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompetenceController extends Controller
{
    public function index(Request $request)
    {
        // validates filter to reduce the danger of SQL injections
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|string'
        ]);

        // checks if validation failed
        if ($validator->fails()) {
            // redirects to index page to display error message
            return redirect()->route('competence.index')->withErrors($validator)->withInput();
        }

        $competenceQuery = Competence::query();

        if($request->has('filter')) {
            // prepares filter value
            $filterValue = "%" . $request->input('filter') . "%";
            // applies filter to query
            $competenceQuery->where('name', 'like', $filterValue);
        }

        // gets all external contacts from DB
        $competences = $competenceQuery->get();

        // returns index view with external contacts
        return view('competence.index', [
            'competences' => $competences,
            'filter' => $request->input('filter')
        ]);
    }

    public function createJSON(Request $request) {
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

    public function update(Competence $competence, Request $request)
    {
        // validates input to reduce the danger of SQL injections
        $validator = Validator::make($request->all(), [
            'competence' => 'required|string'
        ]);

        // checks if validation failed
        if ($validator->fails()) {
            // redirects to index page to display error message
            return redirect()->route('competence.index')->with('errorMessage', 'The competence could not be updated. Please try again.');
        }

        // update competence
        $competence->name = $request->input('competence');
        $competence->save();

        // redirects to index page to display success message
        return redirect()->route('competence.index')->with('message', 'Competence updated successfully');
    }

    public function store(Request $request)
    {
        // validates input to reduce the danger of SQL injections
        $formInput = $request->validate([
            'competence' => 'required|string|unique:competences,name'
        ],[
            'competence.unique' => 'The competence already exists.',
            'competence.required' => 'Please enter a competence.'
        ]);

        // creates new competence
        Competence::create([
            'name' => $request->input('competence')
        ]);

        // redirects to index page to display success message
        return redirect()->route('competence.index')->with('message', 'Competence created successfully');
    }

    public function destroy(Competence $competence)
    {

        $isUsed = count($competence->users()->get()) != 0;

        if ($isUsed) {
            // redirects to index page with error message
            return redirect()->route('competence.index')->with('errorMessage', 'The competence is used by a user and cannot be deleted.');
        }

        // deletes external contact
        $competence->delete();

        // redirects to index page with success message
        return redirect()->route('competence.index')->with('message', 'Competence deleted successfully.');
    }
}
