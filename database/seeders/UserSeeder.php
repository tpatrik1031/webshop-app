<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate([
            'is_admin' => true,
            'user_name' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '06123456789',
            'email' => 'admin@dogshop.com',
            'password' => Hash::make('admin'),
        ]);

        // Test user
        User::updateOrCreate([
            'is_admin' => false,
            'user_name' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '06201234567',
            'email' => 'testuser@dogshop.com',
            'password' => Hash::make('password'),
        ]);
    }
}
