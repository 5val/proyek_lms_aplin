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
   Route::get('/uploadGuru', [AdminController::class, 'displayUploadGuru']);
   Route::post('/uploadGuru', [AdminController::class, 'uploadGuru'])->name('uploadGuru.excel');
   Route::get('/downloadTempGuru', function () {
      $filePath = storage_path('app/template_excel/template_guru.xlsx'); //  path to your file
      if (file_exists($filePath)) {
         return response()->download($filePath, 'template_guru.xlsx'); //  filename for the user
      } else {
         abort(404, 'Template file not found.'); //  handle file not found error
      }
   });

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
   Route::get('/uploadSiswa', [AdminController::class, 'displayUploadSiswa']);
   Route::post('/uploadSiswa', [AdminController::class, 'uploadSiswa'])->name('uploadSiswa.excel');
   Route::get('/downloadTempSiswa', function () {
      $filePath = storage_path('app/template_excel/template_siswa.xlsx'); //  path to your file
      if (file_exists($filePath)) {
         return response()->download($filePath, 'template_siswa.xlsx'); //  filename for the user
      } else {
         abort(404, 'Template file not found.'); //  handle file not found error
      }
   });

   // ===================================== Pelajaran =============================================
   Route::get('/list_pelajaran', [AdminController::class, 'list_pelajaran'])->name('list_pelajaran');
   Route::get('/list_pelajaran/{id_pelajaran}', [AdminController::class, 'hapuspelajaran'])->name('hapuspelajaran');
   Route::get('/tambah_pelajaran', [AdminController::class, 'tambah_pelajaran']);
   Route::post('/tambah_pelajaran', [AdminController::class, 'postpelajaran']);

   // ===================================== Periode ===============================================
   Route::get('/list_periode', [AdminController::class, 'list_periode'])->name('list_periode');
   Route::get('/add_periode', [AdminController::class, 'add_periode']);
   Route::get('/delete_periode/{id_periode}', [AdminController::class, 'delete_periode']);

   // ===================================== Laporan ===============================================
   Route::get('/laporanguru', [AdminController::class, 'laporanguru']);
   Route::get('/hlm_report_guru', [AdminController::class, 'hlm_report_guru'])
   ->name('admin.report.guru');
   Route::get('/laporankelas', [AdminController::class, 'laporankelas']);
   Route::get('/laporanmapel', [AdminController::class, 'laporanmapel']);
   Route::get('/laporansiswa', [AdminController::class, 'laporansiswa']);


   // ======================================= Kelas ===============================================
   Route::get('/list_kelas', [AdminController::class, 'list_kelas'])->name('list_kelas');
   Route::get('/get_classes/{id_periode}', [AdminController::class, 'get_list_kelas']);
   Route::get('/delete_class/{id}', [AdminController::class, 'delete_kelas'])
      ->where('id', expression: '.*');
   Route::get('/tambah_kelas', [AdminController::class, 'tambah_kelas']);
   Route::get('/edit_kelas/{id}', [AdminController::class, 'edit_kelas'])->name('edit_kelas')
      ->where('id', expression: '.*');
   Route::post('/add_kelas', [AdminController::class, 'add_kelas'])->name('add_kelas');
   Route::put('/update_kelas/{id}', [AdminController::class, 'update_kelas'])->name('update_kelas')
      ->where('id', expression: '.*');
   Route::get('/upload_kelas', [AdminController::class, 'displayUploadKelas']);
   Route::post('/upload_kelas', [AdminController::class, 'uploadKelas'])->name('uploadKelas.excel');
   Route::get('/downloadTempKelas', function () {
      $filePath = storage_path('app/template_excel/template_kelas.xlsx'); //  path to your file
      if (file_exists($filePath)) {
         return response()->download($filePath, 'template_kelas.xlsx'); //  filename for the user
      } else {
         abort(404, 'Template file not found.'); //  handle file not found error
      }
   });

   // ======================================== Siswa ==============================================
   Route::get('/list_tambah_siswa_ke_kelas/{id_kelas}', [AdminController::class, 'list_tambah_siswa_ke_kelas'])
      ->where('id_kelas', expression: '.*')->name('list_tambah_siswa_ke_kelas');
   Route::get('/get_list_siswa_di_kelas/{id_kelas}', [AdminController::class, 'get_list_siswa_di_kelas'])
      ->where('id_kelas', expression: '.*');
   Route::get('/get_list_siswa_available/{id_kelas}', [AdminController::class, 'get_list_siswa_available'])
      ->where('id_kelas', expression: '.*');
   Route::post('/tambah_siswa_ke_kelas', [AdminController::class, 'tambah_siswa_ke_kelas']);
   Route::post('/remove_siswa_dari_kelas', [AdminController::class, 'remove_siswa_dari_kelas']);
   // Route::post('/list_mata_pelajaran/{id_kelas}', [AdminController::class, 'add_mata_pelajaran'])
   //    ->where('id_kelas', expression: '.*');
   Route::get('/upload_siswa_ke_kelas', [AdminController::class, 'displayUploadSiswaKeKelas']);
   Route::post('/upload_siswa_ke_kelas', [AdminController::class, 'uploadSiswaKeKelas'])->name('uploadSiswaKeKelas.excel');
   Route::get('/downloadTempSiswaKeKelas', function () {
      $filePath = storage_path('app/template_excel/template_siswa_ke_kelas.xlsx'); //  path to your file
      if (file_exists($filePath)) {
         return response()->download($filePath, 'template_siswa_ke_kelas.xlsx'); //  filename for the user
      } else {
         abort(404, 'Template file not found.'); //  handle file not found error
      }
   });

   // ======================================== Mata Pelajaran =====================================
   Route::get('/list_mata_pelajaran/{id_kelas}', [AdminController::class, 'list_mata_pelajaran'])
      ->where('id_kelas', expression: '.*')->name('list_mata_pelajaran');
   Route::post('/list_mata_pelajaran/{id_kelas}', [AdminController::class, 'add_mata_pelajaran'])
      ->where('id_kelas', expression: '.*');
   Route::post('/update_mata_pelajaran/{id_mata_pelajaran}', [AdminController::class, 'update_mata_pelajaran'])
      ->where('id_mata_pelajaran', expression: '.*');
   Route::post('/delete_mata_pelajaran/{id_mata_pelajaran}', [AdminController::class, 'delete_mata_pelajaran'])
      ->where('id_mata_pelajaran', expression: '.*');

   // ======================================== Upload Excel =====================================
   Route::get('/upload_kelas', [AdminController::class, 'upload_kelas']);
   // Add more admin routes here...
});


Route::get('/guru', function () {
   return view('guru_pages/home');
});

Route::prefix('guru')->group(function () {
   Route::get('/', [GuruController::class, 'index']);
   Route::get('/detail_pelajaran/{id_mata_pelajaran}', [GuruController::class, 'detail_pelajaran'])->where('id_mata_pelajaran', '.*');
   Route::get('/editmateri/{id_materi}', [GuruController::class, 'editmateri'])->where('id_materi', '.*');
   Route::put('/editmateri', [GuruController::class, 'updatemateri']);
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
   Route::get('/edit_nilai_tugas/{id_submission}', [GuruController::class, 'edit_nilai_tugas'])
      ->where('id_submission', '.*');
   Route::get('/edit_nilai_ujian/{id_nilai}', [GuruController::class, 'edit_nilai_ujian'])
      ->where('id_nilai', '.*');
   Route::put('/hlm_detail_pengumpulan', [GuruController::class, 'put_nilai_tugas']);
   Route::put('/edit_nilai_tugas', [GuruController::class, 'update_nilai_tugas']);
   Route::put('/edit_nilai_ujian', [GuruController::class, 'update_nilai_ujian']);
   Route::get('/hlm_detail_pengumpulan/{id_submission}', [GuruController::class, 'hlm_detail_pengumpulan'])
      ->where('id_submission', '.*');
   Route::get('/hlm_detail_tugas/{id_tugas}', [GuruController::class, 'hlm_detail_tugas'])->where('id_tugas', '.*');
   Route::get('/hlm_edit_about', [GuruController::class, 'hlm_edit_about'])->name('guru.hlm_about');
   Route::put('/update_biodata', [GuruController::class, 'update_biodata'])->name('guru.update_biodata');
   Route::get('/hlm_jadwal', [GuruController::class, 'hlm_jadwal']);
   Route::get('/hlm_kelas', [GuruController::class, 'hlm_kelas']);
   Route::get('/hlm_laporan_tugas', [GuruController::class, 'hlm_laporan_tugas']);
   Route::get('/hlm_laporan_ujian', [GuruController::class, 'hlm_laporan_ujian']);
   Route::get('/laporan_siswa/{id_siswa}', [GuruController::class, 'laporan_siswa'])
      ->where('id_siswa', '.*');
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
   Route::post('/absensi', [GuruController::class, 'editattendance']);
   // Add more admin routes here...
});

Route::get('/siswa/hlm_report_siswa', [SiswaController::class, 'hlm_laporan_nilai'])
   ->name('siswa.report.siswa');

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
   Route::post('/siswa/tugas/submit', [SiswaController::class, 'posttugas'])->name('siswa.posttugas');
   Route::get('/hlm_about', [SiswaController::class, 'hlm_about'])->name('siswa.hlm_about');
   ;
   Route::get('/hlm_jadwal', [SiswaController::class, 'hlm_jadwal']);
   Route::get('/hlm_kelas', [SiswaController::class, 'hlm_kelas']);
   Route::get('/hlm_laporan_tugas', [SiswaController::class, 'hlm_laporan_tugas'])->name('siswa.laporan_tugas');
   Route::get('/hlm_laporan_ujian', [SiswaController::class, 'hlm_laporan_ujian'])->name('siswa.laporan_ujian');

   // Route::get('/siswa/laporan_tugas', [SiswaController::class, 'hlm_laporan_tugas'])->name('siswa.laporan_tugas');

   // Route::get('/materi/download/{filename}', [SiswaController::class, 'download'])->name('materi.download');
   // Add more admin routes here...
});
