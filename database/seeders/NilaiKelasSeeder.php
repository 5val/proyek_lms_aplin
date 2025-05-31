<?php

namespace Database\Seeders;

use App\Models\NilaiKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NilaiKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NilaiKelas::insert([
            ['ID_SISWA' => '225/0001', 'ID_MATA_PELAJARAN' => 'MAT001/G001/2231', 'NILAI_UTS' => 80.0, 'NILAI_UAS' => 85.0, 'NILAI_TUGAS' => 87.0, 'NILAI_AKHIR' => 84.5],
            ['ID_SISWA' => '225/0002', 'ID_MATA_PELAJARAN' => 'MAT001/G001/2231', 'NILAI_UTS' => 75.0, 'NILAI_UAS' => 80.0, 'NILAI_TUGAS' => 82.0, 'NILAI_AKHIR' => 79.5],
            ['ID_SISWA' => '225/0001', 'ID_MATA_PELAJARAN' => 'BID001/G002/2231', 'NILAI_UTS' => 90.0, 'NILAI_UAS' => 88.0, 'NILAI_TUGAS' => 92.0, 'NILAI_AKHIR' => 89.8],
            ['ID_SISWA' => '225/0004', 'ID_MATA_PELAJARAN' => 'FIS001/G003/2241', 'NILAI_UTS' => 82.0, 'NILAI_UAS' => 85.0, 'NILAI_TUGAS' => 88.0, 'NILAI_AKHIR' => 85.3],
            ['ID_SISWA' => '225/0005', 'ID_MATA_PELAJARAN' => 'FIS001/G003/2241', 'NILAI_UTS' => 88.0, 'NILAI_UAS' => 90.0, 'NILAI_TUGAS' => 92.0, 'NILAI_AKHIR' => 90.2],
            ['ID_SISWA' => '225/0006', 'ID_MATA_PELAJARAN' => 'KIM001/G003/2241', 'NILAI_UTS' => 85.0, 'NILAI_UAS' => 87.0, 'NILAI_TUGAS' => 88.0, 'NILAI_AKHIR' => 86.7],
            ['ID_SISWA' => '225/0007', 'ID_MATA_PELAJARAN' => 'SOS001/G007/2241', 'NILAI_UTS' => 80.0, 'NILAI_UAS' => 82.0, 'NILAI_TUGAS' => 83.0, 'NILAI_AKHIR' => 81.7],
            ['ID_SISWA' => '225/0008', 'ID_MATA_PELAJARAN' => 'BIO001/G003/2231', 'NILAI_UTS' => 78.0, 'NILAI_UAS' => 80.0, 'NILAI_TUGAS' => 82.0, 'NILAI_AKHIR' => 80.0],
            ['ID_SISWA' => '225/0009', 'ID_MATA_PELAJARAN' => 'EKO001/G009/2241', 'NILAI_UTS' => 75.0, 'NILAI_UAS' => 78.0, 'NILAI_TUGAS' => 79.0, 'NILAI_AKHIR' => 77.3],
            ['ID_SISWA' => '225/0010', 'ID_MATA_PELAJARAN' => 'KIM001/G003/2241', 'NILAI_UTS' => 88.0, 'NILAI_UAS' => 90.0, 'NILAI_TUGAS' => 92.0, 'NILAI_AKHIR' => 90.0],
        ]);
    }
}
