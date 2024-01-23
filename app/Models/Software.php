<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // sets the relationships for the model
    public function manufacturer() : BelongsTo {
        return $this->belongsTo(Manufacturer::class, 'manufacturer');
    }

    public function supplier() : BelongsTo {
        return $this->belongsTo(Supplier::class, 'supplier');
    }

    public function person() : BelongsTo {
        return $this->belongsTo(User::class, 'person', 'uid');
    }
}
