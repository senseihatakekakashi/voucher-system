<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call RolesAndPermissionsSeeder to seed roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // Call AdminSeeder to seed admin users
        $this->call(AdminSeeder::class);

        // Call UserSeeder to seed admin users
        $this->call(UserSeeder::class);

        // Call GroupSeeder to seed admin users
        $this->call(GroupSeeder::class);

        // Call VoucherCodeSeeder to seed admin users
        $this->call(VoucherCodeSeeder::class);
    }
}
