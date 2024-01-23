<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Printer extends Model
{
    use HasFactory;

    // sets timestamps to false because we don't need them
    public $timestamps = false;

    // sets the fillable fields for the model
    protected $fillable = [
        'manufacturer',
        'model',
        'serial_number',
        'product_number',
        'mac_address',
        'network_name',
        'location',
        'purchase_date',
        'warranty_date',
        'notes',
        'invoice',
        'supplier',
        'person',
    ];

    // sets the relationships for the model
    public function manufacturer() : BelongsTo {
        return $this->belongsTo(Manufacturer::class, 'manufacturer');
    }

    public function location() : BelongsTo {
        return $this->belongsTo(Location::class, 'location');
    }

    public function supplier() : BelongsTo {
        return $this->belongsTo(Supplier::class, 'supplier');
    }

    public function person() : BelongsTo {
        return $this->belongsTo(User::class, 'person', 'uid');
    }
}
