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

        $filter = $request->input('filter') ?? [];
        $competences = Competence::query()->whereHas('users')->whereIn('id',$filter)->get()->load('users');

        if($language == "en") {
            $view = 'media.iframe.competence-finder-en';
        } else {
            $view = 'media.iframe.competence-finder-de';
        }

        return view($view, [
            'filter' => $request->input('filter'),
            'competences' => $competences,
            'allCompetences' => $allCompetences
        ]);
    }
}
