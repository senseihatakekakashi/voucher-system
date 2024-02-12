<?php

namespace Database\Seeders;

use App\Models\VoucherCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class VoucherCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate voucher codes for users with the 'users' role
        $users = Role::where('name', 'users')->first()->users;

        foreach ($users as $user) {
            VoucherCode::factory()->count(5)->create(['user_id' => $user->id]);
        }
    }
}
