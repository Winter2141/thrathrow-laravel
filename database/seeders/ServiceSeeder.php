<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            ['Mastering', '0x2ab990'],
            ['Music Production', '0x16e370'],
            ['Mixing', '0x2625b4'],
        ];

        foreach ($services as $service) {
            $s = new Service();
            $s->name = $service[0];
            $s->old_id = $service[1];
            $s->save();
        }
    }
}
