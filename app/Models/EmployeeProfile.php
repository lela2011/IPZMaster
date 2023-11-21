<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmployeeProfile extends Model
{
    protected $fillable = [
        'uid',
        'first_name',
        'last_name',
        'orcid',
        'research_areas',
        'transv_research_prio',
        'cv'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'research_areas' => 'array'
    ];

    protected $primaryKey = "uid";
    public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'uid', 'uid');
    }
}
