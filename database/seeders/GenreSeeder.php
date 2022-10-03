<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres =  [
            ['Gospel', '0x2c4148'],
            ['Trap', '0x155e04'],
            ['Jazz', '0x1cff06'],
            ['Drill', '0x249f55'],
            ['Afrobeat', '0x1b7742'],
            ['Reggae', '0x61b0e'],
            ['Hip Hop', '0x61ba6'],
            ['Dancehall', '0x1e8593'],
            ['R & B', '0x2f4e43'],
            ['Grime', '0x13d74c'],
        ];

        foreach ($genres as $genre) {
            Genre::create(
                [
                    'name' => $genre[0],
                    'old_id' => $genre[1]
                ]
            );
        }
    }
}
