<?php

namespace App\Http\Controllers;

use App\Models\ResearchArea;
use App\Models\ResearchProject;
use App\Models\TransversalReserachPrio;
use Illuminate\Http\Request;

class ResearchIframeController extends Controller
{
    public function currentResearchProjects(Request $request, string $language)
    {
        $formData = $request->validate([
            'prio_filter' => 'nullable|string',
            'area_filter' => 'nullable|string',
        ]);

        $prioFilter = $formData['prio_filter'] ?? "";
        $areaFilter = $formData['area_filter'] ?? "";

        $researchProjectsQuery = ResearchProject::query();
        if(!empty($prioFilter)) {
            $researchProjectsQuery->whereHas('transversalResearchPrios', function ($query) use ($prioFilter) {
                $query->where('transv_research_prios.id', $prioFilter);
            });
        }

        if (!empty($areaFilter)) {
            $researchProjectsQuery->whereHas('researchAreas', function ($query) use ($areaFilter) {
                $query->where('research_areas.id', $areaFilter);
            });
        }

        $currentTime = now();

        $projects = $researchProjectsQuery->where('publish', true)
            ->where('start_date', '<=', $currentTime)
            ->where('end_date', '>=', $currentTime)
            ->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'asc')
            ->paginate(10);

        $transvResearchPrios = TransversalReserachPrio::all();
        $researchAreas = ResearchArea::all();

        if ($language == 'en') {
            return view('research.iframes.en.current-research-projects', compact('projects', 'prioFilter', 'areaFilter', 'transvResearchPrios', 'researchAreas'));
        } else {
            return view('research.iframes.de.current-research-projects', compact('projects', 'prioFilter', 'areaFilter', 'transvResearchPrios', 'researchAreas'));
        }
    }

    public function completedResearchProjects(Request $request, string $language)
    {
        $formData = $request->validate([
            'prio_filter' => 'nullable|string',
            'area_filter' => 'nullable|string',
        ]);

        $prioFilter = $formData['prio_filter'] ?? "";
        $areaFilter = $formData['area_filter'] ?? "";

        $researchProjectsQuery = ResearchProject::query();
        if(!empty($prioFilter)) {
            $researchProjectsQuery->whereHas('transversalResearchPrios', function ($query) use ($prioFilter) {
                $query->where('transv_research_prios.id', $prioFilter);
            });
        }

        if (!empty($areaFilter)) {
            $researchProjectsQuery->whereHas('researchAreas', function ($query) use ($areaFilter) {
                $query->where('research_areas.id', $areaFilter);
            });
        }

        $currentTime = now();

        $projects = $researchProjectsQuery->where('publish', true)
            ->where('end_date', '<', $currentTime)
            ->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'desc')
            ->paginate(10);

        $transvResearchPrios = TransversalReserachPrio::all();
        $researchAreas = ResearchArea::all();

        if ($language == 'en') {
            return view('research.iframes.en.completed-research-projects', compact('projects', 'prioFilter', 'areaFilter', 'transvResearchPrios', 'researchAreas'));
        } else {
            return view('research.iframes.de.completed-research-projects', compact('projects', 'prioFilter', 'areaFilter', 'transvResearchPrios', 'researchAreas'));
        }
    }
}
