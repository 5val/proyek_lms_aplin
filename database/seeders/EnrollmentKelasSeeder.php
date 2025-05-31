<?php

namespace Database\Seeders;

use App\Models\EnrollmentKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EnrollmentKelas::insert([
            ['ID_SISWA' => '225/0001', 'ID_KELAS' => 'K/F101/G001/223/1'],
            ['ID_SISWA' => '225/0002', 'ID_KELAS' => 'K/F101/G001/223/1'],
            ['ID_SISWA' => '225/0003', 'ID_KELAS' => 'K/F102/G002/223/1'],
            ['ID_SISWA' => '225/0004', 'ID_KELAS' => 'K/F201/G001/224/1'],
            ['ID_SISWA' => '225/0005', 'ID_KELAS' => 'K/F201/G001/224/1'],
            ['ID_SISWA' => '225/0006', 'ID_KELAS' => 'K/F303/G006/224/1'],
            ['ID_SISWA' => '225/0007', 'ID_KELAS' => 'K/F304/G007/224/1'],
            ['ID_SISWA' => '225/0008', 'ID_KELAS' => 'K/F401/G008/223/1'],
            ['ID_SISWA' => '225/0009', 'ID_KELAS' => 'K/F402/G009/224/1'],
            ['ID_SISWA' => '225/0010', 'ID_KELAS' => 'K/F303/G006/224/1'],
        ]);
    }
}
