<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\EnrollmentKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\SubmissionTugas;
use App\Models\Materi;
use App\Models\Pengumuman;
use App\Models\Pertemuan;
use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;

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
      $tugas = Tugas::with(['mataPelajaran.pelajaran'])
         ->whereHas('mataPelajaran', function ($id) {
            $id->where('id_guru', '=', session('userActive')->ID_GURU);
         })->get();
      $pertemuan = Pertemuan::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      $pengumuman = Pengumuman::all();
      return view('guru_pages.detail_pelajaran', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'materi' => $materi, 'tugas' => $tugas, 'pertemuan' => $pertemuan, 'pengumuman' => $pengumuman]);
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
    
    public function editpengumuman($ID)
    {
        $pengumuman = Tugas::findOrFail($ID);
        $mataPelajaran = $ID->mataPelajaran; // asumsi relasi `mataPelajaran` ada
        $kelas = Kelas::with('detailKelas')->find($mataPelajaran->ID_KELAS);
        $jumlah = EnrollmentKelas::where('ID_KELAS', $mataPelajaran->ID_KELAS)->count();
        $semester = substr($mataPelajaran->ID_KELAS, -1) == '1' ? 'Ganjil' : 'Genap';
        return view('guru_pages.editpengumuman', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'pengumuman' => $pengumuman]);
    }
    public function updatepengumuman(Request $request, $ID){
        $pengumuman = Pengumuman::find($ID);
         $validatedData = $request->validate([
          'Judul' => 'required|string|max:255',
          'Deskripsi' => 'nullable|string'
        // tambahkan validasi lain sesuai kebutuhan
        ]);
        $pengumuman->Judul = $validatedData['Judul'];
        $pengumuman->Deskripsi = $validatedData['Deskripsi'];
        $pengumuman->save();
        return redirect(url('/guru/detail_pelajaran/' . urlencode($request->ID_MATA_PELAJARAN)));
    }
    public function edittugas($id_tugas)
    {
       $tugas = Tugas::findOrFail($id_tugas);
        $mataPelajaran = $tugas->mataPelajaran; // asumsi relasi `mataPelajaran` ada
        $kelas = Kelas::with('detailKelas')->find($mataPelajaran->ID_KELAS);
        $jumlah = EnrollmentKelas::where('ID_KELAS', $mataPelajaran->ID_KELAS)->count();
        $semester = substr($mataPelajaran->ID_KELAS, -1) == '1' ? 'Ganjil' : 'Genap';
        return view('guru_pages.edittugas',["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'tugas' => $tugas]);
    }
    public function updatetugas(Request $request, $id_tugas){
        $tugas = Tugas::find($id_tugas);
        if (!$tugas) {
            return redirect()->back()->withErrors(['msg' => 'Tugas tidak ditemukan.']);
        }
        $validatedData = $request->validate([
        'ID_MATA_PELAJARAN' => 'required|max:255',
        'NAMA_TUGAS' => 'required|string|max:255',
        'DESKRIPSI_TUGAS' => 'nullable|string',
        'DEADLINE_TUGAS' => 'required|date',
        // tambahkan validasi lain sesuai kebutuhan
        ]);
        $tugas->NAMA_TUGAS = $validatedData['NAMA_TUGAS'];
        $tugas->DESKRIPSI_TUGAS = $validatedData['DESKRIPSI_TUGAS'];
        $tugas->DEADLINE_TUGAS = $validatedData['DEADLINE_TUGAS'];
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
          'wali_kelas' => $waliKelas
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

    if (!$tugas) {
        return redirect()->back()->withErrors(['msg' => 'Tugas tidak ditemukan.']);
    }

    // Ambil semua siswa
    $siswaSemua = Siswa::all();

    // Ambil submission tugas ini
    $submissions = SubmissionTugas::with('siswa')
        ->where('ID_TUGAS', $id_tugas)
        ->get();

    // Ambil ID siswa yang sudah mengumpulkan
    $siswaSudahIds = $submissions->pluck('ID_SISWA')->toArray();

    // Siswa yang sudah dan belum
    $siswaSudah = Siswa::whereIn('ID_SISWA', $siswaSudahIds)->get();
    $siswaBelum = Siswa::whereNotIn('ID_SISWA', $siswaSudahIds)->get();

    return view('guru_pages.hlm_detail_tugas', [
        'tugas' => $tugas,
        'submissions' => $submissions,
        'siswaSudah' => $siswaSudah,
        'siswaBelum' => $siswaBelum
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
      $allMataPelajaran = MataPelajaran::with(['kelas.detailKelas', 'pelajaran'])->where('ID_GURU', '=', session('userActive')->ID_GURU)->get();
      foreach ($allMataPelajaran as $a) {
        $jadwal[$a->HARI_PELAJARAN][$a->JAM_PELAJARAN] = $a;
      }
        return view('guru_pages.hlm_jadwal', ['jadwal' => $jadwal]);
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
      $pengumuman = Pengumuman::all();
      return view('guru_pages.tambahpengumuman', ['mataPelajaran' => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'pengumuman' => $pengumuman]);
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
            'Judul' => 'required|max:255',
            'Isi' => 'required',
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
