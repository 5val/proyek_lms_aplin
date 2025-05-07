<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru_pages.home');
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
        return view('guru_pages.hlm_kelas');
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
        return view('guru_pages.walikelas');
    }


}
