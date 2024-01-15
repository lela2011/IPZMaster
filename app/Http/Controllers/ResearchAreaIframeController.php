<?php

namespace App\Http\Controllers;

use App\Models\EmploymentType;
use App\Models\ResearchArea;
use App\Models\User;
use Illuminate\Http\Request;

class ResearchAreaIframeController extends Controller
{
    public function description(string $language, ResearchArea $researchArea)
    {
        // checks for language and returns view with description accordingly
        if($language == 'en') {
            $description = $researchArea->description_english;
        } else {
            $description = $researchArea->description_german;
        }
        return view('researchArea.iframes.description', compact('description'));
    }

    public function researchFocus(string $language, ResearchArea $researchArea)
    {
        // checks for language and returns view with research focus accordingly
        if($language == 'en') {
            $researchFocus = $researchArea->research_focus_english;
            $title = 'Research Focus';
        } else {
            $title = "Forschungsschwerpunkte";
            $researchFocus = $researchArea->research_focus_german;
        }
        return view('researchArea.iframes.researchFocus', compact('researchFocus', 'title'));
    }

    public function teaching(string $language, ResearchArea $researchArea) {
        // checks for language and returns view with teaching accordingly
        if($language == 'en') {
            $teaching = $researchArea->teaching_english;
            $title = 'Teaching and Supervision';
        } else {
            $teaching = $researchArea->teaching_german;
            $title = "Lehre und Betreuung";
        }
        return view('researchArea.iframes.teaching', compact('teaching', 'title'));
    }

    public function support(string $language, ResearchArea $researchArea) {
        // checks for language and returns view with support accordingly
        if($language == 'en') {
            $support = $researchArea->support_english;
            $title = 'Support Information';
        } else {
            $support = $researchArea->support_german;
            $title = "Betreungsinformationen";
        }
        return view('researchArea.iframes.support', compact('support', 'title'));
    }

    public function currentResearchProjects(string $language, ResearchArea $researchArea) {
        // loads all projects of research area
        $researchArea->load('researchProjects');
        $currentTime = now();

        // filters projects by publish, start date and end date
        $projects = $researchArea->researchProjects()
            ->where('publish', true)
            ->where('start_date', '<=', $currentTime)
            ->where('end_date', '>=', $currentTime)
            ->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'asc')
            ->paginate(10);

        // checks for language and returns view with projects accordingly
        if($language == 'en') {
            return view('researchArea.iframes.research-projects.en.current-research-projects', compact('projects'));
        } else {
            return view('researchArea.iframes.research-projects.de.current-research-projects', compact('projects'));
        }

    }

    public function completedResearchProjects(string $language, ResearchArea $researchArea) {
        // loas all completed projects of research area
        $researchArea->load('researchProjects');
        $currentTime = now();

        // filters projects by publish, start date and end date
        $projects = $researchArea->researchProjects()
            ->where('publish', true)
            ->where('end_date', '<', $currentTime)
            ->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'desc')
            ->paginate(10);

        // checks for language and returns view with projects accordingly
        if($language == 'en') {
            return view('researchArea.iframes.research-projects.en.completed-research-projects', compact('projects'));
        } else {
            return view('researchArea.iframes.research-projects.de.completed-research-projects', compact('projects'));
        }
    }

    public function employees(string $language, ResearchArea $researchArea) {
        // loads all employees of research area and groups them by employment type
        $employeesByType = User::whereHas('researchAreas', function ($query) use ($researchArea) {
            $query->where('id', $researchArea->id);
        })->with('employmentType')
            ->get()
            ->groupBy('employmentType.id')
            ->sortBy(function ($users, $employmentTypeId) {
                return $users->first()->employmentType->order;
            });

        // loads all employment types
        $types = EmploymentType::all();

        // checks for language and returns view with employees accordingly
        if($language == 'en') {
            $view = 'researchArea.iframes.employees.employees-en';
        } else {
            $view = 'researchArea.iframes.employees.employees-de';
        }

        return view($view, compact('employeesByType', 'types'));
    }
}
