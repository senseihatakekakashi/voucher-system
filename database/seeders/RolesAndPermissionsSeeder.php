<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions for codes
        Permission::create(['name' => 'create codes']);
        Permission::create(['name' => 'read codes']);
        Permission::create(['name' => 'delete codes']);
        Permission::create(['name' => 'export codes']);

        // create permissions for users
        Permission::create(['name' => 'assign users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'delete users']);

        // create permissions for group-admins
        Permission::create(['name' => 'assign group-admins']);
        Permission::create(['name' => 'read group-admins']);

        // create permissions for groups
        Permission::create(['name' => 'create group']);
        Permission::create(['name' => 'read group']);
        Permission::create(['name' => 'update group']);
        Permission::create(['name' => 'delete group']);



        // create super-admin role and assign permissions
        Role::create(['name' => 'super-admin'])
            ->givePermissionTo([
                'read users', 
                'read codes', 
                'read group-admins', 
                'assign group-admins',
                'export codes',
                'create group',
                'read group',
                'update group',
                'delete group',
                'delete users',
            ]);

        // create group-admin role and assign permissions
        Role::create(['name' => 'group-admin'])
            ->givePermissionTo([
                'read users', 
                'read codes', 
                'read group-admins', 
                'assign group-admins',
                'export codes',
                'delete users',
            ]);

        // create users role and assign permissions
        Role::create(['name' => 'users'])
            ->givePermissionTo([
                'create codes',
                'read codes', 
                'delete codes',
            ]);
    }
}
