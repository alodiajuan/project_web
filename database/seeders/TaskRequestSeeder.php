<?php

namespace Database\Seeders;

use App\Models\TaskRequest;
use Illuminate\Database\Seeder;

class TaskRequestSeeder extends Seeder
{
    public function run(): void
    {
        TaskRequest::create([
            'id_task' => 1,
            'id_mahasiswa' => 3,
            'status' => 'terima',
        ]);

        TaskRequest::create([
            'id_task' => 2,
            'id_mahasiswa' => 3,
            'status' => 'tolak',
        ]);
    }
}
