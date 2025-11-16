<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create permissions
        $permissions = [
            'view users',
            'edit users',
            'delete users',
            'create posts',
            'edit posts',
            'delete posts',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 2. Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin super user', 'guard_name' => 'web']);
        $normalUser = Role::firstOrCreate(['name' => 'normal end user', 'guard_name' => 'web']);

        // Assign all permissions to admin
        $admin->syncPermissions(Permission::all());

        // Give normal user a limited set
        $normalUser->syncPermissions(['view users', 'create posts']);

        // after creating $admin and $normalUser
        $adminSecondary = Role::firstOrCreate(['name' => 'admin secondary', 'guard_name' => 'web']);

        // copy admin permissions if admin exists
        if ($admin->exists()) {
            $adminSecondary->syncPermissions($admin->permissions);
        }

    }
}
