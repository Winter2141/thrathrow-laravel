<?php

namespace Database\Factories;

use App\Models\Beat;
use App\Models\BeatPurchase;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

class BeatPurchaseFactory extends Factory
{
    protected $model = BeatPurchase::class;

    public function definition(): array
    {
        return [
            'purchase_id' => Purchase::factory()->create(),
            'beat_id' => Beat::factory()->create(),
        ];
    }
}
