<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => '1234567890',
            'password' => Hash::make('password123'),
            'foto_profile' => 'images/profile/1734623448_business.png',
            'nama' => 'Admin User',
            'role' => 'admin',
        ]);

        User::create([
            'username' => '2345678901',
            'password' => Hash::make('password123'),
            'foto_profile' => 'images/profile/1734623448_business.png',
            'nama' => 'Dosen User',
            'role' => 'dosen',
        ]);

        User::create([
            'username' => '3456789012',
            'password' => Hash::make('password123'),
            'foto_profile' => 'images/profile/1734623448_business.png',
            'nama' => 'Tendik User',
            'role' => 'tendik',
        ]);

        User::create([
            'username' => '4567890123',
            'password' => Hash::make('password123'),
            'foto_profile' => 'images/profile/1734623448_business.png',
            'nama' => 'Mahasiswa User',
            'semester' => 5,
            'id_kompetensi' => 3,
            'id_prodi' => 1,
            'alfa' => 10,
            'compensation' => 100,
            'role' => 'mahasiswa',
        ]);
    }
}
