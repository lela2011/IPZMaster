<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;

class User extends Authenticatable implements LdapAuthenticatable
{
    use Notifiable, AuthenticatesWithLdap;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'password',
        'first_name',
        'last_name',
        'orcid',
        'website',
        'cv_english',
        'cv_german',
        'research_focus_english',
        'research_focus_german',
        'media_mail',
        'media_phone',
        'media_secretariat'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'research_areas' => 'array',
        'media_mail' => 'boolean',
        'media_phone' => 'boolean',
        'media_secretariat' => 'boolean',
    ];

    //Sets id-key to 'uid' and ensures that it's not auto-incremented
    protected $primaryKey = "uid";
    public $incrementing = false;

    // sets relation between competence and user
    public function competences() : BelongsToMany {
        return $this->belongsToMany(Competence::class, 'user_competence', 'user_id', 'competence_id');
    }

    // sets relation between research project and user
    public function projects() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'user_research_project', 'user_id', 'research_project_id')->withPivot('role');
    }

    // sets relation between project contacts and user
    public function projectContacts() : BelongsToMany {
        return $this->belongsToMany(ResearchProject::class, 'research_project_contact', 'user_id', 'research_project_id');
    }

    // sets relation between research area and user
    public function researchAreas() : BelongsToMany {
        return $this->belongsToMany(ResearchArea::class, 'user_research_area', 'user_id', 'research_area_id')->withPivot('role');
    }

    // sets relation between research priority and user
    public function transversalResearchPriorities() : BelongsToMany {
        return $this->belongsToMany(TransversalReserachPrio::class, 'user_transv_research_prio', 'user_id', 'transv_research_prio_id');
    }
}
