<?php

namespace Database\Seeders;

use App\Models\Tugas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tugas::insert([
            ['ID_MATA_PELAJARAN' => 'MAT001/G001/2231', 'NAMA_TUGAS' => 'Tugas Aljabar 1', 'DESKRIPSI_TUGAS' => 'Kerjakan soal latihan hal 10-12', 'DEADLINE_TUGAS' => '2025-05-15 23:59:00'],
            ['ID_MATA_PELAJARAN' => 'BID001/G002/2231', 'NAMA_TUGAS' => 'Membuat Teks Deskripsi', 'DESKRIPSI_TUGAS' => 'Buatlah teks deskripsi tentang sekolahmu', 'DEADLINE_TUGAS' => '2025-05-16 23:59:00'],
            ['ID_MATA_PELAJARAN' => 'FIS001/G003/2241', 'NAMA_TUGAS' => 'Laporan Praktikum Kinematika', 'DESKRIPSI_TUGAS' => 'Buat laporan praktikum gerak lurus', 'DEADLINE_TUGAS' => '2025-06-15 23:59:00'],
        ]);
    }
}
