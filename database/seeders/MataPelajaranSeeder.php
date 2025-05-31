<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataPelajaran::insert([
            ['ID_GURU' => 'G/001', 'ID_PELAJARAN' => 'MTKW', 'ID_KELAS' => 'K/F101/G001/223/1', 'JAM_PELAJARAN' => '07:00-08:30', 'HARI_PELAJARAN' => 'Senin'],
            ['ID_GURU' => 'G/002', 'ID_PELAJARAN' => 'BID',  'ID_KELAS' => 'K/F101/G001/223/1', 'JAM_PELAJARAN' => '08:30-10:00', 'HARI_PELAJARAN' => 'Senin'],
            ['ID_GURU' => 'G/001', 'ID_PELAJARAN' => 'MTKW', 'ID_KELAS' => 'K/F102/G002/223/1', 'JAM_PELAJARAN' => '07:00-08:30', 'HARI_PELAJARAN' => 'Selasa'],
            ['ID_GURU' => 'G/003', 'ID_PELAJARAN' => 'FIS',  'ID_KELAS' => 'K/F201/G001/224/1', 'JAM_PELAJARAN' => '10:00-11:30', 'HARI_PELAJARAN' => 'Rabu'],
            ['ID_GURU' => 'G/002', 'ID_PELAJARAN' => 'BIG',  'ID_KELAS' => 'K/F201/G001/224/1', 'JAM_PELAJARAN' => '07:00-08:30', 'HARI_PELAJARAN' => 'Kamis'],
            ['ID_GURU' => 'G/003', 'ID_PELAJARAN' => 'KIM',  'ID_KELAS' => 'K/F303/G006/224/1', 'JAM_PELAJARAN' => '08:30-10:00', 'HARI_PELAJARAN' => 'Senin'],
            ['ID_GURU' => 'G/007', 'ID_PELAJARAN' => 'SOS',  'ID_KELAS' => 'K/F304/G007/224/1', 'JAM_PELAJARAN' => '10:00-11:00', 'HARI_PELAJARAN' => 'Kamis'],
            ['ID_GURU' => 'G/003', 'ID_PELAJARAN' => 'BIO',  'ID_KELAS' => 'K/F401/G008/223/1', 'JAM_PELAJARAN' => '07:00-08:30', 'HARI_PELAJARAN' => 'Senin'],
            ['ID_GURU' => 'G/009', 'ID_PELAJARAN' => 'EKO',  'ID_KELAS' => 'K/F402/G009/224/1', 'JAM_PELAJARAN' => '10:00-11:30', 'HARI_PELAJARAN' => 'Jumat'],
        ]);
    }
}
