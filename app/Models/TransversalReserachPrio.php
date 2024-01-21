<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TransversalReserachPrio extends Model
{
    // defines relationship between PHP-Model and DB-Table
    protected $table = "transv_research_prios";

    // ensures that it's not auto-incremented
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'english',
        'german',
    ];

    // sets relationship between transversal research priority and users
    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_transv_research_prio', 'transv_research_prio_id', 'user_id');
    }

    // sets relationship between research project and research prio
    public function researchProjects() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'project_prio', 'prio_id', 'project_id');
    }
}
