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
        'research_areas',
        'transv_research_prio',
        'cv',
        'media_phone',
        'media_mail',
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

    public function competences() : BelongsToMany {
        return $this->belongsToMany(Competence::class, 'user_competence', 'foreign_uid', 'foreign_competence');
    }
}
