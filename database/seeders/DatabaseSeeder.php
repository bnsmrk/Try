<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Attorney User',
            'email' => 'attorney@example.com',
            'role' => 'attorney',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'role' => 'staff',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'role' => 'client',
            'password' => bcrypt('password'),
        ]);
    }
}
