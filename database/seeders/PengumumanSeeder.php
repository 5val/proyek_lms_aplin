<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengumuman::insert([
            ['Judul' => 'Libur Nasional Hari Kemerdekaan', 'Deskripsi' => 'Diberitahukan kepada seluruh siswa bahwa tanggal 17 Agustus 2025 adalah hari libur nasional dalam rangka peringatan Hari Kemerdekaan Republik Indonesia. Kegiatan belajar mengajar akan diliburkan.', 'created_at' => Carbon::parse('2025-05-10 08:00:00'), 'updated_at' => Carbon::parse('2025-05-10 08:00:00')],
            ['Judul' => 'Jadwal Ujian Tengah Semester', 'Deskripsi' => 'Jadwal Ujian Tengah Semester (UTS) untuk periode Ganjil 2024/2025 akan segera diumumkan. Harap siswa mempersiapkan diri.', 'created_at' => Carbon::parse('2025-05-11 09:30:00'), 'updated_at' => Carbon::parse('2025-05-11 09:30:00')],
            ['Judul' => 'Kegiatan Class Meeting', 'Deskripsi' => 'Akan diadakan kegiatan class meeting pada akhir semester ini. Informasi lebih lanjut mengenai jenis lomba dan jadwal akan diumumkan kemudian.', 'created_at' => Carbon::parse('2025-05-11 10:00:00'), 'updated_at' => Carbon::parse('2025-05-11 10:00:00')],
        ]);
    }
}
