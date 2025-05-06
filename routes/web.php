<?php

use App\Http\Controllers\AdminController;
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
   Route::get('/editguru/{id_guru}', [AdminController::class, 'geteditguru'])
   ->where('id_guru', '.*');
   Route::put('/editguru/{id_guru}', [AdminController::class, 'editguru'])
   ->where('id_guru', '.*');
   Route::get('/editpengumuman', [AdminController::class, 'editpengumuman']);
   Route::get('/editsiswa', [AdminController::class, 'editsiswa']);
   Route::get('/laporanguru', [AdminController::class, 'laporanguru']);
   Route::get('/laporankelas', [AdminController::class, 'laporankelas']);
   Route::get('/laporanmapel', [AdminController::class, 'laporanmapel']);
   Route::get('/laporansiswa', [AdminController::class, 'laporansiswa']);
   Route::get('/list_kelas', [AdminController::class, 'list_kelas']);
   Route::get('/list_mata_pelajaran', [AdminController::class, 'list_mata_pelajaran']);
   Route::get('/list_pelajaran', [AdminController::class, 'list_pelajaran']);
   Route::get('/list_tambah_siswa_ke_kelas', [AdminController::class, 'list_tambah_siswa_ke_kelas']);
   Route::get('/listguru', [AdminController::class, 'listguru']);
   Route::get('/listguru/{id_guru}', [AdminController::class, 'hapusguru'])
   ->where('id_guru', '.*');
   Route::get('/listpengumuman', [AdminController::class, 'listpengumuman']);
   Route::get('/listsiswa', [AdminController::class, 'listsiswa']);
   Route::get('/tambah_kelas', [AdminController::class, 'tambah_kelas']);
   Route::get('/tambah_mata_pelajaran', [AdminController::class, 'tambah_mata_pelajaran']);
   Route::get('/tambah_pelajaran', [AdminController::class, 'tambah_pelajaran']);
   Route::get('/tambahguru', [AdminController::class, 'tambahguru']);
   Route::post('/tambahguru', [AdminController::class, 'postguru']);
   Route::get('/tambahpengumuman', [AdminController::class, 'tambahpengumuman']);
   Route::get('/tambahsiswa', [AdminController::class, 'tambahsiswa']);
   Route::get('/upload_file', [AdminController::class, 'upload_file']);
   // Add more admin routes here...
});


Route::get('/guru_home', function () {
   return view('guru_pages/home');
});
Route::get('/siswa_home', function () {
   return view('siswa_pages/home');
});
