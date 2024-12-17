<?php

namespace Database\Seeders;

use App\Models\Compensation;
use Illuminate\Database\Seeder;

class CompensationSeeder extends Seeder
{
    public function run(): void
    {
        Compensation::create([
            'id_task' => 1,
            'id_submission' => 1,
            'id_dosen' => 2,
            'id_mahasiswa' => 4,
            'semester' => 5,
        ]);
    }
}
