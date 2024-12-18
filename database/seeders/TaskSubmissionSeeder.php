<?php

namespace Database\Seeders;

use App\Models\TaskSubmission;
use Illuminate\Database\Seeder;

class TaskSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        TaskSubmission::create([
            'id_mahasiswa' => 4,
            'id_task' => 1,
            'id_dosen' => null,
            'acc_dosen' => null,
            'file' => 'file_pemrograman.pdf',
            'url' => 'http://example.com',
        ]);
    }
}
