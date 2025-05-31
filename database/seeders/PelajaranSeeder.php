<?php

namespace Database\Seeders;

use App\Models\Pelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelajaran::insert([
            ['NAMA_PELAJARAN' => 'Matematika Wajib', 'STATUS' => 'Active'],
            ['NAMA_PELAJARAN' => 'Bahasa Indonesia', 'STATUS' => 'Active'],
            ['NAMA_PELAJARAN' => 'Fisika', 'STATUS' => 'Active'],
            ['NAMA_PELAJARAN' => 'Sejarah', 'STATUS' => 'Active'],
            ['NAMA_PELAJARAN' => 'Bahasa Inggris', 'STATUS' => 'Active'],
            ['NAMA_PELAJARAN' => 'Kimia', 'STATUS' => 'Active'],
            ['NAMA_PELAJARAN' => 'Sosiologi', 'STATUS' => 'Active'],
            ['NAMA_PELAJARAN' => 'Ekonomi', 'STATUS' => 'Active'],
            ['NAMA_PELAJARAN' => 'Biologi', 'STATUS' => 'Active'],
        ]);
    }
}
