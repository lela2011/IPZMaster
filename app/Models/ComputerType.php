<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComputerType extends Model
{
    use HasFactory;

    // set timestamps to false because we don't need them
    protected $timestamps = false;

    // set the fillable fields for the model
    protected $fillable = [
        'name',
    ];

    // set the relationships for the model
    public function computers() : HasMany {
        return $this->hasMany(Computer::class, 'type');
    }
}
