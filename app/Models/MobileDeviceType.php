<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MobileDeviceType extends Model
{
    use HasFactory;

    // set timestamps to false cause we don't need them
    public $timestamps = false;

    // set fillable fields
    protected $fillable = [
        'name',
    ];

    // set the relationships for the model
    public function mobileDevices() : HasMany {
        return $this->hasMany(MobileDevice::class, 'type');
    }
}
