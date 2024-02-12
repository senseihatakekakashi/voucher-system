<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
        // Create 50 users and assign the 'users' role to each user
        User::factory()
            ->count(50)
            ->create()
            ->each(function ($user) {
                $user->assignRole('users');
            });
}
}
