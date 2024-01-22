<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;

    // sets timestamps to false because we don't need them
    protected $timestamps = false;

    // sets the fillable fields for the model
    protected $fillable = [
        'manufacturer',
        'name',
        'license_type',
        'purchase_date',
        'notes',
        'invoice',
        'supplier',
        'person',
    ];
}
