<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
{
    User::create([
        'name' => 'Admin FlixPlay',
        'email' => 'admin@flixplay.com',
        'password' => Hash::make('admin123'),
        'is_admin' => true,  // ← TAMBAH INI
    ]);

    User::create([
        'name' => 'User Test',
        'email' => 'user@flixplay.com',
        'password' => Hash::make('user123'),
        'is_admin' => false,
    ]);

    User::factory(10)->create();
}
}