<?php

namespace Database\Seeders;

use App\Models\SubmissionTugas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmissionTugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubmissionTugas::insert([
            ['ID_SISWA' => '225/0001', 'ID_TUGAS' => 'MAT02231/T/K/F101/G001/223/1/01', 'TANGGAL_SUBMISSION' => '2023-07-20 10:00:00', 'NILAI_TUGAS' => 85.0],
            ['ID_SISWA' => '225/0002', 'ID_TUGAS' => 'MAT02231/T/K/F101/G001/223/1/01', 'TANGGAL_SUBMISSION' => '2023-07-20 11:30:00', 'NILAI_TUGAS' => 80.0],
            ['ID_SISWA' => '225/0001', 'ID_TUGAS' => 'BID02231/T/K/F101/G001/223/1/01', 'TANGGAL_SUBMISSION' => '2023-07-22 15:00:00', 'NILAI_TUGAS' => 90.0],
            ['ID_SISWA' => '225/0004', 'ID_TUGAS' => 'FIS02241/T/K/F201/G001/224/1/01', 'TANGGAL_SUBMISSION' => '2024-07-30 09:00:00', 'NILAI_TUGAS' => 88.0],
            ['ID_SISWA' => '225/0005', 'ID_TUGAS' => 'FIS02241/T/K/F201/G001/224/1/01', 'TANGGAL_SUBMISSION' => '2024-07-30 09:15:00', 'NILAI_TUGAS' => 92.0],
        ]);
    }
}
