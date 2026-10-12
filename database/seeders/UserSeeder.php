<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Superadmin (Dapat melakukan CRUD penuh)
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@momoyo.com',
            'password' => Hash::make('password123'),
            'role'     => 'superadmin',
        ]);

        // Akun Atasan (Hanya dapat melihat & cetak PDF)
        User::create([
            'name'     => 'Atasan / Manager',
            'email'    => 'atasan@momoyo.com',
            'password' => Hash::make('password123'),
            'role'     => 'atasan',
        ]);
    }
}