<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            $competence = Competence::create([
                'name' => $name
            ]);

            return response()->json([
                'success' => true,
                'id' => $competence->id,
                'competence' => $competence->name
            ]);

        } catch(UniqueConstraintViolationException) {
            return response()->json([
                'success' => false,
                'error' => 'The competence already exists in the list'
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'error' => 'The competence could not be created. Please try again.'
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

        $userCount = count($competence->users()->get());
        $isOnlyUser = $competence->users()->where('uid', Auth::user()->id)->count() === 1;
        $isAdminUser = Auth::user()->adminLevel > 0;

        $editable = true;

        if(!$isAdminUser) {
            if ($userCount > 0) {
                if($userCount === 1) {
                    if($isOnlyUser) {
                        $editable = true;
                    } else {
                        $editable = false;
                    }
                } else {
                    $editable = false;
                }
            }
        }

        if (!$editable) {
            // redirects to index page with error message
            return redirect()->route('competence.index')->with('errorMessage', 'The competence is used by a user and cannot be updated.');
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

        $userCount = count($competence->users()->get());
        $isOnlyUser = $competence->users()->where('uid', Auth::user()->id)->count() === 1;
        $isAdminUser = Auth::user()->adminLevel > 0;

        $deletable = true;

        if(!$isAdminUser) {
            if ($userCount > 0) {
                if($userCount === 1) {
                    if($isOnlyUser) {
                        $deletable = true;
                    } else {
                        $deletable = false;
                    }
                } else {
                    $deletable = false;
                }
            }
        }

        if (!$deletable) {
            // redirects to index page with error message
            return redirect()->route('competence.index')->with('errorMessage', 'The competence is used by a user and cannot be deleted.');
        }

        // deletes external contact
        $competence->delete();

        // redirects to index page with success message
        return redirect()->route('competence.index')->with('message', 'Competence deleted successfully.');
    }
}
