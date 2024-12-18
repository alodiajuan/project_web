<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::create([
            'id_dosen' => 1,
            'judul' => 'Tugas Pemrograman',
            'deskripsi' => 'Mengerjakan tugas pemrograman web dengan Laravel.',
            'bobot' => 100,
            'semester' => 5,
            'id_jenis' => 1,
            'tipe' => 'file',
            'kuota' => 30,
            'file' => 'tugas_pemrograman.zip',
            'deadline' => Carbon::create(2024, 12, 31, 23, 59, 59),
        ]);

        Task::create([
            'id_dosen' => 2,
            'judul' => 'Tugas Database',
            'deskripsi' => 'Membuat database untuk sistem manajemen.',
            'bobot' => 100,
            'semester' => 5,
            'id_jenis' => 2,
            'tipe' => 'url',
            'kuota' => 25,
            'url' => 'https://contohtugas.com/database',
            'deadline' => Carbon::create(2024, 12, 30, 23, 59, 59),
        ]);

        Task::create([
            'id_dosen' => 3,
            'judul' => 'Tugas Algoritma',
            'deskripsi' => 'Menganalisis dan mengimplementasikan algoritma tertentu.',
            'bobot' => 80,
            'semester' => 5,
            'id_jenis' => 3,
            'tipe' => 'file',
            'kuota' => 20,
            'file' => 'tugas_algoritma.pdf',
            'deadline' => Carbon::create(2024, 12, 29, 23, 59, 59),
        ]);
    }
}
