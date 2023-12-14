<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExternalContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'organization'
    ];

    protected $attributes = [
        'organization' => 'external',
    ];

    public $timestamps = false;

    // sets relationship between research projects and external contact
    public function contactProjects() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'research_project_contact', 'external_contact_id', 'research_project_id');
    }
}
