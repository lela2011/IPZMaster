<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Competence extends Model
{
    use HasFactory;

    protected $primaryKey = "competence";
    public $incrementing = false;

    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_competence', 'foreign_competence', 'foreign_uid');
    }
}
