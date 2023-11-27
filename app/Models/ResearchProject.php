<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchProject extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    protected $casts = [
        'research_areas' => 'array',
        'publication_zora_id_list' => 'array',
        'keyword_list' => 'array',
        'project_url_list' => 'array',
        'funding_list' => 'array',
        'collaborating_institutions' => 'array',
        'collaborating_counties' => 'array',
        'project_leaders' => 'array',
        'project_members' => 'array',
        'contact_list' => 'array',
    ];
}
