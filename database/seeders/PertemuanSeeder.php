<?php

namespace Database\Seeders;

use App\Models\Pertemuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PertemuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pertemuan::insert([
            ['ID_MATA_PELAJARAN' => 'MAT001/G001/2231', 'DETAIL_PERTEMUAN' => 'Bab 1 - Aljabar Dasar', 'TANGGAL_PERTEMUAN' => '2023-07-17'],
            ['ID_MATA_PELAJARAN' => 'MAT001/G001/2231', 'DETAIL_PERTEMUAN' => 'Bab 2 - Persamaan Linear', 'TANGGAL_PERTEMUAN' => '2023-07-24'],
            ['ID_MATA_PELAJARAN' => 'BID001/G002/2231', 'DETAIL_PERTEMUAN' => 'Bab 1 - Teks Deskripsi', 'TANGGAL_PERTEMUAN' => '2023-07-17'],
            ['ID_MATA_PELAJARAN' => 'FIS001/G003/2241', 'DETAIL_PERTEMUAN' => 'Bab 1 - Kinematika Gerak Lurus', 'TANGGAL_PERTEMUAN' => '2024-07-17'],
            ['ID_MATA_PELAJARAN' => 'FIS001/G003/2241', 'DETAIL_PERTEMUAN' => 'Bab 2 - Dinamika Partikel', 'TANGGAL_PERTEMUAN' => '2024-07-24'],
            ['ID_MATA_PELAJARAN' => 'KIM001/G003/2241', 'DETAIL_PERTEMUAN' => 'Bab 1 - Struktur Atom', 'TANGGAL_PERTEMUAN' => '2024-08-01'],
            ['ID_MATA_PELAJARAN' => 'SOS001/G007/2241', 'DETAIL_PERTEMUAN' => 'Bab 1 - Interaksi Sosial', 'TANGGAL_PERTEMUAN' => '2024-08-02'],
            ['ID_MATA_PELAJARAN' => 'BIO001/G003/2231', 'DETAIL_PERTEMUAN' => 'Bab 1 - Sel dan Jaringan', 'TANGGAL_PERTEMUAN' => '2023-08-03'],
            ['ID_MATA_PELAJARAN' => 'EKO001/G009/2241', 'DETAIL_PERTEMUAN' => 'Bab 1 - Permintaan dan Penawaran', 'TANGGAL_PERTEMUAN' => '2024-08-04'],
        ]);
    }
}
