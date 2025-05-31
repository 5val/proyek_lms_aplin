<?php

namespace Database\Seeders;

use App\Models\Materi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materi::insert([
            ['ID_MATA_PELAJARAN' => 'MAT001/G001/2231', 'NAMA_MATERI' => 'Modul Aljabar', 'DESKRIPSI_MATERI' => 'Materi lengkap bab aljabar dasar', 'FILE_MATERI' => 'aljabar_dasar.pdf'],
            ['ID_MATA_PELAJARAN' => 'MAT001/G001/2231', 'NAMA_MATERI' => 'Latihan Soal Persamaan Linear', 'DESKRIPSI_MATERI' => 'Kumpulan soal dan pembahasan', 'FILE_MATERI' => 'latihan_persamaan_linear.docx'],
            ['ID_MATA_PELAJARAN' => 'BID001/G002/2231', 'NAMA_MATERI' => 'Contoh Teks Deskripsi', 'DESKRIPSI_MATERI' => 'Berbagai contoh teks deskripsi', 'FILE_MATERI' => 'contoh_teks_deskripsi.pdf'],
            ['ID_MATA_PELAJARAN' => 'FIS001/G003/2241', 'NAMA_MATERI' => 'Rumus Kinematika', 'DESKRIPSI_MATERI' => 'Ringkasan rumus kinematika', 'FILE_MATERI' => 'rumus_kinematika.jpg'],
        ]);
    }
}
