<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN ADMIN
        User::create([
            'name'     => 'Admin Zeniro',
            'email'    => 'admin@zeniro.com', // <--- Pake email ini buat login admin
            'password' => Hash::make('password123'), // <--- Passwordnya
            'role'     => 'admin', // <--- Kuncinya di sini!
        ]);

        // 2. BUAT AKUN USER BIASA (Buat ngetes)
        User::create([
            'name'     => 'Nara Customer',
            'email'    => 'nara@user.com',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);
        
        $this->command->info('Akun Admin & User berhasil dibuat, Nara!');
    }
}