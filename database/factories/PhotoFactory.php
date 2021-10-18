<?php

namespace Database\Factories;

use App\Models\photo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = photo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 講義でやってない所あるので確認

        // 画像サイズを指定
        $width = 500;
        $height = random_int(250, 600);

        // 画像を保存してpathを取得
        // image(’保存先のpath', 画像の横サイズ, 画像の縦サイズ)
        $file = $this->faker->image(null, $width, $height);
        // $path = Storage::putFile('/public/articles', $file)は保存したファイルをStorageで
        // 指定した(デフォルトはlocal)場所に保存し、戻り値として保存したpathが返ってくる。
        $path = Storage::putFile('posts', $file);

        // File::delete($file)で不要になったファイルを削除
        File::delete($file);
        return [
            'name' => basename($file),
            // articleファクトリーを生成する
            'post_id' => \App\Models\Post::Factory()->create(),
            'img_path' => basename($path),
        ];
    }
}
