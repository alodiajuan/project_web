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
                'mahasiswa_id' => 1,
                'mahasiswa_nama' => 'John Doe',
                'nim' => '12345',
                'username' => 'johndoe',
                'kompetensi' => 'Web Development',
                'semester' => 1,
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
            [
                'mahasiswa_id' => 2,
                'mahasiswa_nama' => 'Alodia Juan',
                'nim' => '123456',
                'username' => 'alodiajuan',
                'kompetensi' => 'Excel',
                'semester' => 4,
                'password' => Hash::make('1234567'),
                'level_id' => 2,
            ],
        ];

        DB::table('m_mahasiswa')->insert($data);
    }
}