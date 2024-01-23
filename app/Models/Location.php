<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
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
        return $this->hasMany(Computer::class, 'location');
    }

    public function printers() : HasMany {
        return $this->hasMany(Printer::class, 'location');
    }

    public function peripherals() : HasMany {
        return $this->hasMany(Peripheral::class, 'location');
    }

    public function monitors() : HasMany {
        return $this->hasMany(Monitor::class, 'location');
    }

}
