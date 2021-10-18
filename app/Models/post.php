<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class post extends Model
{
    use HasFactory;

    public function photos()
    {
        // 1対多の関係の場合でidが参照先のカラムにある場合は->hasMany(<参照先モデル>::class)を返す
        return $this->hasMany(Photo::class);
    }
    // アクセサとしてつくるのでget付ける
    public function getImagePathAttribute()
    {
        // return 'posts/' . $this->post->img_path;
        return 'posts/' . $this->img_path;
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
