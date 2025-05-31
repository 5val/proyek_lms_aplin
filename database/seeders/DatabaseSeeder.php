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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('SUBMISSION_TUGAS')->truncate();
        DB::table('NILAI_KELAS')->truncate();
        DB::table('ATTENDANCE')->truncate();
        DB::table('MATERI')->truncate();
        DB::table('TUGAS')->truncate();
        DB::table('PERTEMUAN')->truncate();
        DB::table('MATA_PELAJARAN')->truncate();
        DB::table('ENROLLMENT_KELAS')->truncate();
        DB::table('KELAS')->truncate();
        DB::TABLE('SISWA')->truncate();
        DB::table('GURU')->truncate();
        DB::table('DETAIL_KELAS')->truncate();
        DB::table('PELAJARAN')->truncate();
        DB::table('PERIODE')->truncate();
        DB::table('pengumuman')->truncate(); // Assuming this is your pengumuman table name
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $this->call([
            PeriodeSeeder::class,
            GuruSeeder::class,
            DetailKelasSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            EnrollmentKelasSeeder::class,
            PelajaranSeeder::class,
            MataPelajaranSeeder::class,
            PertemuanSeeder::class,
            AttendanceSeeder::class,
            MateriSeeder::class,
            TugasSeeder::class,
            SubmissionTugasSeeder::class,
            NilaiKelasSeeder::class,
            PengumumanSeeder::class,
        ]);
    }
}
