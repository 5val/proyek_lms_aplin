<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tables = [
            'SUBMISSION_TUGAS',
            'NILAI_KELAS',
            'ATTENDANCE',
            'MATERI',
            'TUGAS',
            'PERTEMUAN',
            'MATA_PELAJARAN',
            'PELAJARAN',
            'ENROLLMENT_KELAS',
            'KELAS',
            'JADWAL_KELAS',
            'MATA_PELAJARAN',
            'STUDENT_FEES',
            'PAYMENTS',
            'SISWA',
            'GURU',
            'DETAIL_KELAS',
            'PERIODE',
            'BUKU_PELAJARAN_KELAS',
            'BUKU_PELAJARAN',
            'FEE_COMPONENTS',
            'FEE_CATEGORIES',
            'PENGUMUMAN',
            'MASTER_JAM_PELAJARAN',
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            K12Seeder::class,
        ]);
    }
}
