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
                'tugas_id' => 1, // Sesuaikan dengan ID tugas yang ada jika menggunakan ID tugas
                'sdm_id' => 1, // Sesuaikan dengan ID sdm yang ada
            ],
            [
                'tugas_kode' => 'T002',
                'tugas_nama' => 'Tugas Dokumentasi Acara',
                'deskripsi' => 'Mengambil dokumentasi foto dan video selama acara berlangsung.',
                'jam_kompen' => 5,
                'status_dibuka' => false,
                'tanggal_mulai' => Carbon::now()->subDays(5)->toDateString(),
                'tanggal_akhir' => Carbon::now()->addDays(5)->toDateString(),
                'tugas_id' => 2, // Sesuaikan dengan ID tugas yang ada
                'sdm_id' => 2, // Sesuaikan dengan ID sdm yang ada
            ],
            // Tambahkan data tugas lain sesuai kebutuhan
        ];

        DB::table('m_tugas')->insert($data); // Pastikan nama tabelnya 'm_tugas' sesuai dengan tabel yang Anda gunakan
    }
}
