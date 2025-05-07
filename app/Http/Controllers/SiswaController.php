<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa_pages.home');
    }
    public function detail_pelajaran()
    {
        return view('siswa_pages.detail_pelajaran');
    }
    public function hlm_about()
    {
        return view('siswa_pages.hlm_about');
    }
    public function hlm_detail_tugas()
    {
        return view('siswa_pages.hlm_detail_tugas');
    }
    public function hlm_edit_about()
    {
        return view('siswa_pages.hlm_edit_about');
    }
    public function hlm_jadwal()
    {
        return view('siswa_pages.hlm_jadwal');
    }
    public function hlm_kelas()
    {
        return view('siswa_pages.hlm_kelas');
    }
    public function hlm_laporan_tugas()
    {
        return view('siswa_pages.hlm_laporan_tugas');
    }
    public function hlm_laporan_ujian()
    {
        return view('siswa_pages.hlm_laporan_ujian');
    }
}
