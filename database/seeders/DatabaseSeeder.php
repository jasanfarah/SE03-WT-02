<?php

namespace Database\Seeders;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3)
            ->has(Adoption::factory()->count(4), 'listings')
            ->create();
    }
}
