<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Import DB

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'mahasiswa_nama' => 'John Doe',
                'nim' => '12345',
                'username' => 'johndoe',
                'kompetensi' => 'Web Development',
                'semester' => 1,
                'password' => Hash::make('12345'),
                'level_id' => 2,
                'prodi_id' => 1, // Assuming prodi_id is required, adjust accordingly
                'kompetensi_id' => 1, // Assuming kompetensi_id is required, adjust accordingly
                'foto' => null, // Assuming no photo for seeder
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_nama' => 'Alodia Juan',
                'nim' => '123456',
                'username' => 'alodiajuan',
                'kompetensi' => 'Excel',
                'semester' => 4,
                'password' => Hash::make('1234567'),
                'level_id' => 2,
                'prodi_id' => 1, // Assuming prodi_id is required, adjust accordingly
                'kompetensi_id' => 1, // Assuming kompetensi_id is required, adjust accordingly
                'foto' => null, // Assuming no photo for seeder
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_mahasiswa')->insert($data);
    }
}
