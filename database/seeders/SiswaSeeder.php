<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Siswa::insert([
            // Hash the passwords using Hash::make()
            ['NAMA_SISWA' => 'Citra Ayu', 'EMAIL_SISWA' => 'citra.ayu@example.com', 'ALAMAT_SISWA' => 'Jl. Pahlawan No. 1, Jakarta', 'NO_TELPON_SISWA' => '085678901234', 'PASSWORD_SISWA' => Hash::make('siswa123'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Doni Firmansyah', 'EMAIL_SISWA' => 'doni.firmansyah@example.com', 'ALAMAT_SISWA' => 'Jl. Kebangsaan No. 8, Bandung', 'NO_TELPON_SISWA' => '082345678901', 'PASSWORD_SISWA' => Hash::make('siswa456'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Eka Putri', 'EMAIL_SISWA' => 'eka.putri@example.com', 'ALAMAT_SISWA' => 'Jl. Nusantara No. 15, Surabaya', 'NO_TELPON_SISWA' => '089876543210', 'PASSWORD_SISWA' => Hash::make('siswa789'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Fajar Nugraha', 'EMAIL_SISWA' => 'fajar.nugraha@example.com', 'ALAMAT_SISWA' => 'Jl. Asia Afrika No. 30, Jakarta', 'NO_TELPON_SISWA' => '081987654321', 'PASSWORD_SISWA' => Hash::make('siswaABC'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Gita Wulandari', 'EMAIL_SISWA' => 'gita.wulandari@example.com', 'ALAMAT_SISWA' => 'Jl. Gatot Subroto No. 7, Bandung', 'NO_TELPON_SISWA' => '083210987654', 'PASSWORD_SISWA' => Hash::make('siswaDEF'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Hana Rizky', 'EMAIL_SISWA' => 'hana.rizky@example.com', 'ALAMAT_SISWA' => 'Jl. Kenanga No. 9, Sidoarjo', 'NO_TELPON_SISWA' => '083345678912', 'PASSWORD_SISWA' => Hash::make('pass001'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Ilham Prasetyo', 'EMAIL_SISWA' => 'ilham.prasetyo@example.com', 'ALAMAT_SISWA' => 'Jl. Flamboyan No. 2, Sidoarjo', 'NO_TELPON_SISWA' => '084556677889', 'PASSWORD_SISWA' => Hash::make('pass002'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Joko Sunaryo', 'EMAIL_SISWA' => 'joko.sunaryo@example.com', 'ALAMAT_SISWA' => 'Jl. Teratai No. 6, Sidoarjo', 'NO_TELPON_SISWA' => '082133344455', 'PASSWORD_SISWA' => Hash::make('pass003'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Kiki Amelia', 'EMAIL_SISWA' => 'kiki.amelia@example.com', 'ALAMAT_SISWA' => 'Jl. Sakura No. 8, Sidoarjo', 'NO_TELPON_SISWA' => '087755443322', 'PASSWORD_SISWA' => Hash::make('pass004'), 'STATUS_SISWA' => 'Active'],
            ['NAMA_SISWA' => 'Lina Oktaviani', 'EMAIL_SISWA' => 'lina.oktaviani@example.com', 'ALAMAT_SISWA' => 'Jl. Anggrek No. 1, Sidoarjo', 'NO_TELPON_SISWA' => '081122334455', 'PASSWORD_SISWA' => Hash::make('pass005'), 'STATUS_SISWA' => 'Active'],
        ]);
    }
}
