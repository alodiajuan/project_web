<?php

namespace Database\Seeders;

use App\Models\TaskSubmission;
use Illuminate\Database\Seeder;

class TaskSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        TaskSubmission::create([
            'id_mahasiswa' => 3,
            'id_task' => 1,
            'id_dosen' => 2,
            'acc_dosen' => 'terima',
            'file' => 'file_pemrograman.pdf',
            'url' => 'http://example.com',
        ]);
    }
}
