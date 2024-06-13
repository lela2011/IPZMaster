<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExternalContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'url',
        'organization',
        'employment_type'
    ];

    protected $attributes = [
        'organization' => 'external',
    ];

    public $timestamps = false;

    // sets relationship between research projects and external contact
    public function contactProjects() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'research_project_contact', 'external_contact_id', 'research_project_id');
    }

    // sets relation between research area and user
    public function researchAreas() : BelongsToMany {
        return $this->belongsToMany(ResearchArea::class, 'external_contact_research_area', 'external_id', 'research_area_id');
    }

    // sets relation between user and employment type
    public function employmentType() : BelongsTo {
        return $this->belongsTo(EmploymentType::class, 'employment_type');
    }
}
