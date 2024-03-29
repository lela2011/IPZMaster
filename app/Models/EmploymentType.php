<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmploymentType extends Model
{
    use HasFactory;

    // sets parameters for primary key and timestamps
    public $timestamps = false;

    protected $cast = [
        'has_personal_page' => 'boolean',
    ];

    protected $fillable = [
        'english',
        'german',
        'singular',
        'url_english',
        'url_german',
        'has_personal_page',
        'order'
    ];

    // defines relationship between employment type and user
    public function users()
    {
        return $this->hasMany(User::class, 'employment_type');
    }
}
