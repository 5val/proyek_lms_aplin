<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::insert([
            ['ID_DETAIL_KELAS' => 'F1/01', 'ID_GURU' => 'G/001', 'ID_PERIODE' => 1],
            ['ID_DETAIL_KELAS' => 'F1/02', 'ID_GURU' => 'G/002', 'ID_PERIODE' => 1],
            ['ID_DETAIL_KELAS' => 'F2/01', 'ID_GURU' => 'G/001', 'ID_PERIODE' => 3],
            ['ID_DETAIL_KELAS' => 'F2/02', 'ID_GURU' => 'G/003', 'ID_PERIODE' => 3],
            ['ID_DETAIL_KELAS' => 'F3/03', 'ID_GURU' => 'G/006', 'ID_PERIODE' => 3],
            ['ID_DETAIL_KELAS' => 'F3/04', 'ID_GURU' => 'G/007', 'ID_PERIODE' => 3],
            ['ID_DETAIL_KELAS' => 'F4/01', 'ID_GURU' => 'G/008', 'ID_PERIODE' => 1],
            ['ID_DETAIL_KELAS' => 'F4/02', 'ID_GURU' => 'G/009', 'ID_PERIODE' => 3],
        ]);
    }
}
