<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'r4tatouille',
            'email' => 'kardon@gmail.com',
            'password' => Hash::make("48627913")
        ]);

        User::factory()->create([
            'name' => 'randy',
            'email' => 'rendy@gmail.com',
            'password' => Hash::make("12341234")
        ]);
    }
}
