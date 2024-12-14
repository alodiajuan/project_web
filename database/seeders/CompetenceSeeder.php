<?php

namespace Database\Seeders;

use App\Models\Competence;
use Illuminate\Database\Seeder;

class CompetenceSeeder extends Seeder
{
    public function run(): void
    {
        Competence::create(['nama' => 'Kompetensi IT']);
        Competence::create(['nama' => 'Kompetensi Bisnis']);
        Competence::create(['nama' => 'Kompetensi Manajemen']);
    }
}
