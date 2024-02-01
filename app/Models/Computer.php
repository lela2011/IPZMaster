<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Computer extends Model
{
    use HasFactory;

    // sets timestamps to false because we don't need them
    public $timestamps = false;

    // sets the fillable fields for the model
    protected $fillable = [
        'type_id',
        'manufacturer_id',
        'model',
        'serial_number',
        'product_number',
        'mac_address',
        'network_name',
        'operating_system_id',
        'cpu',
        'ram',
        'storage',
        'color',
        'keyboard_layout_id',
        'location_id',
        'purchase_date',
        'warranty_date',
        'notes',
        'invoice',
        'supplier_id',
        'user_id',
    ];

    // sets the relationships for the model
    public function type() : BelongsTo {
        return $this->belongsTo(ComputerType::class, 'type_id', 'id');
    }

    public function manufacturer() : BelongsTo {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function operatingSystem() : BelongsTo {
        return $this->belongsTo(OperatingSystem::class, 'operating_system_id');
    }

    public function location() : BelongsTo {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function supplier() : BelongsTo {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function person() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function keyboardLayout() : BelongsTo {
        return $this->belongsTo(KeyboardLayout::class, 'keyboard_layout_id');
    }
}
