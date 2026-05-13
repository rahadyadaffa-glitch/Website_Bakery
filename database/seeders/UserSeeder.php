<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Restoran',
            'email' => 'admin@restoran.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Waiter Restoran',
            'email' => 'waiter@restoran.com',
            'password' => Hash::make('password'),
            'role' => 'waiter',
        ]);
    }
}
