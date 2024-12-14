<?php

namespace Database\Seeders;

use App\Models\TypeTask;
use Illuminate\Database\Seeder;

class TypeTaskSeeder extends Seeder
{
    public function run(): void
    {
        TypeTask::create(['nama' => 'Tugas Harian']);
        TypeTask::create(['nama' => 'Tugas Ujian']);
        TypeTask::create(['nama' => 'Praktikum']);
    }
}
