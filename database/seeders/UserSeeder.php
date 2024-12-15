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
            'username' => 'adminuser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'profile.jpg',
            'nama' => 'Admin User',
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'dosenuser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'profile.jpg',
            'nama' => 'Dosen User',
            'role' => 'dosen',
        ]);

        User::create([
            'username' => 'tendikuser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'profile.jpg',
            'nama' => 'Tendik User',
            'role' => 'tendik',
        ]);

        User::create([
            'username' => 'mahasiswauser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'profile.jpg',
            'nama' => 'Mahasiswa User',
            'semester' => 5,
            'id_kompetensi' => 3,
            'id_prodi' => 1,
            'role' => 'mahasiswa',
        ]);
    }
}
