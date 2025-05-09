<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\EnrollmentKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Pengumuman;
use App\Models\Tugas;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
      $kelas = Kelas::where('ID_GURU', '=', session('userActive')->ID_GURU)->first();
      $allMataPelajaran = MataPelajaran::with(['kelas', 'pelajaran'])->where('ID_GURU', '=', session('userActive')->ID_GURU)->get();
      $allTugas = Tugas::with(['mataPelajaran.pelajaran'])
         ->whereHas('mataPelajaran', function ($id) {
            $id->where('id_guru', '=', session('userActive')->ID_GURU);
         })->get();
      $allPengumuman = Pengumuman::all();
      if($kelas != null) {
         $waliKelas = DetailKelas::find($kelas->ID_DETAIL_KELAS);
         return view('guru_pages.home', ['wali_kelas' => $waliKelas, 'mata_pelajaran' => $allMataPelajaran, 'all_tugas' => $allTugas, 'all_pengumuman' => $allPengumuman]);
      } else {
         return view('guru_pages.home', ['wali_kelas' => null, 'mata_pelajaran' => $allMataPelajaran, 'all_tugas' => $allTugas, 'all_pengumuman' => $allPengumuman]);
      }
    }
    public function detail_pelajaran()
    {
        return view('guru_pages.detail_pelajaran');
    }
    public function editmateri()
    {
        return view('guru_pages.editmateri');
    }
    public function editpengumuman()
    {
        return view('guru_pages.editpengumuman');
    }
    public function edittugas()
    {
        return view('guru_pages.edittugas');
    }
    public function hlm_about()
    {
        return view('guru_pages.hlm_about');
    }
    public function hlm_detail_pengumuman()
    {
        return view('guru_pages.hlm_detail_pengumuman');
    }
    public function hlm_detail_tugas()
    {
        return view('guru_pages.hlm_detail_pengumuman');
    }

    public function hlm_edit_about()
    {
        return view('guru_pages.hlm_edit_about');
    }
    public function hlm_jadwal()
    {
        return view('guru_pages.hlm_jadwal');
    }
    public function hlm_kelas()
    {
      $all_kelas = MataPelajaran::with(['kelas', 'pelajaran'])->where('ID_GURU', '=', session('userActive')->ID_GURU)->get();
      return view('guru_pages.hlm_kelas', ['all_kelas' => $all_kelas]);
    }
    public function hlm_laporan_tugas()
    {
        return view('guru_pages.hlm_laporan_tugas');
    }
    public function hlm_laporan_ujian()
    {
        return view('guru_pages.hlm_laporan_ujian');
    }
    public function tambahpengumuman()
    {
        return view('guru_pages.tambahpengumuman');
    }
    public function tambahpertemuan()
    {
        return view('guru_pages.tambahpertemuan');
    }

    public function uploadmateri()
    {
        return view('guru_pages.uploadmateri');
    }
    public function uploadtugas()
    {
        return view('guru_pages.uploadtugas');
    }
    public function walikelas()
    {
      $kelas = Kelas::where('ID_GURU', '=', session('userActive')->ID_GURU)->first();
      if($kelas != null) {
         $waliKelas = DetailKelas::find($kelas->ID_DETAIL_KELAS);
         $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $kelas->ID_KELAS)->count();
         $semester = substr($kelas->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
         $daftar_siswa = EnrollmentKelas::with('siswa')->where('ID_KELAS', '=', $kelas->ID_KELAS)->get();
         return view('guru_pages.walikelas', ['wali_kelas' => $waliKelas, 'jumlah' => $jumlah, 'semester' => $semester, 'daftar_siswa' => $daftar_siswa]);
      } else {
         return view('guru_pages.walikelas', ['wali_kelas' => null]);
      }
    }


}
