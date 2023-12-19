<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Competence extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    // sets relationship between user and competence
    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_competence', 'competence_id', 'user_id');
    }
}
