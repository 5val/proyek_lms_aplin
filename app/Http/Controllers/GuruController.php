<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\EnrollmentKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Materi;
use App\Models\Pengumuman;
use App\Models\Pertemuan;
use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index()
    {
      $kelas = Kelas::where('ID_GURU', '=', session('userActive')->ID_GURU)->first();
      $allMataPelajaran = MataPelajaran::with(['kelas.detailKelas', 'pelajaran'])->where('ID_GURU', '=', session('userActive')->ID_GURU)->get();
      $allTugas = Tugas::with(['mataPelajaran.pelajaran'])
         ->whereHas('mataPelajaran', function ($id) {
            $id->where('id_guru', '=', session('userActive')->ID_GURU);
         })->get();
      $allPengumuman = Pengumuman::all();
      foreach ($allMataPelajaran as $a) {
         $jadwal[$a->HARI_PELAJARAN][$a->JAM_PELAJARAN] = $a;
      }
      if($kelas != null) {
         $waliKelas = DetailKelas::find($kelas->ID_DETAIL_KELAS);
         return view('guru_pages.home', ['wali_kelas' => $waliKelas, 'mata_pelajaran' => $allMataPelajaran, 'all_tugas' => $allTugas, 'all_pengumuman' => $allPengumuman, 'jadwal' => $jadwal]);
      } else {
         return view('guru_pages.home', ['wali_kelas' => null, 'mata_pelajaran' => $allMataPelajaran, 'all_tugas' => $allTugas, 'all_pengumuman' => $allPengumuman, 'jadwal' => $jadwal]);
      }
    }
    public function detail_pelajaran($id_mata_pelajaran)
    {
      // session(['kelasActive' => $id_mata_pelajaran]);
      $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
      $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
      $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
      $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
      $materi = Materi::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      $tugas = Tugas::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      return view('guru_pages.detail_pelajaran', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'materi' => $materi, 'tugas' => $tugas]);
    }
    public function editmateri($id_mata_pelajaran)
    {
       $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
        $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
        $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
        $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
        $materi = Materi::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
        return view('guru_pages.editmateri', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'materi' => $materi]);
    }
     public function updatemateri(Request $request, $id_materi){
        $materi = Materi::find($id_materi);
        $materi->Nama_materi = $request->input('NAMA_MATERI');
        $materi->Deskripsi_materi = $request->input('DESKRIPSI_MATERI');
        $materi->File_materi = $request->file('FILE_MATERI');
        $materi->save();
        return redirect(url('/guru/detail_pelajaran/' . urlencode($request->ID_MATA_PELAJARAN)));
    }
    public function editpengumuman($id_mata_pelajaran)
    {
        $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
        $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
        $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
        $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
        $pengumuman = Pengumuman::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
        return view('guru_pages.editpengumuman', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'pengumuman' => $pengumuman]);
    }
    public function updatepengumuman(Request $request, $id){
        $pengumuman = Pengumuman::find($id);
        $pengumuman->Judul = $request->input('Judul');
        $pengumuman->Deskripsi = $request->input('Deskripsi');
        $pengumuman->save();
        return redirect(url('/guru/detail_pelajaran/' . urlencode($request->ID_MATA_PELAJARAN)));
    }
    public function edittugas($id_mata_pelajaran)
    {
       $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
        $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
        $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
        $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
        $tugas = Tugas::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
        return view('guru_pages.edittugas',["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'tugas' => $tugas]);
    }
    public function updatetugas(Request $request, $id_tugas){
        $tugas = Tugas::find($id_tugas);
        $tugas->Nama_tugas = $request->input('NAMA_TUGAS');
        $tugas->Deskripsi_tugas = $request->input('DESKRIPSI_TUGAS');
        $tugas->File_tugas = $request->file('FILE_TUGAS');
        $tugas->save();
        return redirect(url('/guru/detail_pelajaran/' . urlencode($request->ID_MATA_PELAJARAN)));
    }
    public function hlm_about()
    {
       $guru = Guru::find(session('userActive')->ID_GURU);

        if (!$guru) {
            return response()->json(['message' => 'Guru tidak ditemukan.'], 404);
        }
        $kelas = Kelas::where('ID_GURU', '=', session('userActive')->ID_GURU)->first();
        $waliKelas = DetailKelas::find($kelas->ID_DETAIL_KELAS);  
        return view('guru_pages.hlm_about', [
          'guru' => $guru,
          'waliKelas' => $waliKelas
        ]);
    }
    public function hlm_detail_pengumuman()
    {
        return view('guru_pages.hlm_detail_pengumuman');
    }
    public function hlm_detail_tugas($id_tugas)
    {
        $id_tugas = str_replace('+', ' ', $id_tugas);
        $tugas = Tugas::find($id_tugas);
        return view('guru_pages.hlm_detail_tugas', [
          'tugas' => $tugas
        ]);
    }

    public function hlm_edit_about()
    {
       $guru = Guru::find(session('userActive')->ID_GURU);

        if (!$guru) {
            return response()->json(['message' => 'Guru tidak ditemukan.'], 404);
        }

        return view('guru_pages.hlm_edit_about', [
          'guru' => $guru
        ]);
    }
    public function update_biodata(Request $request)
    {
        // Ambil data siswa berdasarkan session
        $guru = Guru::find(session('userActive')->ID_GURU);

        if (!$guru) {
            return response()->json(['message' => 'Guru tidak ditemukan.'], 404);
        }

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'password' => 'nullable|string|min:5', // Jika password diubah
        ]);

        // Update data siswa
        $guru->NAMA_GURU = $validatedData['nama'];
        $guru->EMAIL_GURU = $validatedData['email'];
        $guru->ALAMAT_GURU = $validatedData['alamat'];
        $guru->NO_TELPON_GURU = $validatedData['telepon'];

        // Update password jika ada perubahan
        if ($request->has('password') && !empty($validatedData['password'])) {
            $guru->PASSWORD_GURU = $validatedData['password'];  // Encrypt password
        }

        $guru->save();

        return redirect('/guru/hlm_about')->with('success', 'Biodata berhasil diperbarui');
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
    public function tambahpengumuman($id_mata_pelajaran)
    {
      $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
      $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
      $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
      $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
      $pengumuman = Pengumuman::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      return view('guru_pages.tambahpengumuman', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'pengumuman' => $pengumuman]);
    }

     public function postpengumuman(Request $request)
    {

      //   $uploadDir = 'uploads/materi/';
      //   if (!is_dir($uploadDir)) {
      //    mkdir($uploadDir, 0777, true);
      //    }
      //   $filename = basename($file);
      //   move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $filename);

        $validatedData = $request->validate([
            'ID_MATA_PELAJARAN' => 'required|max:255',
            'JUDUL_PENGUMUMAN' => 'required|max:255',
            'DETAIL_PENGUMUMAN' => 'required',
        ]);
        $pengumuman = Pengumuman::create($validatedData);
        return redirect(url('/guru/detail_pelajaran/' . urlencode($request->ID_MATA_PELAJARAN)));
    }

    public function tambahpertemuan($id_mata_pelajaran)
    {
      $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
      $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
      $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
      $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
      $pertemuan = Pertemuan::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      return view('guru_pages.tambahpertemuan', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'pertemuan' => $pertemuan]);
    }
    
     public function postpertemuan(Request $request)
    {

      //   $uploadDir = 'uploads/materi/';
      //   if (!is_dir($uploadDir)) {
      //    mkdir($uploadDir, 0777, true);
      //    }
      //   $filename = basename($file);
      //   move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $filename);

        $validatedData = $request->validate([
            'ID_MATA_PELAJARAN' => 'required|max:255',
            'DETAIL_PERTEMUAN' => 'required|max:255',
            'TANGGAL_PERTEMUAN' => 'required',
        ]);
        $pertemuan = Pertemuan::create($validatedData);
        return redirect(url('/guru/detail_pelajaran/' . urlencode($request->ID_MATA_PELAJARAN)));
    }

    public function uploadmateri($id_mata_pelajaran)
    {
      $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
      $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
      $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
      $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
      $materi = Materi::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      return view('guru_pages.uploadmateri', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'materi' => $materi]);
    }

    public function postmateri(Request $request)
    {

      //   $uploadDir = 'uploads/materi/';
      //   if (!is_dir($uploadDir)) {
      //    mkdir($uploadDir, 0777, true);
      //    }
      //   $filename = basename($file);
      //   move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $filename);

        $validatedData = $request->validate([
            'ID_MATA_PELAJARAN' => 'required|max:255',
            'NAMA_MATERI' => 'required|max:255',
            'DESKRIPSI_MATERI' => 'required',
            'FILE_MATERI' => 'required',
        ]);

        if ($request->hasFile('FILE_MATERI')) {
            $file = $request->file('FILE_MATERI');
            $filename = $file->getClientOriginalName();
            $filepath = $file->storeAs('uploads/materi', $filename, 'public');
            $validatedData['FILE_MATERI'] = $filename;
         }

        $materi = Materi::create($validatedData);
      
        return redirect(url('/guru/detail_pelajaran/' . urlencode($request->ID_MATA_PELAJARAN)));
    }
    public function posttugas(Request $request)
    {

      //   $uploadDir = 'uploads/materi/';
      //   if (!is_dir($uploadDir)) {
      //    mkdir($uploadDir, 0777, true);
      //    }
      //   $filename = basename($file);
      //   move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $filename);

        $validatedData = $request->validate([
            'ID_MATA_PELAJARAN' => 'required|max:255',
            'NAMA_TUGAS' => 'required|max:255',
            'DESKRIPSI_TUGAS' => 'required',
            'DEADLINE_TUGAS' => 'required',
        ]);

        $tugas = Tugas::create($validatedData);
      
        return redirect(url('/guru/detail_pelajaran/' . urlencode($request->ID_MATA_PELAJARAN)));
    }
    public function uploadtugas($id_mata_pelajaran)
    {
      $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
      $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
      $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
      $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
      $tugas = Tugas::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      return view('guru_pages.uploadtugas', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'tugas' => $tugas]);
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
