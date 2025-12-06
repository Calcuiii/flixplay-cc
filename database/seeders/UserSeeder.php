<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin FlixPlay',
            'email' => 'admin@flixplay.com',
            'password' => Hash::make('admin123'),
        ]);

        // Create test user
        User::create([
            'name' => 'User Test',
            'email' => 'user@flixplay.com',
            'password' => Hash::make('user123'),
        ]);

        // Create dummy users
        User::factory(10)->create();
    }
}