<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        Periode::insert([ 
            ['PERIODE' => 'Tahun 2023/2024 GANJIL'],
            ['PERIODE' => 'Tahun 2023/2024 GENAP'],
            ['PERIODE' => 'Tahun 2024/2025 GANJIL'],
        ]);
    }
}
