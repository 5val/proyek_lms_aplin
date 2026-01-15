<?php

namespace Database\Seeders;

use App\Models\DetailKelas;
use App\Models\Attendance;
use App\Models\EnrollmentKelas;
use App\Models\Guru;
use App\Models\JadwalKelas;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\MasterJamPelajaran;
use App\Models\MataPelajaran;
use App\Models\NilaiKelas;
use App\Models\Pelajaran;
use App\Models\Pengumuman;
use App\Models\Periode;
use App\Models\Pertemuan;
use App\Models\Siswa;
use App\Models\SubmissionTugas;
use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class K12Seeder extends Seeder
{
    public function run(): void
    {
        $faker = fake('id_ID');

        // Periode aktif
        $periode = Periode::create([
            'PERIODE' => '2025/2026',
        ]);

        // Guru (15 orang)
        $gurus = collect();
        for ($i = 1; $i <= 15; $i++) {
            $gurus->push(Guru::create([
                'ID_GURU' => sprintf('G%03d', $i),
                'NAMA_GURU' => $faker->name(),
                'EMAIL_GURU' => "guru{$i}@sekolah.test",
                'PASSWORD_GURU' => Hash::make('password'),
                'ALAMAT_GURU' => $faker->address(),
                'NO_TELPON_GURU' => $faker->phoneNumber(),
                'FOTO_GURU' => sprintf('https://picsum.photos/seed/guru%03d/200/200', $i),
                'STATUS_GURU' => 'Active',
            ]));
        }

        // Ruangan (12)
        $ruangans = collect();
        for ($i = 1; $i <= 12; $i++) {
            $ruangans->push(DetailKelas::create([
                'KODE_RUANGAN' => sprintf('R-%03d', $i),
                'RUANGAN_KELAS' => "Ruang {$i}",
                'NAMA_KELAS' => "Ruang {$i}",
            ]));
        }

        // Kelas: grade 10/11/12 dengan A,B,C
        $grades = [10, 11, 12];
        $sections = ['A', 'B', 'C'];
        $kelasList = collect();
        $ruangIndex = 0;
        foreach ($grades as $grade) {
            foreach ($sections as $section) {
                $detail = $ruangans[$ruangIndex % $ruangans->count()];
                $kelasList->push(Kelas::create([
                    'ID_KELAS' => "{$grade}{$section}",
                    'ID_DETAIL_KELAS' => $detail->ID_DETAIL_KELAS,
                    'ID_GURU' => $gurus[$ruangIndex % $gurus->count()]->ID_GURU,
                    'ID_PERIODE' => $periode->ID_PERIODE,
                    'KAPASITAS' => 36,
                    'NAMA_KELAS' => "Kelas {$grade}{$section}",
                ]));
                $ruangIndex++;
            }
        }

        // Pelajaran inti
        $pelajaranNames = [
            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Fisika', 'Kimia', 'Biologi', 'Sejarah', 'Ekonomi',
        ];
        $pelajaranList = collect();
        foreach ($pelajaranNames as $idx => $name) {
            $pelajaranList->push(Pelajaran::create([
                'ID_PELAJARAN' => sprintf('P%03d', $idx + 1),
                'NAMA_PELAJARAN' => $name,
                'STATUS' => 'Active',
                'JML_JAM_WAJIB' => 4,
                'KELAS_TINGKAT' => '10-12',
            ]));
        }

        // Master jam pelajaran: Senin-Jumat, 5 slot sesuai tampilan guru
        if (MasterJamPelajaran::count() === 0) {
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            $timeSlots = [
                ['07:00', '08:30', 'Jam 1'],
                ['08:30', '10:00', 'Jam 2'],
                ['10:00', '11:30', 'Jam 3'],
                ['12:00', '13:30', 'Jam 4'],
                ['13:30', '15:00', 'Jam 5'],
            ];
            $defaultSlots = [];
            foreach ($days as $day) {
                foreach ($timeSlots as $idx => [$mulai, $selesai, $label]) {
                    $defaultSlots[] = [
                        'HARI_PELAJARAN' => $day,
                        'SLOT_KE' => $idx + 1,
                        'JENIS_SLOT' => 'Pelajaran',
                        'JAM_MULAI' => $mulai,
                        'JAM_SELESAI' => $selesai,
                        'LABEL' => $label,
                    ];
                }
            }
            MasterJamPelajaran::insert($defaultSlots);
        }

        $lessonSlots = MasterJamPelajaran::where('JENIS_SLOT', 'Pelajaran')
            ->orderBy('HARI_PELAJARAN')
            ->orderBy('SLOT_KE')
            ->get();

        // Distribusi mata pelajaran + jadwal per kelas (5 slot pertama)
        $mataList = collect();
        foreach ($kelasList as $kelas) {
            $roomCode = optional(DetailKelas::find($kelas->ID_DETAIL_KELAS))->KODE_RUANGAN;
            foreach ($lessonSlots->take(5)->values() as $idx => $slot) {
                $pelajaran = $pelajaranList[$idx % $pelajaranList->count()];
                $guru = $gurus[$idx % $gurus->count()];
                $mpId = Str::upper(Str::uuid()->toString());

                $mata = MataPelajaran::create([
                    'ID_MATA_PELAJARAN' => $mpId,
                    'ID_GURU' => $guru->ID_GURU,
                    'ID_PELAJARAN' => $pelajaran->ID_PELAJARAN,
                    'ID_KELAS' => $kelas->ID_KELAS,
                    'JAM_PELAJARAN' => $slot->JAM_MULAI . '-' . $slot->JAM_SELESAI,
                    'HARI_PELAJARAN' => $slot->HARI_PELAJARAN,
                ]);
                $mataList->push([
                    'mata' => $mata,
                    'kelas' => $kelas,
                    'guru' => $guru,
                    'pelajaran' => $pelajaran,
                ]);

                JadwalKelas::create([
                    'ID_KELAS' => $kelas->ID_KELAS,
                    'ID_MATA_PELAJARAN' => $mata->ID_MATA_PELAJARAN,
                    'ID_JAM_PELAJARAN' => $slot->ID_JAM_PELAJARAN,
                    'ID_RUANGAN' => $roomCode,
                ]);
            }
        }

        // Siswa + Enrollment per kelas
        foreach ($kelasList as $kelas) {
            for ($i = 1; $i <= 10; $i++) {
                $studentId = sprintf('S%s%02d', $kelas->ID_KELAS, $i);
                $siswa = Siswa::create([
                    'ID_SISWA' => $studentId,
                    'NAMA_SISWA' => $faker->name(),
                    'EMAIL_SISWA' => strtolower($studentId) . '@siswa.test',
                    'PASSWORD_SISWA' => Hash::make('password'),
                    'EMAIL_ORANGTUA' => strtolower($studentId) . '@ortu.test',
                    'PASSWORD_ORANGTUA' => Hash::make('password'),
                    'ALAMAT_SISWA' => $faker->address(),
                    'NO_TELPON_SISWA' => $faker->phoneNumber(),
                    'FOTO_SISWA' => sprintf('https://picsum.photos/seed/%s/200/200', strtolower($studentId)),
                    'STATUS_SISWA' => 'Active',
                ]);

                EnrollmentKelas::create([
                    'ID_SISWA' => $siswa->ID_SISWA,
                    'ID_KELAS' => $kelas->ID_KELAS,
                ]);
            }
        }

        // Materi, Tugas, Pertemuan, Submission, Nilai, Absensi
        $now = Carbon::now();
        foreach ($mataList as $entry) {
            $mata = $entry['mata'];
            $kelas = $entry['kelas'];
            $pelajaran = $entry['pelajaran'];

            // Materi (2 per mata pelajaran)
            for ($m = 1; $m <= 2; $m++) {
                Materi::create([
                    'ID_MATERI' => Str::upper(Str::uuid()->toString()),
                    'ID_MATA_PELAJARAN' => $mata->ID_MATA_PELAJARAN,
                    'NAMA_MATERI' => "Materi {$pelajaran->NAMA_PELAJARAN} {$m}",
                    'DESKRIPSI_MATERI' => "Pengantar {$pelajaran->NAMA_PELAJARAN} sesi {$m}",
                    'FILE_MATERI' => null,
                ]);
            }

            // Pertemuan (3 per mata pelajaran)
            $pertemuanList = collect();
            for ($p = 1; $p <= 3; $p++) {
                $pertemuanList->push(Pertemuan::create([
                    'ID_PERTEMUAN' => Str::upper(Str::uuid()->toString()),
                    'ID_MATA_PELAJARAN' => $mata->ID_MATA_PELAJARAN,
                    'DETAIL_PERTEMUAN' => "Pertemuan {$p} {$pelajaran->NAMA_PELAJARAN}",
                    'TANGGAL_PERTEMUAN' => $now->copy()->subDays(7 - $p)->toDateString(),
                ]));
            }

            // Tugas (2 per mata pelajaran)
            $tugasList = collect();
            for ($t = 1; $t <= 2; $t++) {
                $deadline = $now->copy()->addDays($t * 3);
                $tugasList->push(Tugas::create([
                    'ID_TUGAS' => Str::upper(Str::uuid()->toString()),
                    'ID_MATA_PELAJARAN' => $mata->ID_MATA_PELAJARAN,
                    'NAMA_TUGAS' => "Tugas {$pelajaran->NAMA_PELAJARAN} {$t}",
                    'DESKRIPSI_TUGAS' => "Tugas ke-{$t} untuk {$pelajaran->NAMA_PELAJARAN}",
                    'DEADLINE_TUGAS' => $deadline,
                ]));
            }

            // Ambil siswa kelas ini
            $siswaKelas = EnrollmentKelas::where('ID_KELAS', $kelas->ID_KELAS)->pluck('ID_SISWA');

            foreach ($siswaKelas as $idSiswa) {
                // Submission per tugas + nilai tugas
                foreach ($tugasList as $tugas) {
                    $nilaiTugas = $faker->numberBetween(65, 95);
                    SubmissionTugas::create([
                        'ID_SUBMISSION' => Str::upper(Str::uuid()->toString()),
                        'ID_TUGAS' => $tugas->ID_TUGAS,
                        'ID_SISWA' => $idSiswa,
                        'JAWABAN' => "Jawaban singkat {$pelajaran->NAMA_PELAJARAN}",
                        'NILAI_TUGAS' => $nilaiTugas,
                        'TANGGAL_SUBMISSION' => $now->copy()->subDays(2),
                    ]);
                }

                // Nilai kelas
                $nilaiUts = $faker->numberBetween(65, 95);
                $nilaiUas = $faker->numberBetween(65, 95);
                $nilaiTugasRata = $faker->numberBetween(70, 95);
                $nilaiAkhir = round(($nilaiUts + $nilaiUas + $nilaiTugasRata) / 3, 2);
                NilaiKelas::create([
                    'ID_NILAI' => Str::upper(Str::uuid()->toString()),
                    'ID_SISWA' => $idSiswa,
                    'ID_MATA_PELAJARAN' => $mata->ID_MATA_PELAJARAN,
                    'NILAI_UTS' => $nilaiUts,
                    'NILAI_UAS' => $nilaiUas,
                    'NILAI_TUGAS' => $nilaiTugasRata,
                    'NILAI_AKHIR' => $nilaiAkhir,
                ]);

                // Absensi per pertemuan
                foreach ($pertemuanList as $pertemuan) {
                    $status = $faker->randomElement(['Hadir', 'Hadir', 'Hadir', 'Izin', 'Alpa']);
                    Attendance::create([
                        'ID_SISWA' => $idSiswa,
                        'ID_PERTEMUAN' => $pertemuan->ID_PERTEMUAN,
                        'STATUS' => $status,
                    ]);
                }
            }
        }

        // Pengumuman contoh
        Pengumuman::insert([
            [
                'JUDUL' => 'Selamat Datang Tahun Ajaran Baru',
                'ISI' => 'Periode 2025/2026 dimulai. Silakan cek jadwal kelas dan buku pelajaran.',
            ],
            [
                'JUDUL' => 'Uji Coba LMS',
                'ISI' => 'Data ini dummy untuk simulasi. Silakan login sebagai guru/siswa dengan password "password".',
            ],
            [
                'JUDUL' => 'Pengingat Jam Pelajaran',
                'ISI' => 'Slot jam pelajaran: 07:00-08:30, 08:30-10:00, 10:00-11:30, 12:00-13:30, 13:30-15:00.',
            ],
        ]);

        // Buku pelajaran dibiarkan kosong (upload manual oleh admin)
    }
}
