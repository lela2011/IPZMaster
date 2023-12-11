<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ResearchArea extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'english',
        'german'
    ];

    // sets relationship between research area and user as well as role they have
    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_research_area', 'research_area_id', 'user_id')->withPivot('role');
    }

    // sets relationship between research area and research project
    public function researchProjects() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'project_area', 'area_id', 'project_id');
    }
}
