<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        $adminUser = User::create([
            'name' => 'I am Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin12345')
        ]);
        $adminUser->assignRole('admin');

        // Regular User
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('user12345')
        ]);
        $regularUser->assignRole('user');
    }
}
