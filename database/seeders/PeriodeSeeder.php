<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Periode::create([
            'nama' => '2024/2025',
            'tipe' => 'ganjil',
            'semester' => 5,
        ]);

        Periode::create([
            'nama' => '2023/2024',
            'tipe' => 'genap',
            'semester' => 4,
        ]);

        Periode::create([
            'nama' => '2023/2024',
            'tipe' => 'ganjil',
            'semester' => 3,
        ]);

        Periode::create([
            'nama' => '2022/2023',
            'tipe' => 'genap',
            'semester' => 2,
        ]);

        Periode::create([
            'nama' => '2022/2023',
            'tipe' => 'ganjil',
            'semester' => 1,
        ]);
    }
}
