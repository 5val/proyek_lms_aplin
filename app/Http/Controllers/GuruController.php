<?php

namespace App\Http\Controllers;

use App\Imports\InsertNilaiExcel;
use App\Models\Attendance;
use App\Models\DetailKelas;
use App\Models\EnrollmentKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\NilaiKelas;
use App\Models\Periode;
use App\Models\SubmissionTugas;
use App\Models\Materi;
use App\Models\Pengumuman;
use App\Models\Pertemuan;
use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function index()
    {
      $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();
      $kelas = Kelas::where('ID_GURU', '=', session('userActive')->ID_GURU)->where('ID_PERIODE', '=', $periode->ID_PERIODE)->first();
      $allMataPelajaran = DB::table('mata_pelajaran as mp')
         ->join('kelas as k', 'mp.id_kelas', '=', 'k.id_kelas')
         ->join('detail_kelas as dk', 'dk.id_detail_kelas', '=', 'k.id_detail_kelas')
         ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
         ->where('mp.id_guru', session('userActive')->ID_GURU)
         ->where('k.id_periode', $periode->ID_PERIODE)
         ->select('mp.id_mata_pelajaran', 'dk.nama_kelas', 'p.nama_pelajaran', 'mp.jam_pelajaran', 'mp.hari_pelajaran')
         ->get();
      // $allTugas = Tugas::with(['mataPelajaran.pelajaran'])
      //    ->whereHas('mataPelajaran', function ($id) {
      //       $id->where('id_guru', '=', session('userActive')->ID_GURU);
      //    })->get();
      $allTugas = DB::table("tugas as t")
         ->join('mata_pelajaran as mp', 't.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
         ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
         ->join('kelas as k', 'mp.id_kelas', '=', 'k.id_kelas')
         ->where([['mp.id_guru', session('userActive')->ID_GURU], ['k.id_periode', $periode->ID_PERIODE], ['t.deadline_tugas', '>=', now()]])
         ->select('t.id_tugas', 'p.nama_pelajaran', 't.deskripsi_tugas', 't.deadline_tugas')
         ->get();
      $allPengumuman = Pengumuman::all();
      $jadwal = [];
      foreach ($allMataPelajaran as $a) {
         $hariKey = ucfirst(strtolower($a->hari_pelajaran));

         // Normalize jam to format "HH:MM-HH:MM" regardless of spacing or dash type
         $jamRaw = $a->jam_pelajaran;
         $jamKey = $jamRaw;
         if (preg_match('/(\d{2}:\d{2})\s*[\-–—]\s*(\d{2}:\d{2})/', $jamRaw, $m)) {
            $jamKey = $m[1] . '-' . $m[2];
         }

         $jadwal[$hariKey][$jamKey] = $a;
      }
      if($kelas != null) {
         $waliKelas = DetailKelas::find($kelas->ID_DETAIL_KELAS);
         return view('guru_pages.home', ['wali_kelas' => $waliKelas, 'periode' => $periode, 'mata_pelajaran' => $allMataPelajaran, 'all_tugas' => $allTugas, 'all_pengumuman' => $allPengumuman, 'jadwal' => $jadwal]);
      } else {
         return view('guru_pages.home', ['wali_kelas' => null, 'periode' => $periode, 'mata_pelajaran' => $allMataPelajaran, 'all_tugas' => $allTugas, 'all_pengumuman' => $allPengumuman, 'jadwal' => $jadwal]);
      }
    }

    public function hlm_detail_pengumpulan($id_submission){
      $id_submission = base64_decode($id_submission);
      $submission = SubmissionTugas::with(['tugas', 'siswa'])->where('ID_SUBMISSION', $id_submission)->first();
      return view('guru_pages.hlm_detail_pengumpulan', ['submission' => $submission]);
    }
    public function put_nilai_tugas(Request $request){
      $id_submission = $request->input('ID_SUBMISSION');
      $nilai = $request->input('nilai');
      $submission = SubmissionTugas::with(['tugas', 'siswa'])->where('ID_SUBMISSION', $id_submission)->first();
      $submission->update([
         "NILAI_TUGAS" => $nilai
      ]);
      return view('guru_pages.hlm_detail_pengumpulan', ['submission' => $submission]);
    }
    public function detail_pelajaran($id_mata_pelajaran)
    {
      $id_mata_pelajaran = base64_decode($id_mata_pelajaran);
      $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
      $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
      $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
      $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
      $materi = Materi::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      $tugas = Tugas::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      $siswa = EnrollmentKelas::with(['siswa', 'kelas'])->where('id_kelas', '=', $kelas->ID_KELAS)->get();
      $pertemuan = Pertemuan::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->orderBy('TANGGAL_PERTEMUAN', 'asc')->get();
      $listNilaiTugas = DB::table('submission_tugas as st')
            ->join('tugas as t', 'st.id_tugas', '=', 't.id_tugas')
            ->join('siswa as s', 'st.id_siswa', '=', 's.id_siswa')
            ->join('mata_pelajaran as mp', 't.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->where('mp.id_mata_pelajaran', '=', $id_mata_pelajaran)
            ->select('st.id_submission', 'st.id_siswa', 's.nama_siswa', 'p.nama_pelajaran', 't.nama_tugas', 'st.nilai_tugas')
            ->get();
      $rata2Tugas = DB::table('submission_tugas as st')
            ->join('tugas as t', 'st.id_tugas', '=', 't.id_tugas')
            ->join('siswa as s', 'st.id_siswa', '=', 's.id_siswa')
            ->join('mata_pelajaran as mp', 't.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->where('mp.id_mata_pelajaran', '=', $id_mata_pelajaran)
            ->groupBy('t.nama_tugas')
            ->select('t.nama_tugas', DB::raw('AVG(st.nilai_tugas) as rata2'))
            ->get();
      $listNilai = DB::table('nilai_kelas as nk')
            ->join('mata_pelajaran as mp', 'nk.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->join('siswa as s', 's.id_siswa', '=', 'nk.id_siswa')
            ->where('mp.id_mata_pelajaran', '=', $id_mata_pelajaran)
            ->select('nk.id_nilai', 's.nama_siswa', 'p.nama_pelajaran', 'nk.nilai_uts', 'nk.nilai_uas', 'nk.nilai_tugas', 'nk.nilai_akhir')
            ->get();
      $rata2 = DB::table('nilai_kelas as nk')
         ->join('mata_pelajaran as mp', 'nk.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
         ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
         ->join('siswa as s', 's.id_siswa', '=', 'nk.id_siswa')
         ->where('mp.id_mata_pelajaran', '=', $id_mata_pelajaran)
         ->groupBy('mp.id_mata_pelajaran')
         ->select(DB::raw('AVG(nk.nilai_akhir) as rata2'))
         ->get();
      $absen = DB::table('attendance as a')
         ->join('pertemuan as p', 'a.id_pertemuan', '=', 'p.id_pertemuan')
         ->join('siswa as s', 's.id_siswa', '=', 'a.id_siswa')
         ->where('p.id_mata_pelajaran', '=', $id_mata_pelajaran)
         ->select('a.id_attendance', 'p.id_pertemuan', 's.id_siswa', 's.nama_siswa', DB::raw('a.status as STATUS'))
         ->get();
      $arrAbsen = [];
      foreach ($absen as $a) {
         $arrAbsen[$a->id_siswa][$a->id_pertemuan] = $a;
      }
   $pengumuman = Pengumuman::all();
      return view('guru_pages.detail_pelajaran', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'materi' => $materi, 'tugas' => $tugas, 'siswa' => $siswa, 'pertemuan' => $pertemuan, 'list_nilai_tugas' => $listNilaiTugas, 'rata2_tugas' => $rata2Tugas, 'list_nilai' => $listNilai, 'rata2' => $rata2, 'absen' => $arrAbsen, 'pengumuman' => $pengumuman]);
    }
      public function editpengumuman(Request $request, $ID = null)
      {
            if (!$ID) {
                  return redirect()->back()->withErrors(['msg' => 'ID pengumuman wajib diisi.']);
            }

            $pengumuman = Pengumuman::find($ID);
            if (!$pengumuman) {
                  return redirect()->back()->withErrors(['msg' => 'Pengumuman tidak ditemukan.']);
            }

            $mataPelajaran = $request->query('mata_pelajaran');
            return view('guru_pages.editpengumuman', ['pengumuman' => $pengumuman, 'mata_pelajaran' => $mataPelajaran]);
      }
    public function updatepengumuman(Request $request, $ID){
      $ID = base64_decode($ID);
        $pengumuman = Pengumuman::find($ID);
        if (!$pengumuman) {
            return redirect()->back()->withErrors(['msg' => 'Pengumuman tidak ditemukan.']);
        }
         $validatedData = $request->validate([
          'Judul' => 'required|string|max:255',
          'Deskripsi' => 'nullable|string',
          'ID_MATA_PELAJARAN' => 'required|max:255',
         // tambahkan validasi lain sesuai kebutuhan
         ]);
         // Persist using actual column names
         $pengumuman->JUDUL = $validatedData['Judul'];
         $pengumuman->ISI = $validatedData['Deskripsi'];
        $pengumuman->save();
        return redirect(url('/guru/detail_pelajaran/' . base64_encode($request->input('ID_MATA_PELAJARAN'))));
      //   return redirect(url('/guru/detail_pelajaran/' . base64_encode($request)));
      //   return redirect(url('/guru/detail_pelajaran/'));
    }

    public function deletepengumuman($ID)
      {
         // $ID = base64_decode($ID);
         $pengumuman = Pengumuman::find($ID);

         if (!$pengumuman) {
            return redirect()->back()->withErrors(['msg' => 'Pengumuman tidak ditemukan.']);
         }

         $pengumuman->delete();

         return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
      }
    public function deletemateri($id_materi)
      {
         $id_materi = base64_decode($id_materi);
         $materi = Materi::find($id_materi);

         if (!$materi) {
            return redirect()->back()->withErrors(['msg' => 'Materi tidak ditemukan.']);
         }

         $id_mata_pelajaran = $materi->ID_MATA_PELAJARAN;
         $materi->delete();

        return redirect()->back()->with('success', 'Materi berhasil dihapus.');
      }
    public function deletetugas($id_tugas)
      {
         $id_tugas = base64_decode($id_tugas);
         $tugas = Tugas::find($id_tugas);

         if (!$tugas) {
            return redirect()->back()->withErrors(['msg' => 'Tugas tidak ditemukan.']);
         }

         $id_mata_pelajaran = $tugas->ID_MATA_PELAJARAN;
         $tugas->delete();

         return redirect()->back()->with('success', 'Tugas berhasil dihapus.');
      }

    public function edittugas($id_tugas)
    {
      // $id_tugas = base64_decode($id_tugas);
       $tugas = Tugas::findOrFail($id_tugas);
        $mataPelajaran = $tugas->mataPelajaran; // asumsi relasi `mataPelajaran` ada
        $kelas = Kelas::with('detailKelas')->find($mataPelajaran->ID_KELAS);
        $jumlah = EnrollmentKelas::where('ID_KELAS', $mataPelajaran->ID_KELAS)->count();
        $semester = substr($mataPelajaran->ID_KELAS, -1) == '1' ? 'Ganjil' : 'Genap';
        return view('guru_pages.edittugas',["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'tugas' => $tugas]);
    }
    public function updatetugas(Request $request, $id_tugas){
      $id_tugas = base64_decode($id_tugas);
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

        return redirect(url('/guru/detail_pelajaran/' . base64_encode($request->ID_MATA_PELAJARAN)));
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
   $id_tugas = base64_decode($id_tugas);
   //  $id_tugas = str_replace('+', ' ', $id_tugas);
   $tugas = Tugas::with('mataPelajaran')->find($id_tugas);

    if (!$tugas) {
        return redirect()->back()->withErrors(['msg' => 'Tugas tidak ditemukan.']);
    }

   $mataPelajaran = $tugas->mataPelajaran;

   if (!$mataPelajaran) {
      return redirect()->back()->withErrors(['msg' => 'Mata pelajaran untuk tugas ini tidak ditemukan.']);
   }

   $idKelas = $mataPelajaran->ID_KELAS;

   $siswaKelas = Siswa::whereHas('kelass', function ($query) use ($idKelas) {
      $query->where('ENROLLMENT_KELAS.ID_KELAS', $idKelas);
   })->orderBy('NAMA_SISWA')->get();

    $submissions = SubmissionTugas::with('siswa')
        ->where('ID_TUGAS', $id_tugas)
      ->whereHas('siswa.kelass', function ($query) use ($idKelas) {
         $query->where('ENROLLMENT_KELAS.ID_KELAS', $idKelas);
      })
        ->get();

    // Ambil ID siswa yang sudah mengumpulkan
   $siswaSudahIds = $submissions->pluck('ID_SISWA')->unique()->toArray();

   $siswaSudah = $siswaKelas->whereIn('ID_SISWA', $siswaSudahIds)->values();
   $siswaBelum = $siswaKelas->whereNotIn('ID_SISWA', $siswaSudahIds)->values();

    return view('guru_pages.hlm_detail_tugas', [
        'tugas' => $tugas,
        'submissions' => $submissions,
        'siswaSudah' => $siswaSudah,
        'siswaBelum' => $siswaBelum
    ]);
}

   public function edit_nilai_tugas($id_submission){
      $id_submission = base64_decode($id_submission);
      $submission = SubmissionTugas::with(['tugas', 'siswa'])->where('ID_SUBMISSION', $id_submission)->first();
      return view('guru_pages.edit_nilai_tugas', ['submission' => $submission]);
   }

   public function update_nilai_tugas(Request $request){
      $id_submission = $request->input('ID_SUBMISSION');
      $nilai = $request->input('nilai');
      $submission = SubmissionTugas::with(['tugas', 'siswa'])->where('ID_SUBMISSION', $id_submission)->first();
      $submission->update([
         "NILAI_TUGAS" => $nilai
      ]);
      return redirect($request->input('redirect_to'));
    }

    public function edit_nilai_ujian($id_nilai){
      $id_nilai = base64_decode($id_nilai);
      $nilai = NilaiKelas::with('siswa')->where('ID_NILAI', $id_nilai)->first();
      $mata_pelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $nilai->ID_MATA_PELAJARAN)->first();
      return view('guru_pages.edit_nilai_ujian', ['nilai' => $nilai, 'mata_pelajaran' => $mata_pelajaran]);
   }
   public function update_nilai_ujian(Request $request){
      $id_nilai = $request->input('ID_NILAI');
      $nilai_uts = $request->input('nilai_uts');
      $nilai_uas = $request->input('nilai_uas');
      $nilai = NilaiKelas::where('ID_NILAI', $id_nilai)->first();
      $nilai->update([
         "NILAI_UTS" => $nilai_uts,
         "NILAI_UAS" => $nilai_uas,
         "NILAI_AKHIR" => 0.4*$nilai_uts + 0.4*$nilai_uas + 0.2*$nilai->NILAI_TUGAS
      ]);
      return redirect($request->input('redirect_to'));
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
    $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();

    $allMataPelajaran = DB::table('mata_pelajaran as mp')
        ->join('kelas as k', 'mp.id_kelas', '=', 'k.id_kelas')
        ->join('detail_kelas as dk', 'dk.id_detail_kelas', '=', 'k.id_detail_kelas')
        ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
        ->where('mp.id_guru', session('userActive')->ID_GURU)
        ->where('k.id_periode', $periode->ID_PERIODE)
        ->select('mp.id_mata_pelajaran', 'dk.nama_kelas', 'p.nama_pelajaran', 'mp.jam_pelajaran', 'mp.hari_pelajaran')
        ->get();

    $jadwal = [];
    foreach ($allMataPelajaran as $a) {
        $jadwal[$a->hari_pelajaran][$a->jam_pelajaran] = $a;
    }
    return view('guru_pages.hlm_jadwal', [
        'jadwal' => $jadwal,
        'periode' => $periode,
        'mata_pelajaran' => $allMataPelajaran
    ]);
}

    public function hlm_kelas()
    {
      $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();
      $all_kelas = DB::table('mata_pelajaran as mp')
         ->join('kelas as k', 'mp.id_kelas', '=', 'k.id_kelas')
         ->join('detail_kelas as dk', 'dk.id_detail_kelas', '=', 'k.id_detail_kelas')
         ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
         ->where('mp.id_guru', session('userActive')->ID_GURU)
         ->where('k.id_periode', $periode->ID_PERIODE)
         ->select('mp.id_mata_pelajaran', 'dk.nama_kelas', 'p.nama_pelajaran', 'mp.jam_pelajaran', 'mp.hari_pelajaran')
         ->get();
      $all_periode = Periode::all();
      return view('guru_pages.hlm_kelas', ['periode' => $periode, 'all_kelas' => $all_kelas, 'all_periode'=>$all_periode]);
    }
    public function get_kelas_periode(Request $request)
    {
      $periode = $request->id_periode;
      $id_guru = session('userActive')->ID_GURU;
      $all_kelas = DB::table('mata_pelajaran as mp')
         ->join('kelas as k', 'mp.id_kelas', '=', 'k.id_kelas')
         ->join('detail_kelas as dk', 'dk.id_detail_kelas', '=', 'k.id_detail_kelas')
         ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
         ->where('mp.id_guru', $id_guru)
         ->where('k.id_periode', $periode)
         ->select('mp.id_mata_pelajaran', 'dk.nama_kelas', 'p.nama_pelajaran', 'mp.jam_pelajaran', 'mp.hari_pelajaran')
         ->get();
      return response()->json($all_kelas);
    }

    public function hlm_laporan_tugas(Request $request)
    {
      if($request->query('periodeSelect')){
         $periode = Periode::where('ID_PERIODE', $request->query('periodeSelect'))->first();
      } else {
         $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();
      }
      $kelas = Kelas::with('detailKelas')->where('ID_GURU', '=', session('userActive')->ID_GURU)->where('ID_PERIODE', '=', $periode->ID_PERIODE)->first();
      $kelas_periode = Kelas::with('periode')->where('ID_GURU', session('userActive')->ID_GURU)->get();
      $allPeriode = Periode::all();
      if($kelas != null) {
         $listNilai = DB::table('submission_tugas as st')
            ->join('tugas as t', 'st.id_tugas', '=', 't.id_tugas')
            ->join('siswa as s', 'st.id_siswa', '=', 's.id_siswa')
            ->join('mata_pelajaran as mp', 't.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->where('mp.id_kelas', '=', $kelas->ID_KELAS)
            ->select('st.id_submission', 'st.id_siswa', 's.nama_siswa', 't.nama_tugas', 'p.nama_pelajaran', 'st.nilai_tugas')
            ->get();
         $rata2 = DB::table('submission_tugas as st')
            ->join('tugas as t', 'st.id_tugas', '=', 't.id_tugas')
            ->join('siswa as s', 'st.id_siswa', '=', 's.id_siswa')
            ->join('mata_pelajaran as mp', 't.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->where('mp.id_kelas', '=', $kelas->ID_KELAS)
            ->groupBy('t.nama_tugas')
            ->select('t.nama_tugas', DB::raw('AVG(st.nilai_tugas) as rata2'))
            ->get();
         $rata2SiswaTugas = DB::table('submission_tugas as st')
            ->join('tugas as t', 'st.id_tugas', '=', 't.id_tugas')
            ->join('siswa as s', 'st.id_siswa', '=', 's.id_siswa')
            ->join('mata_pelajaran as mp', 't.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->where('mp.id_kelas', '=', $kelas->ID_KELAS)
            ->groupBy('s.nama_siswa')
            ->select('s.nama_siswa', DB::raw('AVG(st.nilai_tugas) as rata2'))
            ->get();
         return view('guru_pages.hlm_laporan_tugas', [
            'kelas' => $kelas,
            'kelas_periode' => $kelas_periode,
            'periode' => $periode,
            'list_nilai' => $listNilai,
            'rata2' => $rata2,
            'rata2SiswaTugas' => $rata2SiswaTugas,
            'allPeriode' => $allPeriode,
         ]);
      } else {
         return view('guru_pages.hlm_laporan_tugas', ['kelas' => null , 'kelas_periode' => $kelas_periode, 'periode' => $periode, 'allPeriode'=>$allPeriode]);
      }
    }
    public function hlm_laporan_ujian(Request $request)
    {
      if($request->query('periodeSelect')){
         $periode = Periode::where('ID_PERIODE', $request->query('periodeSelect'))->first();
      } else {
         $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();
      }
      $kelas = Kelas::where('ID_GURU', '=', session('userActive')->ID_GURU)->where('ID_PERIODE', '=', $periode->ID_PERIODE)->first();
      $kelas_periode = Kelas::with('periode')->where('ID_GURU', session('userActive')->ID_GURU)->get();
      $allPeriode = Periode::all();
      if($kelas != null) {
         $listNilai = DB::table('nilai_kelas as nk')
            ->join('mata_pelajaran as mp', 'nk.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->join('siswa as s', 's.id_siswa', '=', 'nk.id_siswa')
            ->where('mp.id_kelas', '=', $kelas->ID_KELAS)
            ->select('nk.id_nilai', 's.nama_siswa', 'p.nama_pelajaran', 'nk.nilai_uts', 'nk.nilai_uas', 'nk.nilai_tugas', 'nk.nilai_akhir')
            ->get();
         $rata2 = DB::table('nilai_kelas as nk')
            ->join('mata_pelajaran as mp', 'nk.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->join('siswa as s', 's.id_siswa', '=', 'nk.id_siswa')
            ->where('mp.id_kelas', '=', $kelas->ID_KELAS)
            ->groupBy('p.nama_pelajaran')
            ->select('p.nama_pelajaran', DB::raw('AVG(nk.nilai_akhir) as rata2'))
            ->get();
         $rata2Siswa = DB::table('nilai_kelas as nk')
            ->join('mata_pelajaran as mp', 'nk.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('siswa as s', 's.id_siswa', '=', 'nk.id_siswa')
            ->where('mp.id_kelas', '=', $kelas->ID_KELAS)
            ->groupBy('s.nama_siswa')
            ->select('s.nama_siswa', DB::raw('AVG(nk.nilai_akhir) as rata2'))
            ->get();
         return view('guru_pages.hlm_laporan_ujian', [
            'kelas' => $kelas,
            'kelas_periode' => $kelas_periode,
            'periode' => $periode,
            'list_nilai' => $listNilai,
            'rata2' => $rata2,
            'rata2Siswa' => $rata2Siswa,
            'allPeriode' => $allPeriode,
         ]);
      } else {
         return view('guru_pages.hlm_laporan_ujian', ['kelas' => null , 'kelas_periode' => $kelas_periode, 'periode' => $periode, 'allPeriode'=>$allPeriode]);
      }
    }

    public function laporan_siswa($id_siswa)
    {
      $id_siswa = base64_decode($id_siswa);
      $siswa = Siswa::where('ID_SISWA', '=', $id_siswa)->first();
         $listNilaiTugas = DB::table('submission_tugas as st')
            ->join('tugas as t', 'st.id_tugas', '=', 't.id_tugas')
            ->join('siswa as s', 'st.id_siswa', '=', 's.id_siswa')
            ->join('mata_pelajaran as mp', 't.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->where('s.id_siswa', '=', $id_siswa)
            ->select('st.id_submission', 'st.id_siswa', 's.nama_siswa', 'p.nama_pelajaran', 't.nama_tugas', 'st.nilai_tugas')
            ->get();
         $rata2Tugas = DB::table('submission_tugas as st')
            ->join('tugas as t', 'st.id_tugas', '=', 't.id_tugas')
            ->join('siswa as s', 'st.id_siswa', '=', 's.id_siswa')
            ->join('mata_pelajaran as mp', 't.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->where('s.id_siswa', '=', $id_siswa)
            ->groupBy('p.nama_pelajaran')
            ->select('p.nama_pelajaran', DB::raw('AVG(st.nilai_tugas) as rata2'))
            ->get();
         $listNilai = DB::table('nilai_kelas as nk')
            ->join('mata_pelajaran as mp', 'nk.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->join('siswa as s', 's.id_siswa', '=', 'nk.id_siswa')
            ->where('s.id_siswa', '=', $id_siswa)
            ->select('nk.id_nilai', 's.nama_siswa', 'p.nama_pelajaran', 'nk.nilai_uts', 'nk.nilai_tugas', 'nk.nilai_akhir')
            ->get();
         $rata2 = DB::table('nilai_kelas as nk')
            ->join('mata_pelajaran as mp', 'nk.id_mata_pelajaran', '=', 'mp.id_mata_pelajaran')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->join('siswa as s', 's.id_siswa', '=', 'nk.id_siswa')
            ->where('s.id_siswa', '=', $id_siswa)
            ->groupBy('s.id_siswa')
            ->select(DB::raw('AVG(nk.nilai_akhir) as rata2'))
            ->get();
         return view('guru_pages.hlm_laporan_siswa', ['siswa' => $siswa, 'list_nilai_tugas' => $listNilaiTugas, 'rata2_tugas' => $rata2Tugas, 'list_nilai' => $listNilai, 'rata2' => $rata2]);
    }
    public function tambahpengumuman($id_mata_pelajaran)
    {
      $id_mata_pelajaran = base64_decode($id_mata_pelajaran);
       $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
        $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
        $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
        $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
      $pengumuman = Pengumuman::all();
      return view('guru_pages.tambahpengumuman', ['mata_pelajaran' => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'pengumuman' => $pengumuman]);
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
            'Judul' => 'required|max:255',
            'Deskripsi' => 'required',
        ]);
        $pengumuman = Pengumuman::create($validatedData);

        return redirect(url('/guru/detail_pelajaran/' . base64_encode($request->ID_MATA_PELAJARAN)));
    }

    public function tambahpertemuan($id_mata_pelajaran)
    {
      $id_mata_pelajaran = base64_decode($id_mata_pelajaran);
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
      $validatedData['ID_PERTEMUAN'] = Str::upper(Str::uuid()->toString());
      $pertemuan = Pertemuan::create($validatedData);
        return redirect(url('/guru/detail_pelajaran/' . base64_encode($request->ID_MATA_PELAJARAN)));
    }

   public function updatepertemuan(Request $request, $id_pertemuan)
   {
      $id = base64_decode($id_pertemuan);
      $pertemuan = Pertemuan::find($id);
      if (! $pertemuan) {
         return redirect()->back()->withErrors(['msg' => 'Pertemuan tidak ditemukan.']);
      }

      $validatedData = $request->validate([
         'ID_MATA_PELAJARAN' => 'required|max:255',
         'DETAIL_PERTEMUAN' => 'required|max:255',
         'TANGGAL_PERTEMUAN' => 'required|date',
      ]);

      $pertemuan->DETAIL_PERTEMUAN = $validatedData['DETAIL_PERTEMUAN'];
      $pertemuan->TANGGAL_PERTEMUAN = $validatedData['TANGGAL_PERTEMUAN'];
      $pertemuan->save();

      return redirect(url('/guru/detail_pelajaran/' . base64_encode($request->ID_MATA_PELAJARAN)));
   }

   public function deletepertemuan($id_pertemuan)
   {
      $id = base64_decode($id_pertemuan);
      $pertemuan = Pertemuan::find($id);
      if (! $pertemuan) {
         return redirect()->back()->withErrors(['msg' => 'Pertemuan tidak ditemukan.']);
      }
      $idMapel = $pertemuan->ID_MATA_PELAJARAN;
      $pertemuan->delete();
      return redirect(url('/guru/detail_pelajaran/' . base64_encode($idMapel)));
   }

    public function uploadmateri($id_mata_pelajaran)
    {
      $id_mata_pelajaran = base64_decode($id_mata_pelajaran);
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

        return redirect(url('/guru/detail_pelajaran/' . base64_encode($request->ID_MATA_PELAJARAN)));
    }

    public function editmateri($id_materi)
    {
      // $id_materi = base64_decode($id_materi);
        $materi = Materi::findOrFail($id_materi);
        $mataPelajaran = $materi->mataPelajaran;
        $kelas = Kelas::with('detailKelas')->find($mataPelajaran->ID_KELAS);
        $jumlah = EnrollmentKelas::where('ID_KELAS', $mataPelajaran->ID_KELAS)->count();
        $semester = substr($mataPelajaran->ID_KELAS, -1) == '1' ? 'Ganjil' : 'Genap';
        return view('guru_pages.editmateri', ["mata_pelajaran" => $mataPelajaran, "kelas" => $kelas, "jumlah" => $jumlah, "semester" => $semester,"materi" => $materi]);
    }

    public function updatemateri(Request $request, $id_materi){
      $id_materi = base64_decode($id_materi);
      $materi = Materi::find($id_materi);
      if (!$materi) {
         return redirect()->back()->withErrors(['msg' => 'Materi tidak ditemukan.']);
      }
      $validatedData = $request->validate([
         'ID_MATA_PELAJARAN' => 'required|max:255',
         'NAMA_MATERI' => 'required|string|max:255',
         'DESKRIPSI_MATERI' => 'nullable|string',
         'FILE_MATERI' => 'nullable'
      ]);

      if ($request->hasFile('FILE_MATERI')) {
         $prevFilePath = 'uploads/materi/' . $materi->FILE_MATERI;
         if (Storage::disk('public')->exists($prevFilePath)) {
            Storage::disk('public')->delete($prevFilePath);
         }
         $file = $request->file('FILE_MATERI');
         $filename = $file->getClientOriginalName();
         $filepath = $file->storeAs('uploads/materi', $filename, 'public');
         $validatedData['FILE_MATERI'] = $filename;
      }
      $materi->NAMA_MATERI = $validatedData['NAMA_MATERI'];
      $materi->DESKRIPSI_MATERI = $validatedData['DESKRIPSI_MATERI'];
      if (isset($validatedData['FILE_MATERI'])) {
         $materi->FILE_MATERI = $validatedData['FILE_MATERI'];
      }
      $materi->save();
      // $materi->update($validatedData);

      return redirect(url('/guru/detail_pelajaran/' . base64_encode($request->ID_MATA_PELAJARAN)));
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

        return redirect(url('/guru/detail_pelajaran/' . base64_encode($request->ID_MATA_PELAJARAN)));
    }
    public function uploadtugas($id_mata_pelajaran)
    {
      $id_mata_pelajaran = base64_decode($id_mata_pelajaran);
      $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
      $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->count();
      $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
      $semester = substr($mataPelajaran->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
      $tugas = Tugas::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->get();
      return view('guru_pages.uploadtugas', ["mata_pelajaran" => $mataPelajaran, 'jumlah' => $jumlah, 'kelas' => $kelas, 'semester' => $semester, 'tugas' => $tugas]);
    }
    public function walikelas(Request $request)
    {
      if($request->query('periodeSelect')){
         $periode = Periode::where('ID_PERIODE', $request->query('periodeSelect'))->first();
      } else {
         $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();
      }
      $allPeriode = Periode::all();
      $kelas = Kelas::where('ID_GURU', '=', session('userActive')->ID_GURU)->where('ID_PERIODE', '=', $periode->ID_PERIODE)->first();
      $kelas_periode = Kelas::with('periode')->where('ID_GURU', session('userActive')->ID_GURU)->get();

      if($kelas != null) {
         $waliKelas = DetailKelas::find($kelas->ID_DETAIL_KELAS);
         $jumlah = EnrollmentKelas::where('ID_KELAS', '=', $kelas->ID_KELAS)->count();
         $semester = substr($kelas->ID_KELAS, -1) == '1'? 'Ganjil' : 'Genap';
         $daftar_siswa = EnrollmentKelas::with('siswa')->where('ID_KELAS', '=', $kelas->ID_KELAS)->get();
         return view('guru_pages.walikelas', ['kelas_periode' => $kelas_periode, 'wali_kelas' => $waliKelas, 'periode' => $periode, 'jumlah' => $jumlah, 'semester' => $semester, 'daftar_siswa' => $daftar_siswa, 'allPeriode'=>$allPeriode]);
      } else {
         return view('guru_pages.walikelas', ['kelas_periode' => $kelas_periode, 'wali_kelas' => null, 'periode' => $periode, 'allPeriode'=>$allPeriode]);
      }
    }

    public function editattendance(Request $request) {
      $id_siswa = $request->input('id_siswa');
      $id_pertemuan = $request->input('id_pertemuan');
      $statusInput = strtolower((string) $request->input('status', 'hadir'));

      $allowedStatuses = ['hadir', 'izin', 'sakit', 'alpa'];
      $removeSignals = ['false', 'remove', 'hapus'];

      if (in_array($statusInput, $removeSignals, true)) {
         $normalizedStatus = 'Alpa'; // simpan sebagai alpa agar tetap tersimpan sebagai tidak hadir
      } else {
         $normalizedStatus = in_array($statusInput, $allowedStatuses, true)
            ? ucfirst($statusInput)
            : 'Hadir';
      }

      Attendance::updateOrCreate(
         [
            'ID_SISWA' => $id_siswa,
            'ID_PERTEMUAN' => $id_pertemuan,
         ],
         [
            'STATUS' => $normalizedStatus,
         ]
      );

      return response()->json(['message' => 'Absensi diperbarui.']);
   }
    public function upload_nilai(Request $request) {
      $id_mata_pelajaran = $request->query('id_mata_pelajaran');
      $mata_pelajaran = MataPelajaran::with("pelajaran")->where("ID_MATA_PELAJARAN", $id_mata_pelajaran)->first();
      return view('guru_pages.upload_nilai', ["mata_pelajaran" => $mata_pelajaran]);
   }
   public function uploadNilai(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $id_mata_pelajaran = $request->id_mata_pelajaran;
        try {
            Excel::import(new InsertNilaiExcel($id_mata_pelajaran), $request->file('file'));
            Session::flash('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            Session::flash('error', 'Import failed: ' . $e->getMessage());
        }
        return redirect()->back();
    }


}
