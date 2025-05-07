<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin_pages.home');
    }
    // ========================================= Guru ===================================================
    public function geteditguru($id_guru)
    {
        $guru = DB::select("select * from guru where id_guru = ?", [$id_guru]);
        if (count($guru) <= 0) {
            $allGuru = DB::select("select * from guru");
            return view('admin_pages.listguru', ["allGuru" => $allGuru]);
        } else {
            return view('admin_pages.editguru', ["guru" => $guru[0]]);
        }
    }
    public function editguru(Request $request, $id_guru)
    {
        $guru = DB::select("select * from guru where id_guru = ?", [$id_guru]);
        if (count($guru) > 0) {
            $id = $request->input("id");
            $nama = $request->input("nama");
            $email = $request->input("email");
            $alamat = $request->input("alamat");
            $telp = $request->input("telp");
            $status = $request->input("status");
            DB::update("update guru set nama_guru = ?, email_guru = ?, alamat_guru = ?, no_telpon_guru = ?, status_guru = ? where id_guru = ?", [$nama, $email, $alamat, $telp, $status, $id]);
        }
        return redirect('/admin/listguru');
    }
    public function listguru()
    {
        $allGuru = DB::select("select * from guru");
        return view('admin_pages.listguru', ["allGuru" => $allGuru]);
    }
    public function hapusguru($id_guru)
    {
        $guru = DB::select("select * from guru where id_guru = ?", [$id_guru]);
        if (count($guru) > 0) {
            $status = '';
            if ($guru[0]->STATUS_GURU == "Active") {
                $status = "Inactive";
            } else {
                $status = "Active";
            }
            DB::update("update guru set status_guru = ? where id_guru = ?", [$status, $id_guru]);
        }
        return redirect('/admin/listguru');
    }
    public function postguru(Request $request)
    {
        $nama = $request->input("nama");
        $email = $request->input("email");
        $password = $request->input("password");
        $alamat = $request->input("alamat");
        $telp = $request->input("telp");
        $status = $request->input("status");
        $guru = DB::select("select * from guru where email_guru = ?", [$email]);
        if (count($guru) <= 0) {
            DB::insert("insert into guru (nama_guru, email_guru, password_guru, alamat_guru, no_telpon_guru, status_guru) values(?,?,?,?,?,?)", [$nama, $email, $password, $alamat, $telp, $status]);
            return redirect('/admin/listguru');
        } else {
            return view('admin_pages.tambahguru');
        }
    }
    // ========================================= Pengumuman ============================================
    public function geteditpengumuman($id)
    {
        $pengumuman = Pengumuman::find($id);
        return view('admin_pages.editpengumuman', ["pengumuman" => $pengumuman]);
    }
    public function editpengumuman(Request $request, $id)
    {
        $pengumuman = Pengumuman::find($id);
        $pengumuman->Judul = $request->input('Judul');
        $pengumuman->Deskripsi = $request->input('Deskripsi');
        $pengumuman->save();
        return redirect('/admin/listpengumuman');
    }
    public function listpengumuman()
    {
        $allpengumuman = Pengumuman::all();
        return view('admin_pages.listpengumuman', ["allpengumuman" => $allpengumuman]);
    }
    public function postpengumuman(Request $request)
    {
        $validatedData = $request->validate([
            'Judul' => 'required|max:255',
            'Deskripsi' => 'required',
        ]);
        $pengumuman = Pengumuman::create($validatedData);
        return redirect('/admin/listpengumuman');
    }
    public function hapuspengumuman($id_pengumuman)
    {
        $pengumuman = Pengumuman::find($id_pengumuman);
        $pengumuman->delete();
        return redirect('/admin/listpengumuman');
    }
    // ========================================= Siswa =================================================
    public function geteditsiswa($id_siswa)
    {
        $siswa = DB::select("select * from siswa where id_siswa = ?", [$id_siswa]);
        if (count($siswa) <= 0) {
            $allsiswa = DB::select("select * from siswa");
            return view('admin_pages.listsiswa', ["allsiswa" => $allsiswa]);
        } else {
            return view('admin_pages.editsiswa', ["siswa" => $siswa[0]]);
        }
    }
    public function editsiswa(Request $request, $id_siswa)
    {
        $siswa = DB::select("select * from siswa where id_siswa = ?", [$id_siswa]);
        if (count($siswa) > 0) {
            $id = $request->input("id");
            $nama = $request->input("nama");
            $email = $request->input("email");
            $alamat = $request->input("alamat");
            $telp = $request->input("telp");
            $status = $request->input("status");
            DB::update("update siswa set nama_siswa = ?, email_siswa = ?, alamat_siswa = ?, no_telpon_siswa = ?, status_siswa = ? where id_siswa = ?", [$nama, $email, $alamat, $telp, $status, $id]);
        }
        return redirect('/admin/listsiswa');
    }
    public function listsiswa()
    {
        $allsiswa = DB::select("select * from siswa");
        return view('admin_pages.listsiswa', ["allsiswa" => $allsiswa]);
    }
    public function hapussiswa($id_siswa)
    {
        $siswa = DB::select("select * from siswa where id_siswa = ?", [$id_siswa]);
        if (count($siswa) > 0) {
            $status = '';
            if ($siswa[0]->STATUS_SISWA == "Active") {
                $status = "Inactive";
            } else {
                $status = "Active";
            }
            DB::update("update siswa set status_siswa = ? where id_siswa = ?", [$status, $id_siswa]);
        }
        return redirect('/admin/listsiswa');
    }
    public function postsiswa(Request $request)
    {
        $nama = $request->input("nama");
        $email = $request->input("email");
        $password = $request->input("password");
        $alamat = $request->input("alamat");
        $telp = $request->input("telp");
        $status = $request->input("status");
        $siswa = DB::select("select * from siswa where email_siswa = ?", [$email]);
        if (count($siswa) <= 0) {
            DB::insert("insert into siswa (nama_siswa, email_siswa, password_siswa, alamat_siswa, no_telpon_siswa, status_siswa) values(?,?,?,?,?,?)", [$nama, $email, $password, $alamat, $telp, $status]);
            return redirect('/admin/listsiswa');
        } else {
            return view('admin_pages.tambahsiswa');
        }
    }

    // ========================================= Laporan ============================================

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

    // ================================== Tambah Kelas ===============================================
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
