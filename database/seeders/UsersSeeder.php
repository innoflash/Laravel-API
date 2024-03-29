<?php

namespace Database\Seeders;

use Core\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->create([
                'email' => 'test@email.com'
            ]);
    }
}
