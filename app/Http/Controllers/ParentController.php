<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Siswa;
use App\Models\Pengumuman;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        $user = session('userActive');
        if (! $user || ($user->ROLE ?? null) !== 'Parent') {
            abort(403, 'Hanya orang tua yang dapat mengakses halaman ini');
        }

        $siswa = Siswa::find($user->ID_SISWA ?? null);
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

    public function fees(Request $request)
    {
        $user = session('userActive');
        if (! $user || ($user->ROLE ?? null) !== 'Parent') {
            abort(403, 'Hanya orang tua yang dapat mengakses tagihan');
        }

        $siswa = Siswa::find($user->ID_SISWA ?? null);
        if (! $siswa) {
            abort(403, 'Siswa tidak ditemukan');
        }

        $fees = StudentFee::with(['component', 'periode', 'payments' => function ($q) {
            $q->orderByDesc('PAID_AT');
        }])
            ->where('ID_SISWA', $siswa->ID_SISWA)
            ->orderByDesc('created_at')
            ->get();

        $clientKey = config('services.midtrans.client_key');
        $isProduction = (bool) config('services.midtrans.is_production');

        return view('orangtua_pages.fees', [
            'siswa' => $siswa,
            'fees' => $fees,
            'clientKey' => $clientKey,
            'isProduction' => $isProduction,
        ]);
    }

    public function payFee(Request $request, StudentFee $fee)
    {
        $user = session('userActive');
        if (! $user || ($user->ROLE ?? null) !== 'Parent') {
            return response()->json(['message' => 'Hanya orang tua yang dapat membayar tagihan'], 403);
        }

        $siswa = Siswa::find($user->ID_SISWA ?? null);
        if (! $siswa || $fee->ID_SISWA !== $siswa->ID_SISWA) {
            return response()->json(['message' => 'Tagihan tidak ditemukan untuk siswa ini'], 404);
        }

        if ($fee->STATUS === 'Paid') {
            return response()->json(['message' => 'Tagihan sudah lunas'], 400);
        }

        $serverKey = config('services.midtrans.server_key');
        $clientKey = config('services.midtrans.client_key');
        if (! $serverKey || ! $clientKey) {
            return response()->json(['message' => 'Konfigurasi Midtrans belum lengkap'], 500);
        }

        $baseUrl = config('services.midtrans.is_production') ? 'https://app.midtrans.com' : 'https://app.sandbox.midtrans.com';
        $orderId = $fee->INVOICE_CODE;
        $grossAmount = (int) round($fee->AMOUNT);

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $siswa->NAMA_SISWA,
                'email' => $siswa->EMAIL_SISWA,
                'phone' => $siswa->NO_TELPON_SISWA,
            ],
            'item_details' => [
                [
                    'id' => $fee->ID_COMPONENT,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => $fee->component->NAME ?? 'Tagihan SPP',
                ],
            ],
            'callbacks' => [
                'finish' => route('orangtua.fees'),
            ],
        ];

        $response = Http::withBasicAuth($serverKey, '')
            ->acceptJson()
            ->post($baseUrl . '/snap/v1/transactions', $payload);

        if (! $response->successful()) {
            Log::error('Gagal membuat transaksi Midtrans', [
                'fee_id' => $fee->ID_STUDENT_FEE,
                'response' => $response->json(),
            ]);
            return response()->json(['message' => 'Gagal membuat transaksi Midtrans'], 502);
        }

        $data = $response->json();

        $fee->MIDTRANS_ORDER_ID = $orderId;
        $fee->save();

        return response()->json([
            'token' => $data['token'] ?? null,
            'redirect_url' => $data['redirect_url'] ?? null,
            'snap_base_url' => $baseUrl,
            'client_key' => $clientKey,
        ]);
    }
}
