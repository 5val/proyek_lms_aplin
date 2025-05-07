<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);
Route::post('/', [MainController::class, 'handleLogin']);
Route::get('/register', [MainController::class, 'register']);
Route::get('/home', function () {
   return view('home');
});

Route::get('/admin', function () {
   return view('admin_pages/home');
});

Route::prefix('admin')->group(function () {
   Route::get('/', [AdminController::class, 'index']);
   // ===================================== Guru ===============================================
   Route::get('/editguru/{id_guru}', [AdminController::class, 'geteditguru'])
      ->where('id_guru', '.*');
   Route::put('/editguru/{id_guru}', [AdminController::class, 'editguru'])
      ->where('id_guru', '.*');
   Route::get('/listguru', [AdminController::class, 'listguru']);
   Route::get('/listguru/{id_guru}', [AdminController::class, 'hapusguru'])
      ->where('id_guru', '.*');
   Route::get('/tambahguru', [AdminController::class, 'tambahguru']);
   Route::post('/tambahguru', [AdminController::class, 'postguru']);

   // ===================================== Pengumuman ===============================================
   Route::get('/editpengumuman', [AdminController::class, 'editpengumuman']);
   Route::get('/listpengumuman', [AdminController::class, 'listpengumuman']);
   // ===================================== Siswa ===============================================
   Route::get('/editsiswa/{id_siswa}', [AdminController::class, 'geteditsiswa'])
      ->where('id_siswa', '.*');
   Route::put('/editsiswa/{id_siswa}', [AdminController::class, 'editsiswa'])
      ->where('id_siswa', '.*');
   Route::get('/listsiswa', [AdminController::class, 'listsiswa']);
   Route::get('/listsiswa/{id_siswa}', [AdminController::class, 'hapussiswa'])
      ->where('id_siswa', '.*');
   Route::get('/tambahsiswa', [AdminController::class, 'tambahsiswa']);
   Route::post('/tambahsiswa', [AdminController::class, 'postsiswa']);


   // ===================================== Laporan ===============================================
   Route::get('/laporanguru', [AdminController::class, 'laporanguru']);
   Route::get('/laporankelas', [AdminController::class, 'laporankelas']);
   Route::get('/laporanmapel', [AdminController::class, 'laporanmapel']);
   Route::get('/laporansiswa', [AdminController::class, 'laporansiswa']);


   // ======================================= Kelas ===============================================
   Route::get('/list_kelas', [AdminController::class, 'list_kelas']);
   Route::get('/list_mata_pelajaran', [AdminController::class, 'list_mata_pelajaran']);
   Route::get('/list_pelajaran', [AdminController::class, 'list_pelajaran']);
   Route::get('/list_tambah_siswa_ke_kelas', [AdminController::class, 'list_tambah_siswa_ke_kelas']);



   Route::get('/tambah_kelas', [AdminController::class, 'tambah_kelas']);
   Route::get('/tambah_mata_pelajaran', [AdminController::class, 'tambah_mata_pelajaran']);
   Route::get('/tambah_pelajaran', [AdminController::class, 'tambah_pelajaran']);

   Route::get('/tambahpengumuman', [AdminController::class, 'tambahpengumuman']);

   Route::get('/upload_file', [AdminController::class, 'upload_file']);
   // Add more admin routes here...
});


Route::get('/guru', function () {
   return view('guru_pages/home');
});

Route::prefix('guru')->group(function () {
   Route::get('/', [GuruController::class, 'index']);
   Route::get('/detail_pelajaran', [GuruController::class, 'detail_pelajaran']);
   Route::get('/editmateri', [GuruController::class, 'editmateri']);
   Route::get('/editpengumuman', [GuruController::class, 'editpengumuman']);
   Route::get('/edittugas', [GuruController::class, 'edittugas']);
   Route::get('/hlm_about', [GuruController::class, 'hlm_about']);
   Route::get('/hlm_detail_pengumuman', [GuruController::class, 'hlm_detail_pengumuman']);
   Route::get('/hlm_detail_tugas', [GuruController::class, 'hlm_detail_tugas']);
   Route::get('/hlm_edit_about', [GuruController::class, 'hlm_edit_about']);
   Route::get('/hlm_jadwal', [GuruController::class, 'hlm_jadwal']);
   Route::get('/hlm_kelas', [GuruController::class, 'hlm_kelas']);
   Route::get('/hlm_laporan_tugas', [GuruController::class, 'hlm_laporan_tugas']);
   Route::get('/hlm_laporan_ujian', [GuruController::class, 'hlm_laporan_ujian']);
   Route::get('/tambahpengumuman', [GuruController::class, 'tambahpengumuman']);
   Route::get('/tambahpertemuan', [GuruController::class, 'tambahpertemuan']);
   Route::get('/uploadmateri', [GuruController::class, 'uploadmateri']);
   Route::get('/uploadtugas', [GuruController::class, 'uploadtugas']);
   Route::get('/walikelas', [GuruController::class, 'walikelas']);
   // Add more admin routes here...
});

Route::get('/siswa', function () {
   return view('siswa_pages/home');
});

Route::prefix('siswa')->group(function () {
   Route::get('/', [SiswaController::class, 'index']);
   Route::get('/detail_pelajaran', [SiswaController::class, 'detail_pelajaran']);
   Route::get('/hlm_about', [SiswaController::class, 'hlm_about']);
   Route::get('/hlm_detail_tugas', [SiswaController::class, 'hlm_detail_tugas']);
   Route::get('/hlm_edit_about', [SiswaController::class, 'hlm_edit_about']);
   Route::get('/hlm_about', [SiswaController::class, 'hlm_about']);
   Route::get('/hlm_jadwal', [SiswaController::class, 'hlm_jadwal']);
   Route::get('/hlm_kelas', [SiswaController::class, 'hlm_kelas']);
   Route::get('/hlm_laporan_tugas', [SiswaController::class, 'hlm_laporan_tugas']);
   Route::get('/hlm_laporan_ujian', [SiswaController::class, 'hlm_laporan_ujian']);
   // Add more admin routes here...
});
