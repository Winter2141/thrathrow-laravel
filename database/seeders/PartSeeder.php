<?php

namespace Database\Seeders;

use App\Models\Part;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parts = [
            'Kicks',
            'Piano',
            'Shaker',
            'Clap',
            'Hi Hat',
            'Vocal Sample',
            'FX',
            'Lead',
            'Guitar',
            'Bass',
            'Marimba',
        ];

        foreach ($parts as $part) {
            Part::create([
                'name' => $part,
            ]);
        }
    }
}
