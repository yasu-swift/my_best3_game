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

    // アクセサとしてつくるのでget付ける
    public function getImagePathAttribute()
    {
        return 'posts/' . $this->name;
    }
    // アクセサとしてつくるのでget付ける
    public function getImageUrlAttribute()
    {
        // if (config('filesystems.default') == 'gcs') {
        //     return Storage::temporaryUrl($this->image_path, now()->addMinutes(5));
        // }
        // return Storage::url($this->image_path);
        return Storage::url($this->image_path);
    }
}
