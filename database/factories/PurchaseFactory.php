<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->numberBetween(0, 1500000),
            'user_id' => User::factory()->create(),
            'confirmed_at' => $this->faker->dateTime(),
        ];
    }
}
