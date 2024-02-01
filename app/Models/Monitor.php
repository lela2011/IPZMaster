<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Monitor extends Model
{
    use HasFactory;

    // sets timestamps to false because we don't need them
    public $timestamps = false;

    // sets the fillable fields for the model
    protected $fillable = [
        'manufacturer_id',
        'model',
        'size',
        'serial_number',
        'product_number',
        'location_id',
        'purchase_date',
        'warranty_date',
        'notes',
        'invoice',
        'supplier_id',
        'user_id',
    ];

    // sets the relationships for the model
    public function manufacturer() : BelongsTo {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
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
