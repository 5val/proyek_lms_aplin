<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\EnrollmentKelas;
use App\Models\SubmissionTugas;
use Illuminate\Support\Facades\Storage;  

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
        $mataPelajaran = DB::table('ENROLLMENT_KELAS')
            ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('MATA_PELAJARAN', 'KELAS.ID_KELAS', '=', 'MATA_PELAJARAN.ID_KELAS')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->get();

        $tugas = DB::table('TUGAS')
            ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('ENROLLMENT_KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'ENROLLMENT_KELAS.ID_KELAS')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->where('TUGAS.DEADLINE_TUGAS', '>', now())  // Filter tugas yang deadline-nya lebih besar dari waktu saat ini
            ->select('TUGAS.NAMA_TUGAS', 'TUGAS.DEADLINE_TUGAS', 'TUGAS.ID_TUGAS', 'PELAJARAN.NAMA_PELAJARAN')  // Menambahkan ID_TUGAS di query
            ->get();

        $jadwal = DB::table('ENROLLMENT_KELAS')
            ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('MATA_PELAJARAN', 'KELAS.ID_KELAS', '=', 'MATA_PELAJARAN.ID_KELAS')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN') // Join dengan tabel PELAJARAN
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'MATA_PELAJARAN.HARI_PELAJARAN', 'MATA_PELAJARAN.JAM_PELAJARAN') // Ambil NAMA_PELAJARAN dari PELAJARAN
            ->get();

        // Mengelompokkan jadwal berdasarkan hari dan jam
        $jadwalByDay = [];
        foreach ($jadwal as $item) {
            $jadwalByDay[$item->HARI_PELAJARAN][$item->JAM_PELAJARAN] = $item->NAMA_PELAJARAN;
        }

        $idKelas = DB::table('ENROLLMENT_KELAS')
            ->where('ID_SISWA', '=', $siswa->ID_SISWA)
            ->value('ID_KELAS');  // Ambil ID_KELAS dari ENROLLMENT_KELAS

        // Cek apakah ID_KELAS ditemukan
        if (!$idKelas) {
            return response()->json(['message' => 'Kelas siswa tidak ditemukan.'], 404);
        }

        // Ambil informasi kelas dan semester berdasarkan ID_KELAS
        $kelasInfo = DB::table('DETAIL_KELAS')
            ->join('KELAS', 'DETAIL_KELAS.ID_DETAIL_KELAS', '=', 'KELAS.ID_DETAIL_KELAS')
            ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
            ->where('KELAS.ID_KELAS', '=', $idKelas)
            ->select('DETAIL_KELAS.NAMA_KELAS', 'PERIODE.PERIODE')
            ->first();  // Ambil satu data kelas dan semester

        // Return data ke view
        return view('siswa_pages.home', [
            "pengumuman" => $pengumuman,
            "matapelajaran" => $mataPelajaran,
            "tugas" => $tugas,
            "jadwal"=> $jadwalByDay,
            "kelas" => $kelasInfo
        ]);
    }
    public function detail_pelajaran($id_mata_pelajaran)
    {
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
            $siswa->PASSWORD_SISWA = $validatedData['password'];  // Encrypt password
        }

        $siswa->save();

        return redirect('/siswa/hlm_about')->with('success', 'Biodata berhasil diperbarui');
    }
    public function hlm_jadwal()
    {
        $siswa = Siswa::find(session('userActive')->ID_SISWA);
        $jadwal = DB::table('ENROLLMENT_KELAS')
            ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('MATA_PELAJARAN', 'KELAS.ID_KELAS', '=', 'MATA_PELAJARAN.ID_KELAS')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN') // Join dengan tabel PELAJARAN
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'MATA_PELAJARAN.HARI_PELAJARAN', 'MATA_PELAJARAN.JAM_PELAJARAN') // Ambil NAMA_PELAJARAN dari PELAJARAN
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

        $idKelas = DB::table('ENROLLMENT_KELAS')
            ->where('ID_SISWA', '=', $siswa->ID_SISWA)
            ->value('ID_KELAS');  // Ambil ID_KELAS dari ENROLLMENT_KELAS

        // Cek apakah ID_KELAS ditemukan
        if (!$idKelas) {
            return response()->json(['message' => 'Kelas siswa tidak ditemukan.'], 404);
        }

        // Ambil informasi kelas dan semester berdasarkan ID_KELAS
        $kelasInfo = DB::table('DETAIL_KELAS')
            ->join('KELAS', 'DETAIL_KELAS.ID_DETAIL_KELAS', '=', 'KELAS.ID_DETAIL_KELAS')
            ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
            ->where('KELAS.ID_KELAS', '=', $idKelas)
            ->select('DETAIL_KELAS.NAMA_KELAS', 'PERIODE.PERIODE')
            ->first();  // Ambil satu data kelas dan semester

        // Ambil mata pelajaran berdasarkan kelas yang diikuti oleh siswa
        $mataPelajaran = DB::table('ENROLLMENT_KELAS')
            ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('MATA_PELAJARAN', 'KELAS.ID_KELAS', '=', 'MATA_PELAJARAN.ID_KELAS')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('GURU', 'MATA_PELAJARAN.ID_GURU', '=', 'GURU.ID_GURU')  // Join dengan tabel GURU untuk mengambil nama guru
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'GURU.NAMA_GURU', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')  // Ambil nama pelajaran dan nama guru
            ->get();

        // Kirim data mata pelajaran ke view
        return view('siswa_pages.hlm_kelas', ["matapelajaran" => $mataPelajaran, "kelas" => $kelasInfo]);
    }
    public function hlm_laporan_tugas()
    {
        // Ambil data siswa berdasarkan session
        $siswa = Siswa::find(session('userActive')->ID_SISWA);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        // Ambil tugas yang sudah dikumpulkan oleh siswa
        $tugasSudahDikirim = DB::table('SUBMISSION_TUGAS')
            ->join('TUGAS', 'SUBMISSION_TUGAS.ID_TUGAS', '=', 'TUGAS.ID_TUGAS')
            ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('GURU', 'MATA_PELAJARAN.ID_GURU', '=', 'GURU.ID_GURU')
            ->where('SUBMISSION_TUGAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'TUGAS.NAMA_TUGAS', 'SUBMISSION_TUGAS.NILAI_TUGAS', 'SUBMISSION_TUGAS.TANGGAL_SUBMISSION', 'SUBMISSION_TUGAS.NILAI_TUGAS', 'GURU.NAMA_GURU')
            ->get();

        // Ambil tugas yang belum dikumpulkan oleh siswa
        $tugasBelumDikirim = DB::table('TUGAS')
            ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('ENROLLMENT_KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'ENROLLMENT_KELAS.ID_KELAS') // Join dengan ENROLLMENT_KELAS untuk memastikan kelas yang diikuti siswa
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)  // Pastikan hanya tugas dari kelas yang diikuti siswa
            ->whereNotIn('TUGAS.ID_TUGAS', function($query) use ($siswa) {
                $query->select('ID_TUGAS')
                    ->from('SUBMISSION_TUGAS')
                    ->where('ID_SISWA', '=', $siswa->ID_SISWA);
            })
            ->select('PELAJARAN.NAMA_PELAJARAN', 'TUGAS.NAMA_TUGAS')
            ->get();

        // Menghitung rata-rata nilai per mata pelajaran
        $rataNilai = DB::table('SUBMISSION_TUGAS')
            ->join('TUGAS', 'SUBMISSION_TUGAS.ID_TUGAS', '=', 'TUGAS.ID_TUGAS')
            ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('SUBMISSION_TUGAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('PELAJARAN.NAMA_PELAJARAN', DB::raw('AVG(SUBMISSION_TUGAS.NILAI_TUGAS) as rata_nilai'))
            ->groupBy('PELAJARAN.NAMA_PELAJARAN')
            ->get();

        // Kirim data tugas dan rata-rata nilai ke view
        return view('siswa_pages.hlm_laporan_tugas', [
            'tugasSudahDikirim' => $tugasSudahDikirim,
            'tugasBelumDikirim' => $tugasBelumDikirim,
            'rataNilai' => $rataNilai
        ]);
    }
    public function hlm_laporan_ujian()
    {
        // Ambil data siswa berdasarkan session
        $siswa = Siswa::find(session('userActive')->ID_SISWA);

        if (!$siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        // Ambil data ujian yang sudah dikumpulkan oleh siswa (Nilai Ujian dan Feedback)
        $ujian = DB::table('NILAI_KELAS')
            ->join('MATA_PELAJARAN', 'NILAI_KELAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('GURU', 'MATA_PELAJARAN.ID_GURU', '=', 'GURU.ID_GURU')
            ->where('NILAI_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('PELAJARAN.NAMA_PELAJARAN', 'NILAI_KELAS.NILAI_UTS', 'NILAI_KELAS.NILAI_UAS', 'GURU.NAMA_GURU')
            ->get();

        // Ambil rata-rata nilai ujian per mata pelajaran
        $rataNilai = DB::table('NILAI_KELAS')
            ->join('MATA_PELAJARAN', 'NILAI_KELAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->where('NILAI_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->select('PELAJARAN.NAMA_PELAJARAN', DB::raw('AVG(NILAI_KELAS.NILAI_UAS + NILAI_KELAS.NILAI_UTS) / 2 as rata_nilai'))
            ->groupBy('PELAJARAN.NAMA_PELAJARAN')
            ->get();

        // Kirim data ujian dan rata-rata nilai ke view
        return view('siswa_pages.hlm_laporan_ujian', [
            'ujian' => $ujian,
            'rataNilai' => $rataNilai
        ]);
    }
}
