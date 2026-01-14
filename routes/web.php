<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminFinanceController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

Route::post('/ask-gemini', [GeminiController::class, 'ask']);
Route::get('/', [MainController::class, 'index'])->name('login');
Route::post('/', [MainController::class, 'handleLogin']);
Route::get('/reset-password', [MainController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [MainController::class, 'handleReset'])->name('password.reset.submit');
Route::post('/midtrans/webhook', [PaymentController::class, 'midtransCallback']);
Route::get('/register', [MainController::class, 'register']);
Route::get('/home', function () {
   return view('home');
});

Route::get('/admin', function () {
   return view('admin_pages/home');
});

Route::middleware(['admin.auth'])->prefix('admin')->group(function () {
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

   // ===================================== Ruangan ===============================================
   Route::get('/list_ruangan', [AdminController::class, 'list_ruangan'])->name('list_ruangan');
   Route::post('/list_ruangan', [AdminController::class, 'add_ruangan']);
   Route::post('/edit_ruangan', [AdminController::class, 'edit_ruangan']);


   // ===================================== Pelajaran =============================================
   Route::get('/list_pelajaran', [AdminController::class, 'list_pelajaran'])->name('list_pelajaran');
   Route::get('/list_pelajaran/{id_pelajaran}', [AdminController::class, 'hapuspelajaran'])->name('hapuspelajaran');
   Route::get('/tambah_pelajaran', [AdminController::class, 'tambah_pelajaran']);
   Route::post('/tambah_pelajaran', [AdminController::class, 'postpelajaran']);
   Route::put('/update_pelajaran/{id_pelajaran}', [AdminController::class, 'update_pelajaran'])->name('update_pelajaran');

   // ===================================== Periode ===============================================
   Route::get('/list_periode', [AdminController::class, 'list_periode'])->name('list_periode');
   Route::get('/add_periode', [AdminController::class, 'add_periode']);
   Route::get('/delete_periode/{id_periode}', [AdminController::class, 'delete_periode']);
   Route::put('/update_periode/{id_periode}', [AdminController::class, 'update_periode'])->name('update_periode');

   // ===================================== Laporan ===============================================
   Route::get('/laporanguru', [AdminController::class, 'laporanguru']);
   Route::get('/hlm_report_guru', [AdminController::class, 'hlm_report_guru'])
   ->name('admin.report.guru');
   Route::get('/laporankelas', [AdminController::class, 'laporankelas']);
   Route::get('/laporanmapel', [AdminController::class, 'laporanmapel']);
   Route::get('/laporansiswa', [AdminController::class, 'laporansiswa']);
   Route::get('/laporansiswa/{id_periode}', [AdminController::class, 'getListSiswaLaporan']);
      Route::get('/hlm_report_siswa', [AdminController::class, 'hlm_report_siswa'])
   ->name('admin.report.siswa');



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
   Route::get('/detail_mata_pelajaran/{id_kelas}', [AdminController::class, 'detail_mata_pelajaran'])
      ->where('id_kelas', expression: '.*')->name('detail_mata_pelajaran');

   // ======================================== Upload Excel =====================================
   Route::get('/upload_kelas', [AdminController::class, 'upload_kelas']);
   // Add more admin routes here...

   // ======================================== Keuangan ==============================================
   Route::get('/keuangan', [AdminFinanceController::class, 'components'])->name('admin.finance.components');
   Route::post('/keuangan/component', [AdminFinanceController::class, 'storeComponent'])->name('admin.finance.component.store');
   Route::delete('/keuangan/component/{id}', [AdminFinanceController::class, 'deleteComponent'])->name('admin.finance.component.delete');
   Route::post('/keuangan/kategori', [AdminFinanceController::class, 'storeCategory'])->name('admin.finance.category.store');
   Route::delete('/keuangan/kategori/{id}', [AdminFinanceController::class, 'deleteCategory'])->name('admin.finance.category.delete');
   Route::get('/keuangan/tagihan', [AdminFinanceController::class, 'listFees'])->name('admin.finance.fees');
   Route::post('/keuangan/tagihan/batch', [AdminFinanceController::class, 'storeFeeBatch'])->name('admin.finance.fees.store');
   Route::post('/keuangan/tagihan/{id}/status', [AdminFinanceController::class, 'updateFeeStatus'])->name('admin.finance.fees.status');
});


// Route::get('/guru', function () {
//    return view('guru_pages/home');
// });

Route::middleware(['guru.auth'])->prefix('guru')->group(function () {
   Route::get('/', [GuruController::class, 'index']);
   Route::get('/detail_pelajaran/{id_mata_pelajaran}', [GuruController::class, 'detail_pelajaran'])->where('id_mata_pelajaran', '.*');
   Route::get('/editmateri/{id_materi}', [GuruController::class, 'editmateri'])
      ->where('id_materi', '.*')
      ->name('guru.editmateri');
   Route::put('/updatemateri/{id_materi}', [GuruController::class, 'updatemateri'])->where('id_materi', '.*')
      ->name('guru.updatemateri');
   Route::get('/editpengumuman/{ID}', [GuruController::class, 'editpengumuman'])
      ->where('ID', '.*')
      ->name('guru.editpengumuman');
   Route::put('/updatepengumuman/{ID}', [GuruController::class, 'updatepengumuman'])->where('ID', '.*')
      ->name('guru.updatepengumuman');
   Route::delete('/deletepengumuman/{ID}', [GuruController::class, 'deletepengumuman'])
    ->name('guru.deletepengumuman');
Route::delete('/deletetugas/{id_tugas}', [GuruController::class, 'deletetugas'])
      ->where('id_tugas', '.*')
      ->name('guru.deletetugas');
   Route::delete('/deletemateri/{id_materi}', [GuruController::class, 'deletemateri'])
      ->where('id_materi', '.*')
      ->name('guru.deletemateri');
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
   Route::get('/get_all_kelas', [GuruController::class, 'get_kelas_periode']);
   Route::get('/hlm_laporan_tugas', [GuruController::class, 'hlm_laporan_tugas']);
   Route::get('/hlm_laporan_ujian', [GuruController::class, 'hlm_laporan_ujian']);
   Route::get('/laporan_siswa/{id_siswa}', [GuruController::class, 'laporan_siswa'])
      ->where('id_siswa', '.*');
   Route::get('/tambahpengumuman/{id_mata_pelajaran}', [GuruController::class, 'tambahpengumuman'])
      ->where('id_mata_pelajaran', '.*');
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
   Route::get('/upload_nilai', [GuruController::class, 'upload_nilai'])->name('uploadNilai.excel');
   Route::post('/upload_nilai', [GuruController::class, 'uploadNilai'])->name('uploadNilaiMapel.excel');
   Route::get('/downloadTempNilai', function () {
      $filePath = storage_path('app/template_excel/template_nilai.xlsx'); //  path to your file
      if (file_exists($filePath)) {
         return response()->download($filePath, 'template_nilai.xlsx'); //  filename for the user
      } else {
         abort(404, 'Template file not found.'); //  handle file not found error
      }
   });
});

// Portal Orang Tua (menggunakan sesi siswa, ROLE Parent)
Route::middleware(['siswa.auth'])->prefix('orangtua')->group(function () {
   Route::get('/', [ParentController::class, 'index'])->name('orangtua.dashboard');
});


// Route::get('/siswa', function () {
//    return view('siswa_pages/home');
// });


Route::middleware(['siswa.auth'])->prefix('siswa')->group(function () {
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
   Route::get('/hlm_report_siswa', [SiswaController::class, 'hlm_laporan_nilai'])
   ->name('siswa.report.siswa');
   Route::get('/libur_nasional', [SiswaController::class, 'liburNasional'])->name('siswa.libur_nasional');

   // Route::get('/siswa/laporan_tugas', [SiswaController::class, 'hlm_laporan_tugas'])->name('siswa.laporan_tugas');

   // Route::get('/materi/download/{filename}', [SiswaController::class, 'download'])->name('materi.download');
   // Add more admin routes here...
});
