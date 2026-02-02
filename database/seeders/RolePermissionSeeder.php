<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

            // Profile
            'view profile',
            'edit profile',

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

        // Reset cached permissions again after creating them
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ========== BUAT ROLES & ASSIGN PERMISSIONS ==========

        // Role: User (basic)
        $user = Role::firstOrCreate(['name' => 'user']);
        $user->syncPermissions([
            'edit profile',
            'view bookings',
            'create bookings',
        ]);

        // Role: Admin (semua akses)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());
        // $admin->syncPermissions([
        //     'view bookings',
        // ]);

        // Role: Operational Staff
        $ops = Role::firstOrCreate(['name' => 'ops']);
        $ops->syncPermissions([
            'view bookings',
            'create bookings',
            'edit bookings',
        ]);

        // Role: Operational Staff (Future Expansion: Driver companies and tour operators managing availability and order confirmations)
        $vendors = Role::firstOrCreate(['name' => 'vendors']);
        $vendors->syncPermissions([
            // 'view bookings',
        ]);
    }
}
