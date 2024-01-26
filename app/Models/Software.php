<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Software extends Model
{
    use HasFactory;

    // sets timestamps to false because we don't need them
    public $timestamps = false;

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
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function supplier() : BelongsTo {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function people() : BelongsToMany {
        return $this->belongsToMany(User::class, 'user_software', 'software_id', 'user_id');
    }
}
