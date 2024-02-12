<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'super.admin@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // You can use Str::random(12) for a random password
        ])->assignRole('super-admin');

        // Group Admins
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => "group.admin$i@email.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // You can use Str::random(12) for a random password
            ])->assignRole('group-admin');
        }
    }
}