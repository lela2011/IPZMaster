<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransversalReserachPrio extends Model
{
    // defines relationship between PHP-Model and DB-Table
    protected $table = "transv_research_prios";

    //Sets id-key to 'transv_id' and ensures that it's not auto-incremented
    protected $primaryKey = "transv_id";
    public $incrementing = false;
}
