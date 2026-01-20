<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ========== BUAT PERMISSIONS ==========
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Booking Management
            'view bookings',
            'create bookings',
            'edit bookings',
            'delete bookings',

            // Settings
            'manage settings',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ========== BUAT ROLES & ASSIGN PERMISSIONS ==========

        // Role: Admin (semua akses)
        $superAdmin = Role::create(['name' => 'admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Role: User (basic)
        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'view bookings',
            'create bookings'
        ]);

        // ========== BUAT USER DEMO ==========

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
