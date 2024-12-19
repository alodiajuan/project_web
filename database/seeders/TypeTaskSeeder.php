<?php

namespace Database\Seeders;

use App\Models\TypeTask;
use Illuminate\Database\Seeder;

class TypeTaskSeeder extends Seeder
{
    public function run(): void
    {
        TypeTask::create(['nama' => 'Pengabdian']);
        TypeTask::create(['nama' => 'Penelitian']);
        TypeTask::create(['nama' => 'Teknis']);
    }
}
