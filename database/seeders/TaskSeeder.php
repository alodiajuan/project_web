<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

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
        ]);

        Task::create([
            'id_dosen' => 2,
            'judul' => 'Tugas Database',
            'deskripsi' => 'Membuat database untuk sistem manajemen.',
            'bobot' => 100,
            'semester' => 5,
            'id_jenis' => 2,
            'tipe' => 'url',
        ]);
    }
}
