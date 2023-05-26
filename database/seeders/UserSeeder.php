<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\User::factory(5)->create();

        User::factory()->count(1)
        ->create()
        ->each(
            function($user) {
                $user->assignRole('admin');
            }
        );

        User::factory()->count(2)
        ->create()
        ->each(
            function($user) {
                $user->assignRole('customer');
            }
        );
    }
}
