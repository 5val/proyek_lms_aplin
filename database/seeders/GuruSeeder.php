<?php

namespace Database\Seeders;

use App\Models\Guru;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guru::insert([
            ['NAMA_GURU' => 'Budi Santoso', 'EMAIL_GURU' => 'budi.santoso@example.com', 'PASSWORD_GURU' => Hash::make('password123'), 'ALAMAT_GURU' => 'Jl. Merdeka No. 10, Jakarta', 'NO_TELPON_GURU' => '081234567890', 'STATUS_GURU' => 'Active'],
            ['NAMA_GURU' => 'Ani Lestari', 'EMAIL_GURU' => 'ani.lestari@example.com', 'PASSWORD_GURU' => Hash::make('password456'), 'ALAMAT_GURU' => 'Jl. Sudirman No. 25, Bandung', 'NO_TELPON_GURU' => '087654321098', 'STATUS_GURU' => 'Active'],
            ['NAMA_GURU' => 'Rahmat Hidayat', 'EMAIL_GURU' => 'rahmat.hidayat@example.com', 'PASSWORD_GURU' => Hash::make('password789'), 'ALAMAT_GURU' => 'Jl. Diponegoro No. 5, Surabaya', 'NO_TELPON_GURU' => '081112223333', 'STATUS_GURU' => 'Active'],
            ['NAMA_GURU' => 'Dewi Kartika', 'EMAIL_GURU' => 'dewi.kartika@example.com', 'PASSWORD_GURU' => Hash::make('guru123'), 'ALAMAT_GURU' => 'Jl. Mawar No. 12, Sidoarjo', 'NO_TELPON_GURU' => '081223344556', 'STATUS_GURU' => 'Active'],
            ['NAMA_GURU' => 'Hendra Gunawan', 'EMAIL_GURU' => 'hendra.gunawan@example.com', 'PASSWORD_GURU' => Hash::make('guru456'), 'ALAMAT_GURU' => 'Jl. Melati No. 5, Sidoarjo', 'NO_TELPON_GURU' => '082112223334', 'STATUS_GURU' => 'Active'],
            ['NAMA_GURU' => 'Siti Nurbaya', 'EMAIL_GURU' => 'siti.nurbaya@example.com', 'PASSWORD_GURU' => Hash::make('guru789'), 'ALAMAT_GURU' => 'Jl. Kenanga No. 7, Sidoarjo', 'NO_TELPON_GURU' => '081334455667', 'STATUS_GURU' => 'Active'],
            ['NAMA_GURU' => 'Agus Prasetyo', 'EMAIL_GURU' => 'agus.prasetyo@example.com', 'PASSWORD_GURU' => Hash::make('aguspass'), 'ALAMAT_GURU' => 'Jl. Jambu No. 3, Sidoarjo', 'NO_TELPON_GURU' => '089998877665', 'STATUS_GURU' => 'Active'],
            ['NAMA_GURU' => 'Yuni Astuti', 'EMAIL_GURU' => 'yuni.astuti@example.com', 'PASSWORD_GURU' => Hash::make('guru321'), 'ALAMAT_GURU' => 'Jl. Wijaya Kusuma No. 22, Semarang', 'NO_TELPON_GURU' => '082112340987', 'STATUS_GURU' => 'Active'],
            ['NAMA_GURU' => 'Rizal Fahmi', 'EMAIL_GURU' => 'rizal.fahmi@example.com', 'PASSWORD_GURU' => Hash::make('guru654'), 'ALAMAT_GURU' => 'Jl. Cendrawasih No. 15, Medan', 'NO_TELPON_GURU' => '085612340999', 'STATUS_GURU' => 'Active'],
        ]);
    }
}
