<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ResearchArea extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'english',
        'german',
        'url_english',
        'url_german',
        'description_english',
        'description_german',
        'research_focus_english',
        'research_focus_german',
        'teaching_english',
        'teaching_german',
        'support_english',
        'support_german',
        'manager_uid'
    ];

    // sets relationship between research area and user as well as role they have
    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_research_area', 'research_area_id', 'user_id')->withPivot('role');
    }

    // sets relationship between research area and external contact
    public function externalContacts() : BelongsToMany {
        return $this->belongsToMany(ExternalContact::class, 'external_contact_research_area', 'research_area_id', 'external_id');
    }

    // sets relationship between research area and research project
    public function researchProjects() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'project_area', 'area_id', 'project_id');
    }

    // sets relationship between research area and manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_uid', 'uid');
    }
}
