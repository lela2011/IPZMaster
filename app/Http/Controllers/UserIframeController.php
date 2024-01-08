<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserIframeController extends Controller
{
    public function cv(string $language, User $user) {

        if ($language == 'en') {
            $cv = $user->cv_english;
        } else {
            $cv = $user->cv_german;
        }
        return view('user.iframes.cv', compact('cv'));
    }

    public function researchFocus(string $language, User $user) {

        if ($language == 'en') {
            $title = 'Research Focus';
            $researchFocus = $user->research_focus_english;
        } else {
            $title = "Forschungsschwerpunkte";
            $researchFocus = $user->research_focus_german;
        }
        return view('user.iframes.research-focus', compact('researchFocus'), compact('title'));
    }

    public function researchAreas(string $language, User $user) {
        $user->load('researchAreas');
        $researchAreas = $user->researchAreas->map(function ($researchArea) use ($language) {
            return [
                'name' => $language == 'en' ? $researchArea->english : $researchArea->german,
                'url' => $language == 'en' ? $researchArea->english_url : $researchArea->german_url
            ];
        });

        $title = $language == 'en' ? 'Research area' : 'Forschungsbereich';
        return view('user.iframes.research-areas', compact('title'), compact('researchAreas'));
    }

    public function transversalResearchPrios(string $language, User $user) {
        $user->load('transversalResearchPriorities');
        if($language == 'en') {
            $transversalResearchPrios = $user->transversalResearchPriorities->pluck('english');
            $title = 'Transversal research priorities at the IPZ';
        } else {
            $transversalResearchPrios = $user->transversalResearchPriorities->pluck('german');
            $title = 'Transversale Forschungsschwerpunkte am IPZ';
        }
        return view('user.iframes.transversal-research-prorities', compact('title'), compact('transversalResearchPrios'));
    }

    public function currentResearchProjects(string $language, User $user) {
        $user->load('projects');
        $currentTime = now();

        $projects = $user->projects()
            ->where('publish', true)
            ->where('start_date', '<=', $currentTime)
            ->where('end_date', '>=', $currentTime)
            ->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'asc')
            ->paginate(10);

        if($language == 'en') {
            return view('user.iframes.research-projects.en.current-research-projects', compact('projects'));
        } else {
            return view('user.iframes.research-projects.de.current-research-projects', compact('projects'));
        }

    }

    public function completedResearchProjects(string $language, User $user) {
        $user->load('projects');
        $currentTime = now();

        $projects = $user->projects()
            ->where('publish', true)
            ->where('end_date', '<', $currentTime)
            ->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'desc')
            ->paginate(10);

        if($language == 'en') {
            return view('user.iframes.research-projects.en.completed-research-projects', compact('projects'));
        } else {
            return view('user.iframes.research-projects.de.completed-research-projects', compact('projects'));
        }
    }

    public function orcid(string $language, User $user) {
        $orcid = $user->orcid;
        return view('user.iframes.orcid', compact('orcid'));
    }
}
