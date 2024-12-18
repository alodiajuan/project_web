<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class sdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
            'sdm_id' => 1,
            'sdm_nama' => 'Laila',
            'nip' => '12345',
            'username' => '12345',
            'password' => '12345',
            'no_telepon' => '08123456789',
            'foto' => '',
            'prodi_id' => 2,
            'level_id' => 1,
            ],
            [
            'sdm_id' => 2,
            'sdm_nama' => 'Ana',
            'nip' => '2345',
            'username' => '2345',
            'password' => '2345',
            'no_telepon' => '08123456789',
            'foto' => '',
            'prodi_id' => 1,
            'level_id' => 1,
            ],
            [
            'sdm_id' => 3,
            'sdm_nama' => 'Aliyah',
            'nip' => '9909',
            'username' => '9909',
            'password' => '9909',
            'no_telepon' => '08123456789',
            'foto' => '',
            'prodi_id' => 3,
            'level_id' => 1,
            ],
        ];

        DB::table('m_sdm')->insert($data); // Sesuaikan nama tabel dengan tabel di database Anda
    }
}