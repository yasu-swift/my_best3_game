<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'img_path',
        'name'
    ];

    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class);
    }
}
