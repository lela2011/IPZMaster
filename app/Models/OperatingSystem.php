<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatingSystem extends Model
{
    use HasFactory;

    // set timestamps to false because we don't need them
    protected $timestamps = false;

    // set the fillable fields for the model
    protected $fillable = [
        'name',
    ];
}
