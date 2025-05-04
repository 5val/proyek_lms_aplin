<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin_pages.home');
    }
    public function editguru()
    {
        return view('admin_pages.editguru');
    }
    public function editpengumuman()
    {
        return view('admin_pages.editpengumuman');
    }
    public function editsiswa()
    {
        return view('admin_pages.editsiswa');
    }
    public function laporanguru()
    {
        return view('admin_pages.laporanguru');
    }
    public function laporankelas()
    {
        return view('admin_pages.laporankelas');
    }
    public function laporanmapel()
    {
        return view('admin_pages.laporanmapel');
    }
    public function laporansiswa()
    {
        return view('admin_pages.laporansiswa');
    }
    public function list_kelas()
    {
        $semesters = [
            '2023 - 2024 GANJIL',
            '2023 - 2024 GENAP',
            '2024 - 2025 GANJIL',
            '2024 - 2025 GENAP'
        ];

        $kelasList = [
            [
                'id_kelas' => 'XIIMIPA1/2024/2',
                'nama_wali' => 'VALEN',
                'ruangan' => 'XIIMIPA1',
            ],
            [
                'id_kelas' => 'XIIMIPA2/2024/2',
                'nama_wali' => 'OVALDO',
                'ruangan' => 'XIIMIPA2',
            ],
            [
                'id_kelas' => 'XIIMIPA3/2024/2',
                'nama_wali' => 'JESSI',
                'ruangan' => 'XIIMIPA3',
            ],
        ];
        return view('admin_pages.list_kelas', compact('kelasList', 'semesters'));
    }
    public function list_mata_pelajaran()
    {
        $semesters = [
            '2023 - 2024 GANJIL',
            '2023 - 2024 GENAP',
            '2024 - 2025 GANJIL',
            '2024 - 2025 GENAP'
        ];

        $kelasList = [
            [
                'id_mata_pelajaran' => 'XIIMIPA1PKN20242',
                'nama_pelajaran' => 'PKN',
                'nama_guru' => 'SAUD',
                'hari_pelajaran' => 'SELASA',
                'jam_pelajaran' => '10.15 - 12.15',
            ],
            [
                'id_mata_pelajaran' => 'XIIMIPA1BI20242',
                'nama_pelajaran' => 'Bahasa Indonesia',
                'nama_guru' => 'MAM YANTI',
                'hari_pelajaran' => 'SELASA',
                'jam_pelajaran' => '13.15 - 15.15',
            ],
            [
                'id_mata_pelajaran' => 'XIIMIPA1MAT20242',
                'nama_pelajaran' => 'Matematika',
                'nama_guru' => 'Valen',
                'hari_pelajaran' => 'SELASA',
                'jam_pelajaran' => '15.15 - 18.15',
            ],

        ];
        return view('admin_pages.list_mata_pelajaran', compact('semesters', 'kelasList'));
    }
    public function list_pelajaran()
    {
        $semesters = [
            '2023 - 2024 GANJIL',
            '2023 - 2024 GENAP',
            '2024 - 2025 GANJIL',
            '2024 - 2025 GENAP'
        ];

        $kelasList = [
            [
                'id_pelajaran' => 'BI',
                'nama_pelajaran' => 'Bahasa Indonesia',
            ],
            [
                'id_pelajaran' => 'PKN',
                'nama_pelajaran' => 'PKN',
            ],
            [
                'id_pelajaran' => 'MAT',
                'nama_pelajaran' => 'MATEMATIKA',
            ],
        ];
        return view('admin_pages.list_pelajaran', compact('kelasList', 'semesters'));
    }
    public function list_tambah_siswa_ke_kelas()
    {
        $asistenList = ['Ovaldo', 'Ovaldo OOO', 'Rafael'];

        $kelasList = [
            [
                'id_siswa' => '223180587',
                'nama_siswa' => 'VALEN',
                'email_siswa' => 'valen@gmail.com',
                'no_telpon_siswa' => '08580982424',
            ],
            [
                'id_siswa' => '223180582',
                'nama_siswa' => 'OVALDO',
                'email_siswa' => 'ovaldo@gmail.com',
                'no_telpon_siswa' => '08580982424',
            ],
            [
                'id_siswa' => '223180576',
                'nama_siswa' => 'JESSICA',
                'email_siswa' => 'jessi@gmail.com',
                'no_telpon_siswa' => '08580982424',
            ],
        ];
        return view('admin_pages.list_tambah_siswa_ke_kelas', compact('asistenList', 'kelasList'));
    }
    public function listguru()
    {
        return view('admin_pages.listguru');
    }
    public function listpengumuman()
    {
        return view('admin_pages.listpengumuman');
    }
    public function listsiswa()
    {
        return view('admin_pages.listsiswa');
    }
    public function tambah_kelas()
    {
        return view('admin_pages.tambah_kelas');
    }
    public function tambah_mata_pelajaran()
    {
        return view('admin_pages.tambah_mata_pelajaran');
    }
    public function tambah_pelajaran()
    {
        return view('admin_pages.tambah_pelajaran');
    }
    public function tambahguru()
    {
        return view('admin_pages.tambahguru');
    }
    public function tambahpengumuman()
    {
        return view('admin_pages.tambahpengumuman');
    }
    public function tambahsiswa()
    {
        return view('admin_pages.tambahsiswa');
    }
    public function upload_file()
    {
        return view('admin_pages.upload_file');
    }
}
