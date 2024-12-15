<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TypeTaskSeeder::class,
            CompetenceSeeder::class,
            ProdiSeeder::class,
            UserSeeder::class,
            TaskSeeder::class,
            TaskRequestSeeder::class,
            TaskSubmissionSeeder::class,
            CompensationSeeder::class
        ]);
    }
}
