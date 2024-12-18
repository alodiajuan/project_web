<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kategori_kode' => 'TNK', 'kategori_nama' => 'Teknik'],
            ['kategori_id' => 2, 'kategori_kode' => 'PBD', 'kategori_nama' => 'Pengabdian'],
            ['kategori_id' => 3, 'kategori_kode' => 'PNT', 'kategori_nama' => 'Penelitian'],
        ];
        DB::table('m_kategori')->insert($data);
    }
}