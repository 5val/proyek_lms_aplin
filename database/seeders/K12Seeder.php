<?php

namespace Database\Seeders;

use App\Models\DetailKelas;
use App\Models\Attendance;
use App\Models\EnrollmentKelas;
use App\Models\FeeCategory;
use App\Models\FeeComponent;
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
use App\Models\StudentFee;
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

        // Master jam pelajaran: always rebuild Senin-Jumat 5 slot
        MasterJamPelajaran::truncate();
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

        $lessonSlots = MasterJamPelajaran::orderBy('HARI_PELAJARAN')
            ->orderBy('SLOT_KE')
            ->get();

        // Distribusi mata pelajaran ke seluruh slot jadwal per kelas
        $mataList = collect();
        foreach ($kelasList as $kelasIndex => $kelas) {
            $roomCode = optional(DetailKelas::find($kelas->ID_DETAIL_KELAS))->KODE_RUANGAN;

            foreach ($lessonSlots as $slotIndex => $slot) {
                if ($slot->JENIS_SLOT !== 'Pelajaran') {
                    // Skip istirahat atau slot non-pelajaran
                    continue;
                }

                $pelajaran = $pelajaranList[($slotIndex + $kelasIndex) % $pelajaranList->count()];
                $guru = $gurus[($slotIndex + $kelasIndex) % $gurus->count()];
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
        $allStudents = collect();
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

                $allStudents->push($siswa->ID_SISWA);

                EnrollmentKelas::create([
                    'ID_SISWA' => $siswa->ID_SISWA,
                    'ID_KELAS' => $kelas->ID_KELAS,
                ]);
            }
        }

        // Tagihan buku per periode/semester (blok akses buku jika belum lunas)
        $bookCategory = FeeCategory::firstOrCreate(
            ['NAME' => 'Buku'],
            ['STATUS' => 'Active']
        );

        $bookComponent = FeeComponent::firstOrCreate(
            ['NAME' => 'Paket Buku ' . $periode->PERIODE],
            [
                'AMOUNT_DEFAULT' => 250000,
                'TYPE' => 'Wajib',
                'ID_CATEGORY' => $bookCategory->ID_CATEGORY,
                'DESCRIPTION' => 'Kewajiban pembelian paket buku periode ' . $periode->PERIODE,
                'STATUS' => 'Active',
                'AUTO_BILL' => true,
            ]
        );

        // Komponen biaya utama per periode
        $feeComponents = [];

        $sppCategory = FeeCategory::firstOrCreate(['NAME' => 'SPP'], ['STATUS' => 'Active']);
        $feeComponents[] = FeeComponent::create([
            'NAME' => 'SPP ' . $periode->PERIODE,
            'AMOUNT_DEFAULT' => 500000,
            'TYPE' => 'Wajib',
            'ID_CATEGORY' => $sppCategory->ID_CATEGORY,
            'DESCRIPTION' => 'Iuran SPP periode ' . $periode->PERIODE,
            'STATUS' => 'Active',
            'AUTO_BILL' => true,
        ]);

        $kegiatanCategory = FeeCategory::firstOrCreate(['NAME' => 'Kegiatan'], ['STATUS' => 'Active']);
        $feeComponents[] = FeeComponent::create([
            'NAME' => 'Kegiatan ' . $periode->PERIODE,
            'AMOUNT_DEFAULT' => 150000,
            'TYPE' => 'Wajib',
            'ID_CATEGORY' => $kegiatanCategory->ID_CATEGORY,
            'DESCRIPTION' => 'Iuran kegiatan siswa periode ' . $periode->PERIODE,
            'STATUS' => 'Active',
            'AUTO_BILL' => true,
        ]);

        $labCategory = FeeCategory::firstOrCreate(['NAME' => 'Laboratorium'], ['STATUS' => 'Active']);
        $feeComponents[] = FeeComponent::create([
            'NAME' => 'Praktikum/Lab ' . $periode->PERIODE,
            'AMOUNT_DEFAULT' => 200000,
            'TYPE' => 'Wajib',
            'ID_CATEGORY' => $labCategory->ID_CATEGORY,
            'DESCRIPTION' => 'Iuran praktikum/lab periode ' . $periode->PERIODE,
            'STATUS' => 'Active',
            'AUTO_BILL' => true,
        ]);

        // Sertakan komponen buku ke daftar penagihan
        $feeComponents[] = $bookComponent;

        foreach ($allStudents as $sid) {
            foreach ($feeComponents as $component) {
                StudentFee::create([
                    'ID_SISWA' => $sid,
                    'ID_PERIODE' => $periode->ID_PERIODE,
                    'ID_COMPONENT' => $component->ID_COMPONENT,
                    'AMOUNT' => $component->AMOUNT_DEFAULT,
                    'DUE_DATE' => Carbon::now()->addWeeks(rand(2, 6)),
                    'STATUS' => $faker->boolean(65) ? 'Paid' : 'Unpaid',
                    'INVOICE_CODE' => 'INV-' . Str::upper(Str::random(10)),
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

        // Tambah periode historis untuk keperluan grafik/performa lintas tahun
        $historicalPeriods = ['2023/2024', '2024/2025'];
        foreach ($historicalPeriods as $periodIdx => $periodName) {
            $periodeHist = Periode::create(['PERIODE' => $periodName]);

            foreach ($kelasList as $kelas) {
                $histKelasId = $kelas->ID_KELAS . '_P' . ($periodIdx + 1);
                $kelasHist = Kelas::create([
                    'ID_KELAS' => $histKelasId,
                    'ID_DETAIL_KELAS' => $kelas->ID_DETAIL_KELAS,
                    'ID_GURU' => $kelas->ID_GURU,
                    'ID_PERIODE' => $periodeHist->ID_PERIODE,
                    'KAPASITAS' => $kelas->KAPASITAS,
                    'NAMA_KELAS' => $kelas->NAMA_KELAS . ' ' . $periodName,
                ]);

                // Satu mata pelajaran representatif per kelas historis
                $pelajaran = $pelajaranList[($periodIdx) % $pelajaranList->count()];
                $mpId = Str::upper(Str::uuid()->toString());
                $mataHist = MataPelajaran::create([
                    'ID_MATA_PELAJARAN' => $mpId,
                    'ID_GURU' => $kelas->ID_GURU,
                    'ID_PELAJARAN' => $pelajaran->ID_PELAJARAN,
                    'ID_KELAS' => $kelasHist->ID_KELAS,
                    'JAM_PELAJARAN' => '07:00-08:30',
                    'HARI_PELAJARAN' => 'Senin',
                ]);

                // Satu tugas per mata historis
                $tugasHist = Tugas::create([
                    'ID_TUGAS' => Str::upper(Str::uuid()->toString()),
                    'ID_MATA_PELAJARAN' => $mataHist->ID_MATA_PELAJARAN,
                    'NAMA_TUGAS' => "Tugas {$pelajaran->NAMA_PELAJARAN} {$periodName}",
                    'DESKRIPSI_TUGAS' => "Tugas periode {$periodName} untuk {$pelajaran->NAMA_PELAJARAN}",
                    'DEADLINE_TUGAS' => $now->copy()->subWeeks(2),
                ]);

                // Enrol ulang siswa yang sama untuk periode historis + isi nilai akhir
                $siswaKelas = EnrollmentKelas::where('ID_KELAS', $kelas->ID_KELAS)->pluck('ID_SISWA');
                foreach ($siswaKelas as $idSiswa) {
                    EnrollmentKelas::create([
                        'ID_SISWA' => $idSiswa,
                        'ID_KELAS' => $kelasHist->ID_KELAS,
                    ]);

                    // Submission historis dengan nilai tugas
                    $nilaiTugas = $faker->numberBetween(65, 95);
                    SubmissionTugas::create([
                        'ID_SUBMISSION' => Str::upper(Str::uuid()->toString()),
                        'ID_TUGAS' => $tugasHist->ID_TUGAS,
                        'ID_SISWA' => $idSiswa,
                        'JAWABAN' => "Jawaban historis {$pelajaran->NAMA_PELAJARAN}",
                        'NILAI_TUGAS' => $nilaiTugas,
                        'TANGGAL_SUBMISSION' => $now->copy()->subWeeks(1),
                    ]);

                    $nilaiUts = $faker->numberBetween(65, 95);
                    $nilaiUas = $faker->numberBetween(65, 95);
                    $nilaiTugasRata = $faker->numberBetween(70, 95);
                    $nilaiAkhir = round(($nilaiUts + $nilaiUas + $nilaiTugasRata) / 3, 2);

                    NilaiKelas::create([
                        'ID_NILAI' => Str::upper(Str::uuid()->toString()),
                        'ID_SISWA' => $idSiswa,
                        'ID_MATA_PELAJARAN' => $mataHist->ID_MATA_PELAJARAN,
                        'NILAI_UTS' => $nilaiUts,
                        'NILAI_UAS' => $nilaiUas,
                        'NILAI_TUGAS' => $nilaiTugasRata,
                        'NILAI_AKHIR' => $nilaiAkhir,
                    ]);
                }
            }
        }

        // Pastikan ada contoh submission yang sudah dikumpulkan sekaligus sudah dinilai
        $sampleSiswa = Siswa::first();
        if ($sampleSiswa) {
            $sampleTugas = Tugas::take(3)->get();
            foreach ($sampleTugas as $tugas) {
                SubmissionTugas::updateOrCreate(
                    [
                        'ID_TUGAS' => $tugas->ID_TUGAS,
                        'ID_SISWA' => $sampleSiswa->ID_SISWA,
                    ],
                    [
                        'ID_SUBMISSION' => Str::upper(Str::uuid()->toString()),
                        'JAWABAN' => 'Contoh jawaban yang sudah dinilai',
                        'NILAI_TUGAS' => $faker->numberBetween(75, 95),
                        'TANGGAL_SUBMISSION' => Carbon::now()->subDays(1),
                    ]
                );
            }
        }

        // Pengumuman contoh
        Pengumuman::insert([
            [
                'JUDUL' => 'Selamat Datang Tahun Ajaran Baru',
                'ISI' => 'Periode 2025/2026 dimulai. Silakan cek jadwal kelas dan buku pelajaran.',
                'TANGGAL' => Carbon::now()->subDays(7),
            ],
            [
                'JUDUL' => 'Uji Coba LMS',
                'ISI' => 'Data ini dummy untuk simulasi. Silakan login sebagai guru/siswa dengan password "password".',
                'TANGGAL' => Carbon::now()->subDays(4),
            ],
            [
                'JUDUL' => 'Pengingat Jam Pelajaran',
                'ISI' => 'Slot jam pelajaran: 07:00-08:30, 08:30-10:00, 10:00-11:30, 12:00-13:30, 13:30-15:00.',
                'TANGGAL' => Carbon::now()->subDays(2),
            ],
        ]);

        // Buku pelajaran dibiarkan kosong (upload manual oleh admin)
    }
}
