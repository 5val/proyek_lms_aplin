<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attendance::insert([
            ['ID_SISWA' => '225/0001', 'ID_PERTEMUAN' => 1],
            ['ID_SISWA' => '225/0002', 'ID_PERTEMUAN' => 1],
            ['ID_SISWA' => '225/0001', 'ID_PERTEMUAN' => 2],
            ['ID_SISWA' => '225/0004', 'ID_PERTEMUAN' => 4],
            ['ID_SISWA' => '225/0005', 'ID_PERTEMUAN' => 4],
            ['ID_SISWA' => '225/0006', 'ID_PERTEMUAN' => 8],
            ['ID_SISWA' => '225/0007', 'ID_PERTEMUAN' => 9],
            ['ID_SISWA' => '225/0008', 'ID_PERTEMUAN' => 9],
            ['ID_SISWA' => '225/0009', 'ID_PERTEMUAN' => 9],
            ['ID_SISWA' => '225/0010', 'ID_PERTEMUAN' => 8],
        ]);
    }
}
