<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Super',
            'last_name'  => 'Admin',
            'email' => 'admin@example.com',
            'parent_id'  => 0,
            'password'  => bcrypt(1234)
        ]);
    }
}
