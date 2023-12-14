<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ResearchProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_original',
        'publish',
        'start_date',
        'end_date',
        'summary',
        'summary_urls',
        'zora_ids',
        'publication_url',
        'project_urls',
        'fundings',
        'institutions',
        'countrys',
        'keywords',
        'contributors'
    ];

    protected $casts = [
        'summary_urls' => 'array',
        'zora_ids' => 'array',
        'project_urls' => 'array',
        'fundings' => 'array',
        'institutions' => 'array',
        'countrys' => 'array',
        'contributors' => 'array',
        'keywords' => 'array',
        'publish' => 'bool'
    ];

    public $timestamps = false;

    // sets relationship between members/users and research project

    public function leaders() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_research_project', 'research_project_id', 'user_id')->wherePivot('role', 'leader')->select('uid', 'first_name', 'last_name');
    }

    public function members() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_research_project', 'research_project_id', 'user_id')->wherePivot('role', 'member')->select('uid', 'first_name', 'last_name');
    }

    // sets relationship between research project and internal contacts
    public function internalContacts() : BelongsToMany {
        return $this->belongsToMany(User::class, 'research_project_contact', 'research_project_id', 'user_id')->select('uid', 'first_name', 'last_name', 'email');
    }

    // sets relationship between research project and external contacts
    public function externalContacts() : BelongsToMany {
        return $this->belongsToMany(ExternalContact::class, 'research_project_contact', 'research_project_id', 'external_contact_id');
    }

    // sets relationship between research project and research area
    public function researchAreas() : BelongsToMany {
        return $this->belongsToMany(ResearchArea::class, 'project_area', 'project_id', 'area_id');
    }

    // sets relationship between research project and research prio
    public function transversalResearchPrios() : BelongsToMany {
        return $this->belongsToMany(TransversalReserachPrio::class, 'project_prio', 'project_id', 'prio_id');
    }
}
