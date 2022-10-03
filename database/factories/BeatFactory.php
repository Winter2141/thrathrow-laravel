<?php

namespace Database\Factories;

use App\Models\Beat;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BeatFactory extends Factory
{
    protected $model = Beat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'artwork_url' => sprintf(
                'https://randomuser.me/api/portraits/%s/%d.jpg',
                $this->faker->randomElement(['men', 'women']),
                $this->faker->numberBetween(1, 99)
            ),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'play_url' => 'https://s3.amazonaws.com/thathrow/beat/preview/1080072/preview.mp3',
            'download_url' => $this->faker->url(),
            'weight' => $this->faker->randomNumber(),
            'duration' => $this->faker->randomNumber(),
            'is_free' => $this->faker->boolean(),
            'is_exclusive' => $this->faker->boolean(),
            'download_enabled' => $this->faker->boolean(),
            'purchase_enabled' => $this->faker->boolean(),
            'status' => $this->faker->numberBetween(0, 4),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'bpm' => $this->faker->numberBetween(60, 300),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
