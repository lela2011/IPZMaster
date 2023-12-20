<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'filename', 'path'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function getUrlAttribute() {
        return URL::to('/') . Storage::url($this->path);
    }
}
