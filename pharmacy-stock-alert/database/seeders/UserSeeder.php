<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'pharmacist',
            'password' => 'pharm123',
            'role' => 'pharmacist',
        ]);

        User::create([
            'username' => 'staff',
            'password' => 'staff123',
            'role' => 'staff',
        ]);
    }
}

