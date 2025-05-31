<?php

namespace Database\Seeders;

use App\Models\DetailKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailKelas::insert([
            ['RUANGAN_KELAS' => '101', 'NAMA_KELAS' => 'Kelas 10A'],
            ['RUANGAN_KELAS' => '102', 'NAMA_KELAS' => 'Kelas 10B'],
            ['RUANGAN_KELAS' => '201', 'NAMA_KELAS' => 'Kelas 11A IPA'],
            ['RUANGAN_KELAS' => '202', 'NAMA_KELAS' => 'Kelas 11B IPS'],
            ['RUANGAN_KELAS' => '303', 'NAMA_KELAS' => 'Kelas 12C'],
            ['RUANGAN_KELAS' => '304', 'NAMA_KELAS' => 'Kelas 12D'],
            ['RUANGAN_KELAS' => '401', 'NAMA_KELAS' => 'Kelas 10C'],
            ['RUANGAN_KELAS' => '402', 'NAMA_KELAS' => 'Kelas 11C'],
        ]);
    }
}
