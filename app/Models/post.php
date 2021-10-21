<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'title'
    ];

    public function photo()
    {
        // 1対多の関係の場合でidが参照先のカラムにある場合は->hasMany(<参照先モデル>::class)を返す
        return $this->hasMany(\App\Models\Photo::class);
    }

    // アクセサとしてつくるのでget付ける
    public function getImagePathAttribute()
    {
        return 'posts/' . $this->photo[0]->name;
    }
    // アクセサとしてつくるのでget付ける
    public function getImageUrlAttribute()
    {
        if (config('filesystems.default') == 'gcs') {
            return Storage::temporaryUrl($this->image_path, now()->addMinutes(5));
        }

        return Storage::url($this->image_path);
    }
}
