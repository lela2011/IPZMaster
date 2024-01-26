<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobileDevice extends Model
{
    use HasFactory;

    // set timestamps to false cause we don't need them
    public $timestamps = false;

    // set fillable fields
    protected $fillable = [
        'type',
        'manufacturer',
        'model',
        'serial_number',
        'imei',
        'operating_system',
        'location',
        'purchase_date',
        'warranty_date',
        'notes',
        'invoice',
        'supplier',
        'person',
    ];

    // sets the relationships for the model
    public function type() : BelongsTo {
        return $this->belongsTo(MobileDeviceType::class, 'type_id');
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
}
