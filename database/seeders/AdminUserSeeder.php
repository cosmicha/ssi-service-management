<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'cosmasharyono@gmail.com'],
            [
                'name' => 'Cosmas',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_approved' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
