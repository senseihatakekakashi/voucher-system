<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a Super Admin user
        User::create([
            'name' => 'Super Admin',
            'email' => 'super.admin@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->assignRole('super-admin');

        // Create Group Admin users
        User::create([
            'name' => 'Group Admin',
            'email' => 'group.admin1@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->assignRole('group-admin');

        User::create([
            'name' => 'Group Admin',
            'email' => 'group.admin2@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->assignRole('group-admin');

        User::create([
            'name' => 'Group Admin',
            'email' => 'group.admin3@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->assignRole('group-admin');
    }
}
