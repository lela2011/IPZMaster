<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompetenceIframeController extends Controller
{
    public function competence(Request $request, string $language) {
        $validator = Validator::make($request->all(), [
            'filter' => 'nullable|array',
            'filter.*' => 'string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $allCompetences = Competence::all();

        $competencesQuery = Competence::query()->whereHas('users');
        if($request->has('filter')) {
            $filter = $request->input('filter');
            $competencesQuery->whereIn('id',$filter)->get();
        }
        $competences = $competencesQuery->get()->load('users');

        return view('media.iframe.competence-finder-de', [
            'filter' => $request->input('filter'),
            'competences' => $competences,
            'allCompetences' => $allCompetences
        ]);
    }
}
