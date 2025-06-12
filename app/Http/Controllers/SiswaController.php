<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\EnrollmentKelas;
use App\Models\SubmissionTugas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Tugas;
use App\Models\Pelajaran;
use App\Models\Pengumuman;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::all();
        $siswa = Siswa::find(session('userActive')->ID_SISWA);

        // Ambil kelas terakhir yang di-enroll siswa
        $lastEnrollment = DB::table('ENROLLMENT_KELAS')
            ->where('ID_SISWA', $siswa->ID_SISWA)
            ->orderByDesc('ID_KELAS') // atau pakai timestamp jika ada
            ->first();

        if (!$lastEnrollment) {
            return response()->json(['message' => 'Kelas siswa tidak ditemukan.'], 404);
        }

        $idKelasTerakhir = $lastEnrollment->ID_KELAS;

        // Ambil ID_PERIODE dari kelas terakhir tersebut
        $kelasTerakhir = DB::table('KELAS')
            ->where('ID_KELAS', $idKelasTerakhir)
            ->first();

        if (!$kelasTerakhir) {
            return response()->json(['message' => 'Data kelas tidak ditemukan.'], 404);
        }

        $currentPeriodeId = $kelasTerakhir->ID_PERIODE;

        // Ambil mata pelajaran di kelas terakhir dan periode tersebut
        $mataPelajaran = DB::table('MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('MATA_PELAJARAN.ID_KELAS', $idKelasTerakhir)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->get();

        // Ambil tugas di kelas terakhir dan periode tersebut
        $tugas = DB::table('TUGAS')
            ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('MATA_PELAJARAN.ID_KELAS', $idKelasTerakhir)
            ->where('TUGAS.DEADLINE_TUGAS', '>', now())
            ->select('TUGAS.NAMA_TUGAS', 'TUGAS.DEADLINE_TUGAS', 'TUGAS.ID_TUGAS', 'PELAJARAN.NAMA_PELAJARAN')
            ->get();

        // Ambil jadwal pelajaran di kelas terakhir dan periode tersebut
        $jadwal = DB::table('MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('MATA_PELAJARAN.ID_KELAS', $idKelasTerakhir)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'MATA_PELAJARAN.HARI_PELAJARAN', 'MATA_PELAJARAN.JAM_PELAJARAN')
            ->get();

        $jadwalByDay = [];
        foreach ($jadwal as $item) {
            $jadwalByDay[$item->HARI_PELAJARAN][$item->JAM_PELAJARAN] = $item->NAMA_PELAJARAN;
        }

        // Ambil info kelas terakhir beserta periode
        $kelasInfo = DB::table('DETAIL_KELAS')
            ->join('KELAS', 'DETAIL_KELAS.ID_DETAIL_KELAS', '=', 'KELAS.ID_DETAIL_KELAS')
            ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
            ->where('KELAS.ID_KELAS', $idKelasTerakhir)
            ->select('DETAIL_KELAS.NAMA_KELAS', 'PERIODE.PERIODE')
            ->first();

        return view('siswa_pages.home', [
            "pengumuman" => $pengumuman,
            "matapelajaran" => $mataPelajaran,
            "tugas" => $tugas,
            "jadwal" => $jadwalByDay,
            "kelas" => $kelasInfo
        ]);
    }


    public function detail_pelajaran($id_mata_pelajaran)
    {
        $id_mata_pelajaran = base64_decode($id_mata_pelajaran);
        $mataPelajaran = MataPelajaran::find($id_mata_pelajaran);

        if (!$mataPelajaran) {
            return redirect('/siswa')->with('error', 'Mata Pelajaran tidak ditemukan');
        }

        // Menghitung jumlah murid dari ENROLLMENT_KELAS berdasarkan ID_KELAS
        $jumlahMurid = EnrollmentKelas::where('ID_KELAS', $mataPelajaran->ID_KELAS)->count();

        // Mengambil ruang kelas dari DETAIL_KELAS berdasarkan ID_KELAS
        $detailKelas = DetailKelas::where('ID_DETAIL_KELAS', $mataPelajaran->kelas->ID_DETAIL_KELAS)->first();

        // Mengambil semester dari PERIODE berdasarkan ID_PERIODE
        $semester = Periode::where('ID_PERIODE', $mataPelajaran->kelas->ID_PERIODE)->first();

        // Ambil tugas yang terkait dengan mata pelajaran ini
        $tugas = DB::table('TUGAS')
            ->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)
            ->select(
                'ID_TUGAS',
                'NAMA_TUGAS',
                'DESKRIPSI_TUGAS',
                'DEADLINE_TUGAS',
                DB::raw('(SELECT COUNT(*) FROM SUBMISSION_TUGAS WHERE ID_TUGAS = TUGAS.ID_TUGAS) as jumlah_submisi')
            )
            ->get();

        // Ambil materi yang terkait dengan mata pelajaran ini
        $materi = Materi::where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->get();

        $namaPelajaran = DB::table('MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('MATA_PELAJARAN.ID_MATA_PELAJARAN', $id_mata_pelajaran)
            ->select('PELAJARAN.NAMA_PELAJARAN')
            ->first();

        return view('siswa_pages.detail_pelajaran', [
            'mataPelajaran' => $mataPelajaran,
            'tugas' => $tugas,
            'materi' => $materi,
            'jumlahMurid' => $jumlahMurid,
            'ruangKelas' => $detailKelas ? $detailKelas->RUANGAN_KELAS : 'Tidak Diketahui',
            'semester' => $semester ? $semester->PERIODE : 'Tidak Diketahui',
            'namaPelajaran' => $namaPelajaran ? $namaPelajaran->NAMA_PELAJARAN : 'Tidak Diketahui',
            'detailKelas' => $detailKelas
        ]);
    }
    public function hlm_about()
    {
        // Ambil data siswa berdasarkan session
        $siswa = Siswa::find(session('userActive')->ID_SISWA);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        // Ambil nama kelas berdasarkan kelas yang diikuti oleh siswa
        $kelasInfo = DB::table('ENROLLMENT_KELAS')
            ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('DETAIL_KELAS', 'KELAS.ID_DETAIL_KELAS', '=', 'DETAIL_KELAS.ID_DETAIL_KELAS')
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('DETAIL_KELAS.NAMA_KELAS', 'KELAS.ID_KELAS')
            ->first(); // Mengambil data kelas siswa

        // Kirim data siswa dan nama kelas ke view
        return view('siswa_pages.hlm_about', [
            'siswa' => $siswa,
            'kelasInfo' => $kelasInfo,
        ]);
    }
    public function hlm_detail_tugas($id_tugas)
    {
        $id_tugas =  base64_decode($id_tugas);
        $id_tugas = str_replace('+', ' ', $id_tugas);
        $tugas = Tugas::find($id_tugas);

        if (!$tugas) {
            return redirect('/siswa')->with('error', 'Tugas tidak ditemukan');
        }

        $deadline_passed = false;
        if ($tugas->DEADLINE_TUGAS) {
            $deadlineTimestamp = strtotime($tugas->DEADLINE_TUGAS);
            $nowTimestamp = time();
            if ($deadlineTimestamp < $nowTimestamp) {
                $deadline_passed = true;
            }
        }

        $submission = DB::table('SUBMISSION_TUGAS')
            ->where('ID_SISWA', session('userActive')->ID_SISWA)
            ->where('ID_TUGAS', $id_tugas)
            ->select(
                DB::raw('IFNULL(NILAI_TUGAS, "Belum Dinilai") as NILAI_TUGAS')
            )
            ->first();

        $materi = Materi::where('ID_MATA_PELAJARAN', $tugas->ID_MATA_PELAJARAN)->get();

        return view('siswa_pages.hlm_detail_tugas', [
            'tugas' => $tugas,
            'materi' => $materi,
            'nilai' => $submission ? $submission->NILAI_TUGAS : 'Belum Dinilai',
            'submission' => $submission,
            'deadline_passed' => $deadline_passed,
        ]);
    }

    public function posttugas(Request $request)
    {
        $validatedData = $request->validate([
            'ID_TUGAS' => 'required|max:255',
            'FILE_TUGAS' => 'required|file|', // wajib file dan max 10MB
        ]);

        if ($request->hasFile('FILE_TUGAS')) {
            $file = $request->file('FILE_TUGAS');
            // Ganti semua '/' di ID_SISWA menjadi '_'
            $idSiswa = str_replace('/', '_', session('userActive')->ID_SISWA);
            $filename = time() . '_' . $idSiswa . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->storeAs('uploads/tugas', $filename, 'public');
            $validatedData['FILE_TUGAS'] = $filename;
        }

        $submissionData = [
            'ID_SISWA' => session('userActive')->ID_SISWA,
            'ID_TUGAS' => $validatedData['ID_TUGAS'],
            'TANGGAL_SUBMISSION' => now(),
            'NILAI_TUGAS' => null,
            'FILE_TUGAS' => $validatedData['FILE_TUGAS'],
        ];

        SubmissionTugas::create($submissionData);

        // Redirect ke halaman detail tugas (ganti URL sesuai route kamu)
        return redirect(url('/siswa/hlm_detail_tugas/' . urlencode($validatedData['ID_TUGAS'])));
    }

    // public function download($filename)
    // {
    //     $filePath = 'uploads/materi/' . $filename;

    //     $exists = Storage::disk('public')->exists($filePath);

    //     if (!$exists) {
    //         dd("File not found at path: storage/app/public/" . $filePath);
    //     }

    //     return Storage::disk('public')->download($filePath);
    // }

    public function hlm_edit_about()
    {
        // Ambil data siswa berdasarkan session
        $siswa = Siswa::find(session('userActive')->ID_SISWA);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        // Kirim data siswa ke view
        return view('siswa_pages.hlm_edit_about', [
            'siswa' => $siswa
        ]);
    }

    // Method untuk menyimpan perubahan biodata
    public function update_biodata(Request $request)
    {
        // Ambil data siswa berdasarkan session
        $siswa = Siswa::find(session('userActive')->ID_SISWA);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
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
        $siswa->NAMA_SISWA = $validatedData['nama'];
        $siswa->EMAIL_SISWA = $validatedData['email'];
        $siswa->ALAMAT_SISWA = $validatedData['alamat'];
        $siswa->NO_TELPON_SISWA = $validatedData['telepon'];

        // Update password jika ada perubahan
        if ($request->has('password') && !empty($validatedData['password'])) {
            // $siswa->PASSWORD_SISWA = $validatedData['password'];
            $siswa->PASSWORD_SISWA = Hash::make($validatedData['password']);  // Encrypt password
        }

        $siswa->save();

        return redirect('/siswa/hlm_about')->with('success', 'Biodata berhasil diperbarui');
    }
    public function hlm_jadwal()
    {
        $siswa = Siswa::find(session('userActive')->ID_SISWA);

        // Ambil kelas terakhir yang di-enroll siswa (urut berdasarkan ID_KELAS terbesar)
        $lastEnrollment = DB::table('ENROLLMENT_KELAS')
            ->where('ID_SISWA', $siswa->ID_SISWA)
            ->orderByDesc('ID_KELAS') // Jika ada kolom timestamp gunakan itu
            ->first();

        if (!$lastEnrollment) {
            return response()->json(['message' => 'Kelas siswa tidak ditemukan.'], 404);
        }

        $idKelasTerakhir = $lastEnrollment->ID_KELAS;

        // Ambil jadwal mata pelajaran hanya dari kelas terakhir tersebut
        $jadwal = DB::table('MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('MATA_PELAJARAN.ID_KELAS', $idKelasTerakhir)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'MATA_PELAJARAN.HARI_PELAJARAN', 'MATA_PELAJARAN.JAM_PELAJARAN')
            ->get();

        // Mengelompokkan jadwal berdasarkan hari dan jam
        $jadwalByDay = [];
        foreach ($jadwal as $item) {
            $jadwalByDay[$item->HARI_PELAJARAN][$item->JAM_PELAJARAN] = $item->NAMA_PELAJARAN;
        }

        return view('siswa_pages.hlm_jadwal', ["jadwal" => $jadwalByDay]);
    }
    public function hlm_kelas()
    {
        // Ambil data siswa berdasarkan session
        $siswa = Siswa::find(session('userActive')->ID_SISWA);

        // Ambil kelas terakhir yang di-enroll siswa, urut berdasarkan ID_KELAS terbesar (atau pakai timestamp jika ada)
        $lastEnrollment = DB::table('ENROLLMENT_KELAS')
            ->where('ID_SISWA', $siswa->ID_SISWA)
            ->orderByDesc('ID_KELAS') // Ganti dengan kolom waktu enroll jika ada
            ->first();

        if (!$lastEnrollment) {
            return response()->json(['message' => 'Kelas siswa tidak ditemukan.'], 404);
        }

        $idKelasTerakhir = $lastEnrollment->ID_KELAS;

        // Ambil informasi kelas dan semester berdasarkan kelas terakhir
        $kelasInfo = DB::table('DETAIL_KELAS')
            ->join('KELAS', 'DETAIL_KELAS.ID_DETAIL_KELAS', '=', 'KELAS.ID_DETAIL_KELAS')
            ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
            ->where('KELAS.ID_KELAS', $idKelasTerakhir)
            ->select('DETAIL_KELAS.NAMA_KELAS', 'PERIODE.PERIODE')
            ->first();

        // Ambil mata pelajaran dan guru yang terkait dengan kelas terakhir tersebut
        $mataPelajaran = DB::table('MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('GURU', 'MATA_PELAJARAN.ID_GURU', '=', 'GURU.ID_GURU')
            ->where('MATA_PELAJARAN.ID_KELAS', $idKelasTerakhir)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'GURU.NAMA_GURU', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->get();

        // Kirim data ke view
        return view('siswa_pages.hlm_kelas', [
            'matapelajaran' => $mataPelajaran,
            'kelas' => $kelasInfo
        ]);
    }
    public function hlm_laporan_tugas(Request $request)
    {
        $siswa = Siswa::find(session('userActive')->ID_SISWA);
        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        // Ambil daftar periode (semester) untuk dropdown, urut dari terbaru
        $daftarPeriode = DB::table('PERIODE')->orderByDesc('ID_PERIODE')->get();

        // Ambil periode dari query string, default ke periode terbaru jika kosong
        $periodeId = $request->query('periode');
        if (!$periodeId) {
            $periodeId = $daftarPeriode->first()->ID_PERIODE ?? null;
        }

        // Tugas yang sudah dikumpulkan siswa di periode terpilih
        $tugasSudahDikirim = DB::table('SUBMISSION_TUGAS')
            ->join('TUGAS', 'SUBMISSION_TUGAS.ID_TUGAS', '=', 'TUGAS.ID_TUGAS')
            ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->where('SUBMISSION_TUGAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->where('KELAS.ID_PERIODE', '=', $periodeId)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'TUGAS.NAMA_TUGAS', 'SUBMISSION_TUGAS.NILAI_TUGAS', 'SUBMISSION_TUGAS.TANGGAL_SUBMISSION')
            ->get();

        // Tugas yang belum dikumpulkan siswa di periode terpilih
        $tugasBelumDikirim = DB::table('TUGAS')
            ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('ENROLLMENT_KELAS', 'KELAS.ID_KELAS', '=', 'ENROLLMENT_KELAS.ID_KELAS')
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->where('KELAS.ID_PERIODE', '=', $periodeId)
            ->whereNotIn('TUGAS.ID_TUGAS', function ($query) use ($siswa) {
                $query->select('ID_TUGAS')
                    ->from('SUBMISSION_TUGAS')
                    ->where('ID_SISWA', '=', $siswa->ID_SISWA);
            })
            ->select('PELAJARAN.NAMA_PELAJARAN', 'TUGAS.NAMA_TUGAS', 'TUGAS.ID_TUGAS')
            ->get();

        // Rata-rata nilai per mata pelajaran periode terpilih
        $rataNilai = DB::table('SUBMISSION_TUGAS')
            ->join('TUGAS', 'SUBMISSION_TUGAS.ID_TUGAS', '=', 'TUGAS.ID_TUGAS')
            ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->where('SUBMISSION_TUGAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->where('KELAS.ID_PERIODE', '=', $periodeId)
            ->select('PELAJARAN.NAMA_PELAJARAN', DB::raw('AVG(SUBMISSION_TUGAS.NILAI_TUGAS) as rata_nilai'))
            ->groupBy('PELAJARAN.NAMA_PELAJARAN')
            ->get();

        return view('siswa_pages.hlm_laporan_tugas', [
            'tugasSudahDikirim' => $tugasSudahDikirim,
            'tugasBelumDikirim' => $tugasBelumDikirim,
            'rataNilai' => $rataNilai,
            'daftarPeriode' => $daftarPeriode,
            'selectedPeriode' => $periodeId,
        ]);
    }
    public function hlm_laporan_ujian(Request $request)
    {
        $siswa = Siswa::find(session('userActive')->ID_SISWA);
        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        // Ambil daftar periode untuk dropdown
        $daftarPeriode = DB::table('PERIODE')->orderByDesc('ID_PERIODE')->get();

        // Ambil periode dari query string, default ke periode terbaru
        $periodeId = $request->query('periode');
        if (!$periodeId) {
            $periodeId = $daftarPeriode->first()->ID_PERIODE ?? null;
        }

        // Ambil data nilai ujian siswa di periode terpilih
        $ujian = DB::table('NILAI_KELAS')
            ->join('MATA_PELAJARAN', 'NILAI_KELAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('GURU', 'MATA_PELAJARAN.ID_GURU', '=', 'GURU.ID_GURU')
            ->where('NILAI_KELAS.ID_SISWA', $siswa->ID_SISWA)
            ->where('KELAS.ID_PERIODE', $periodeId)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'NILAI_KELAS.NILAI_UTS', 'NILAI_KELAS.NILAI_UAS', 'GURU.NAMA_GURU')
            ->get();

        // Hitung rata-rata nilai ujian per mata pelajaran
        $rataNilai = DB::table('NILAI_KELAS')
            ->join('MATA_PELAJARAN', 'NILAI_KELAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->where('NILAI_KELAS.ID_SISWA', $siswa->ID_SISWA)
            ->where('KELAS.ID_PERIODE', $periodeId)
            ->select('PELAJARAN.NAMA_PELAJARAN', DB::raw('AVG((NILAI_KELAS.NILAI_UTS + NILAI_KELAS.NILAI_UAS)/2) as rata_nilai'))
            ->groupBy('PELAJARAN.NAMA_PELAJARAN')
            ->get();

        return view('siswa_pages.hlm_laporan_ujian', [
            'ujian' => $ujian,
            'rataNilai' => $rataNilai,
            'daftarPeriode' => $daftarPeriode,
            'selectedPeriode' => $periodeId,
        ]);
    }



public function hlm_laporan_nilai(Request $request)
{
    $siswa = Siswa::find(session('userActive')->ID_SISWA);
    if (!$siswa) {
        return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
    }

    // Ambil daftar periode (semester) untuk dropdown, urut dari terbaru
    $daftarPeriode = DB::table('PERIODE')->orderByDesc('ID_PERIODE')->get();

    // Ambil periode dari query string, default ke periode terbaru jika kosong
    $periodeId = $request->query('periode');
    if (!$periodeId) {
        $periodeId = $daftarPeriode->first()->ID_PERIODE ?? null;
    }

    // Validasi periode yang dipilih ada dalam daftar periode
    $validPeriode = $daftarPeriode->where('ID_PERIODE', $periodeId)->first();
    if (!$validPeriode && $daftarPeriode->count() > 0) {
        $periodeId = $daftarPeriode->first()->ID_PERIODE;
        $validPeriode = $daftarPeriode->first();
    }

    // Ambil data mata pelajaran dan nilai siswa untuk periode terpilih
    $nilaiSiswa = DB::table('MATA_PELAJARAN')
        ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
        ->join('ENROLLMENT_KELAS', 'KELAS.ID_KELAS', '=', 'ENROLLMENT_KELAS.ID_KELAS')
        ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
        ->join('GURU', 'MATA_PELAJARAN.ID_GURU', '=', 'GURU.ID_GURU')
        ->join('DETAIL_KELAS', 'KELAS.ID_DETAIL_KELAS', '=', 'DETAIL_KELAS.ID_DETAIL_KELAS')
        ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
        ->leftJoin('NILAI_KELAS', function($join) use ($siswa) {
            $join->on('MATA_PELAJARAN.ID_MATA_PELAJARAN', '=', 'NILAI_KELAS.ID_MATA_PELAJARAN')
                 ->where('NILAI_KELAS.ID_SISWA', '=', $siswa->ID_SISWA);
        })
        ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
        ->where('KELAS.ID_PERIODE', '=', $periodeId)
        ->select(
            'MATA_PELAJARAN.ID_MATA_PELAJARAN',
            'MATA_PELAJARAN.JAM_PELAJARAN',
            'MATA_PELAJARAN.HARI_PELAJARAN',
            'PELAJARAN.NAMA_PELAJARAN',
            'GURU.NAMA_GURU',
            'GURU.ID_GURU',
            'DETAIL_KELAS.NAMA_KELAS',
            'PERIODE.PERIODE',
            'NILAI_KELAS.ID_NILAI',
            'NILAI_KELAS.NILAI_UTS',
            'NILAI_KELAS.NILAI_UAS',
            'NILAI_KELAS.NILAI_TUGAS',
            'NILAI_KELAS.NILAI_AKHIR'
        )
        ->get();

    // Ambil data wali kelas dari kelas yang diikuti siswa pada periode terpilih
    $waliKelas = DB::table('ENROLLMENT_KELAS')
        ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
        ->join('GURU as WALI_GURU', 'KELAS.ID_GURU', '=', 'WALI_GURU.ID_GURU')
        ->join('DETAIL_KELAS', 'KELAS.ID_DETAIL_KELAS', '=', 'DETAIL_KELAS.ID_DETAIL_KELAS')
        ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
        ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
        ->where('KELAS.ID_PERIODE', '=', $periodeId)
        ->select(
            'WALI_GURU.ID_GURU as ID_WALI_KELAS',
            'WALI_GURU.NAMA_GURU as NAMA_WALI_KELAS',
            'WALI_GURU.EMAIL_GURU as EMAIL_WALI_KELAS',
            'DETAIL_KELAS.NAMA_KELAS',
            'DETAIL_KELAS.RUANGAN_KELAS',
            'PERIODE.PERIODE'
        )
        ->first(); // Ambil satu record saja karena biasanya siswa hanya di satu kelas per periode

    // Hitung rata-rata nilai per periode (hanya untuk mata pelajaran yang sudah ada nilai)
    $nilaiYangAda = $nilaiSiswa->whereNotNull('NILAI_AKHIR');
    $rataRataNilai = $nilaiYangAda->count() > 0 ? $nilaiYangAda->avg('NILAI_AKHIR') : 0;

    // Hitung total mata pelajaran yang diambil
    $totalMataPelajaran = $nilaiSiswa->count();

    // Hitung mata pelajaran yang sudah ada nilai
    $mataPelajaranDenganNilai = $nilaiYangAda->count();

    // Status kelulusan berdasarkan nilai rata-rata
    $statusKelulusan = $rataRataNilai >= 70 ? 'LULUS' : 'TIDAK LULUS';
    if ($mataPelajaranDenganNilai - $totalMataPelajaran != 0 || $mataPelajaranDenganNilai == 0) {
        $statusKelulusan = "-";
    }

    // Rangking siswa dalam kelas (opsional)
    $rangkingSiswa = DB::table('NILAI_KELAS')
        ->join('MATA_PELAJARAN', 'NILAI_KELAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
        ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
        ->join('ENROLLMENT_KELAS', 'KELAS.ID_KELAS', '=', 'ENROLLMENT_KELAS.ID_KELAS')
        ->join('SISWA', 'NILAI_KELAS.ID_SISWA', '=', 'SISWA.ID_SISWA')
        ->where('KELAS.ID_PERIODE', '=', $periodeId)
        ->whereIn('KELAS.ID_KELAS', function($query) use ($siswa, $periodeId) {
            $query->select('KELAS.ID_KELAS')
                ->from('ENROLLMENT_KELAS')
                ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
                ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
                ->where('KELAS.ID_PERIODE', '=', $periodeId);
        })
        ->select('SISWA.NAMA_SISWA', DB::raw('AVG(NILAI_KELAS.NILAI_AKHIR) as rata_nilai'))
        ->groupBy('SISWA.ID_SISWA', 'SISWA.NAMA_SISWA')
        ->orderByDesc('rata_nilai')
        ->get();

    // Data tambahan untuk informasi periode yang dipilih
    $selectedPeriodeInfo = $validPeriode;

    return view('siswa_pages.hlm_report_siswa', [
        'nilaiSiswa' => $nilaiSiswa,
        'rataRataNilai' => $rataRataNilai,
        'totalMataPelajaran' => $totalMataPelajaran,
        'mataPelajaranDenganNilai' => $mataPelajaranDenganNilai,
        'statusKelulusan' => $statusKelulusan,
        'rangkingSiswa' => $rangkingSiswa,
        'daftarPeriode' => $daftarPeriode,
        'selectedPeriode' => $periodeId,
        'selectedPeriodeInfo' => $selectedPeriodeInfo,
        'waliKelas' => $waliKelas, // Data wali kelas ditambahkan
        'siswa' => $siswa
    ]);
}

public function liburNasional()
{
    // Bisa ditambahkan validasi siswa jika diperlukan
    $siswa = Siswa::find(session('userActive')->ID_SISWA);
    if (!$siswa) {
        return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
    }

    return view('siswa_pages.libur_nasional');
}

}
