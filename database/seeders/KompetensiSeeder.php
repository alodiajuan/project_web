<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB

class KompetensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kompetensi_id' => 1,
                'kompetensi_nama' => "hello",
                'deskripsi' => 'Excel',
                'mahasiswa_id' => 1,
            ],
        ];

        DB::table('m_kompetensi')->insert($data); // Sesuaikan nama tabel dengan tabel di database Anda
    }
}
