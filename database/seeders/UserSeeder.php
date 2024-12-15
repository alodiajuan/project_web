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
            'semester' => 1,
            'id_kompetensi' => 1,
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'dosenuser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'profile.jpg',
            'nama' => 'Dosen User',
            'semester' => 3,
            'id_kompetensi' => 2,
            'role' => 'dosen',
        ]);

        User::create([
            'username' => 'tendikuser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'profile.jpg',
            'nama' => 'Tendik User',
            'semester' => 2,
            'id_kompetensi' => 1,
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
