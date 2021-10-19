<?php

namespace Database\Factories;

use App\Models\post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $width = 500;
        $height = random_int(250, 600);
        $file = $this->faker->image(null, $width, $height);
        $path = Storage::putFile('posts', $file);
        return [
            // fakerを使ってデータを生成
            'title' => $this->faker->word(),
            'body' => $this->faker->paragraph(),
            // user_idはUserモデルを生成してそのデータを取得
            'user_id' => \App\Models\User::factory()->create(),
            // 'img_path' => basename($path),
        ];
    }
}
