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
            'usename' => 'adminuser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'admin.jpg',
            'nama' => 'Admin User',
            'semester' => 1,
            'id_kompetensi' => 1,
            'role' => 'admin',
        ]);

        User::create([
            'usename' => 'dosenuser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'dosen.jpg',
            'nama' => 'Dosen User',
            'semester' => 3,
            'id_kompetensi' => 2,
            'role' => 'dosen',
        ]);

        User::create([
            'usename' => 'mahasiswauser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'mahasiswa.jpg',
            'nama' => 'Mahasiswa User',
            'semester' => 5,
            'id_kompetensi' => 3,
            'role' => 'mahasiswa',
        ]);

        User::create([
            'usename' => 'tendikuser',
            'password' => Hash::make('password123'),
            'foto_profile' => 'tendik.jpg',
            'nama' => 'Tendik User',
            'semester' => 2,
            'id_kompetensi' => 1,
            'role' => 'tendik',
        ]);
    }
}
