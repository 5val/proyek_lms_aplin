<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Siswa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Siswa::find(session('userActive')->ID_SISWA ?? null);
        if (! $siswa) {
            abort(403, 'Siswa tidak ditemukan');
        }

        // Ambil kelas terakhir yang di-enroll siswa
        $lastEnrollment = DB::table('ENROLLMENT_KELAS')
            ->where('ID_SISWA', $siswa->ID_SISWA)
            ->orderByDesc('ID_KELAS')
            ->first();

        $kelasInfo = null;
        $jadwal = collect();
        $tugas = collect();
        $materi = collect();

        if ($lastEnrollment) {
            $kelasInfo = DB::table('DETAIL_KELAS')
                ->join('KELAS', 'DETAIL_KELAS.ID_DETAIL_KELAS', '=', 'KELAS.ID_DETAIL_KELAS')
                ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
                ->where('KELAS.ID_KELAS', $lastEnrollment->ID_KELAS)
                ->select('DETAIL_KELAS.NAMA_KELAS', 'DETAIL_KELAS.RUANGAN_KELAS', 'PERIODE.PERIODE', 'KELAS.ID_KELAS')
                ->first();

            $jadwal = DB::table('MATA_PELAJARAN')
                ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
                ->where('MATA_PELAJARAN.ID_KELAS', $lastEnrollment->ID_KELAS)
                ->select('PELAJARAN.NAMA_PELAJARAN', 'MATA_PELAJARAN.HARI_PELAJARAN', 'MATA_PELAJARAN.JAM_PELAJARAN')
                ->orderBy('MATA_PELAJARAN.HARI_PELAJARAN')
                ->orderBy('MATA_PELAJARAN.JAM_PELAJARAN')
                ->get();

            $tugas = DB::table('TUGAS')
                ->join('MATA_PELAJARAN', 'TUGAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
                ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
                ->where('MATA_PELAJARAN.ID_KELAS', $lastEnrollment->ID_KELAS)
                ->where('TUGAS.DEADLINE_TUGAS', '>', now())
                ->select('TUGAS.NAMA_TUGAS', 'TUGAS.DEADLINE_TUGAS', 'PELAJARAN.NAMA_PELAJARAN')
                ->orderBy('TUGAS.DEADLINE_TUGAS')
                ->limit(5)
                ->get();

            $materi = DB::table('MATERI')
                ->join('MATA_PELAJARAN', 'MATERI.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
                ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
                ->where('MATA_PELAJARAN.ID_KELAS', $lastEnrollment->ID_KELAS)
                ->select('MATERI.NAMA_MATERI', 'PELAJARAN.NAMA_PELAJARAN')
                ->orderByDesc('MATERI.ID_MATERI')
                ->limit(5)
                ->get();
        }

        $attendanceStats = Attendance::select('STATUS', DB::raw('count(*) as total'))
            ->where('ID_SISWA', $siswa->ID_SISWA)
            ->groupBy('STATUS')
            ->pluck('total', 'STATUS');

        $pengumuman = Pengumuman::orderByDesc('ID')->limit(5)->get();

        return view('orangtua_pages.home', [
            'siswa' => $siswa,
            'kelasInfo' => $kelasInfo,
            'jadwal' => $jadwal,
            'tugas' => $tugas,
            'materi' => $materi,
            'attendanceStats' => $attendanceStats,
            'pengumuman' => $pengumuman,
        ]);
    }
}
