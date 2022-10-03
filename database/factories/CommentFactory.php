<?php

namespace Database\Factories;

use App\Models\Beat;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->word,
            'old_id' => $this->faker->word,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'beat_id' => function () {
                return Beat::factory()->create()->id;
            },
        ];
    }
}
