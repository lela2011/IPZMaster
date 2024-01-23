<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    // set timestamps to false because we don't need them
    protected $timestamps = false;

    // set the fillable fields for the model
    protected $fillable = [
        'name',
        'url',
    ];

    // set the relationships for the model
    public function computers() : HasMany {
        return $this->hasMany(Computer::class, 'supplier');
    }

    public function printers() : HasMany {
        return $this->hasMany(Printer::class, 'supplier');
    }

    public function peripherals() : HasMany {
        return $this->hasMany(Peripheral::class, 'supplier');
    }

    public function monitors() : HasMany {
        return $this->hasMany(Monitor::class, 'supplier');
    }

    public function softwares() : HasMany {
        return $this->hasMany(Software::class, 'supplier');
    }
}
