<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tugas_kode' => 'T001',
                'tugas_nama' => 'Tugas Pembersihan Ruangan',
                'deskripsi' => 'Membersihkan ruangan kelas dan peralatan yang ada.',
                'jam_kompen' => 3,
                'status_dibuka' => true,
                'tanggal_mulai' => Carbon::now()->subDays(10)->toDateString(),
                'tanggal_akhir' => Carbon::now()->addDays(10)->toDateString(),
                'kategori_id' => 1, // Pastikan kategori_id ada di tabel m_kategori
                'sdm_id' => null, // Pastikan sdm_id ada di tabel m_sdm
                'admin_id' => 1,
            ],
            [
                'tugas_kode' => 'T002',
                'tugas_nama' => 'Tugas Dokumentasi Acara',
                'deskripsi' => 'Mengambil dokumentasi foto dan video selama acara berlangsung.',
                'jam_kompen' => 5,
                'status_dibuka' => false,
                'tanggal_mulai' => Carbon::now()->subDays(5)->toDateString(),
                'tanggal_akhir' => Carbon::now()->addDays(5)->toDateString(),
                'kategori_id' => 2,
                'sdm_id' => null,
                'admin_id' => 2, // Pastikan admin_id ada di tabel m_admin
            ],
        ];

        DB::table('m_tugas')->insert($data);
    }
}
