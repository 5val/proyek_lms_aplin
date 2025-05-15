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
   Route::put('/editpengumuman/{id_pengumuman}', [AdminController::class, 'editpengumuman'])
      ->where('id_pengumuman', '.*');
   Route::get('/editpengumuman/{id_pengumuman}', [AdminController::class, 'geteditpengumuman'])
      ->where('id_pengumuman', '.*');
   Route::get('/listpengumuman', [AdminController::class, 'listpengumuman']);
   Route::get('/listpengumuman/{id_pengumuman}', [AdminController::class, 'hapuspengumuman'])
      ->where('id_pengumuman', '.*');
   Route::get('/tambahpengumuman', [AdminController::class, 'tambahpengumuman']);
   Route::post('/tambahpengumuman', [AdminController::class, 'postpengumuman']);

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
   // ===================================== Pelajaran =============================================
   Route::get('/list_pelajaran', [AdminController::class, 'list_pelajaran'])->name('list_pelajaran');
   Route::get('/list_pelajaran/{id_pelajaran}', [AdminController::class, 'hapuspelajaran'])->name('hapuspelajaran');
   Route::get('/tambah_pelajaran', [AdminController::class, 'tambah_pelajaran']);
   Route::post('/tambah_pelajaran', [AdminController::class, 'postpelajaran']);

   // ===================================== Laporan ===============================================
   Route::get('/laporanguru', [AdminController::class, 'laporanguru']);
   Route::get('/laporankelas', [AdminController::class, 'laporankelas']);
   Route::get('/laporanmapel', [AdminController::class, 'laporanmapel']);
   Route::get('/laporansiswa', [AdminController::class, 'laporansiswa']);


   // ======================================= Kelas ===============================================
   Route::get('/list_kelas', [AdminController::class, 'list_kelas'])->name('list_kelas');
   Route::get('/get_classes/{id_periode}', [AdminController::class, 'get_list_kelas']);
   Route::delete('/delete_class/{id}', [AdminController::class, 'delete_kelas']);
   Route::get('/tambah_kelas', [AdminController::class, 'tambah_kelas']);
   Route::get('/edit_kelas/{id}', [AdminController::class, 'edit_kelas'])->name('edit_kelas')
      ->where('id', expression: '.*');
   Route::post('/add_kelas', [AdminController::class, 'add_kelas'])->name('add_kelas');
   Route::put('/update_kelas/{id}', [AdminController::class, 'update_kelas'])->name('update_kelas')
      ->where('id', expression: '.*');

   // ======================================== Mata Pelajaran =====================================
   Route::get('/list_mata_pelajaran/{id_kelas}', [AdminController::class, 'list_mata_pelajaran'])
      ->where('id_kelas', expression: '.*')->name('list_mata_pelajaran');
   Route::post('/list_mata_pelajaran/{id_kelas}', [AdminController::class, 'add_mata_pelajaran'])
      ->where('id_kelas', expression: '.*');

   Route::get('/upload_file', [AdminController::class, 'upload_file']);
   // Add more admin routes here...
});


Route::get('/guru', function () {
   return view('guru_pages/home');
});

Route::prefix('guru')->group(function () {
   Route::get('/', [GuruController::class, 'index']);
   Route::get('/detail_pelajaran/{id_mata_pelajaran}', [GuruController::class, 'detail_pelajaran'])->where('id_mata_pelajaran', '.*');
   Route::get('/editmateri/{id_materi}', [GuruController::class, 'editmateri'])->where('id_materi', '.*');
   Route::get('/editmateri', [GuruController::class, 'updatemateri']);
  Route::get('/editpengumuman/{ID}', [GuruController::class, 'editpengumuman'])
    ->where('ID', '.*')
    ->name('guru.editpengumuman');
   Route::put('/updatepengumuman/{ID}', [GuruController::class, 'updatepengumuman'])->where('ID', '.*')
    ->name('guru.updatepengumuman');
Route::get('/edittugas/{id_tugas}', [GuruController::class, 'edittugas'])
    ->where('id_tugas', '.*')
    ->name('guru.edittugas');
   Route::put('/updatetugas/{id_tugas}', [GuruController::class, 'updatetugas'])->where('id_tugas', '.*')
    ->name('guru.updatetugas');
   Route::get('/hlm_about', [GuruController::class, 'hlm_about']);
   Route::get('/hlm_detail_pengumuman', [GuruController::class, 'hlm_detail_pengumuman']);
   Route::get('/hlm_detail_tugas/{id_tugas}', [GuruController::class, 'hlm_detail_tugas'])->where('id_tugas', '.*');
   Route::get('/hlm_edit_about', [GuruController::class, 'hlm_edit_about'])->name('guru.hlm_about');
  Route::put('/update_biodata', [GuruController::class, 'update_biodata'])->name('guru.update_biodata');
   Route::get('/hlm_jadwal', [GuruController::class, 'hlm_jadwal']);
   Route::get('/hlm_kelas', [GuruController::class, 'hlm_kelas']);
   Route::get('/hlm_laporan_tugas', [GuruController::class, 'hlm_laporan_tugas']);
   Route::get('/hlm_laporan_ujian', [GuruController::class, 'hlm_laporan_ujian']);
   Route::get('/tambahpengumuman', [GuruController::class, 'tambahpengumuman']);
   Route::post('/tambahpengumuman', [GuruController::class, 'postpengumuman']);
   Route::get('/tambahpertemuan/{id_mata_pelajaran}', [GuruController::class, 'tambahpertemuan'])->where('id_mata_pelajaran', '.*');
   Route::post('/tambahpertemuan', [GuruController::class, 'postpertemuan']);
   Route::get('/uploadmateri/{id_mata_pelajaran}', [GuruController::class, 'uploadmateri'])
      ->where('id_mata_pelajaran', '.*');
   Route::post('/uploadmateri', [GuruController::class, 'postmateri']);
   Route::get('/uploadtugas/{id_mata_pelajaran}', [GuruController::class, 'uploadtugas'])->where('id_mata_pelajaran', '.*');
   Route::post('/uploadtugas', [GuruController::class, 'posttugas']);
   Route::get('/walikelas', [GuruController::class, 'walikelas']);
   // Add more admin routes here...
});

Route::get('/siswa', function () {
   return view('siswa_pages/home');
});

Route::prefix('siswa')->group(function () {
   Route::get('/', [SiswaController::class, 'index']);
   Route::get('/detail_pelajaran/{id_mata_pelajaran}', [SiswaController::class, 'detail_pelajaran'])
    ->where('id_mata_pelajaran', expression: '.*');
   Route::get('/hlm_about', [SiswaController::class, 'hlm_about']);
   Route::get('/hlm_detail_tugas/{id_tugas}', [SiswaController::class, 'hlm_detail_tugas'])->where('id_tugas', expression: '.*');
   Route::get('/hlm_edit_about', [SiswaController::class, 'hlm_edit_about']);
   Route::put('/siswa/update_biodata', [SiswaController::class, 'update_biodata'])->name('siswa.update_biodata');
   Route::get('/hlm_about', [SiswaController::class, 'hlm_about'])->name('siswa.hlm_about');;
   Route::get('/hlm_jadwal', [SiswaController::class, 'hlm_jadwal']);
   Route::get('/hlm_kelas', [SiswaController::class, 'hlm_kelas']);
   Route::get('/hlm_laporan_tugas', [SiswaController::class, 'hlm_laporan_tugas']);
   Route::get('/hlm_laporan_ujian', [SiswaController::class, 'hlm_laporan_ujian']);
   // Add more admin routes here...
});
