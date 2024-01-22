<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peripheral extends Model
{
    use HasFactory;

    // sets timestamps to false because we don't need them
    protected $timestamps = false;

    // sets the fillable fields for the model
    protected $fillable = [
        'type',
        'manufacturer',
        'model',
        'serial_number',
        'product_number',
        'location',
        'purchase_date',
        'warranty_date',
        'notes',
        'invoice',
        'supplier',
        'person',
    ];
}
