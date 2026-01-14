@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-3 text-light">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="average-card-title mb-0">Tagihan Anak</h3>
        <span class="text-muted small">Anak: {{ $siswa->NAMA_SISWA }} ({{ $siswa->ID_SISWA }})</span>
    </div>

    @if(empty($clientKey))
        <div class="alert alert-warning">Konfigurasi Midtrans belum lengkap. Set nilai MIDTRANS_CLIENT_KEY dan MIDTRANS_SERVER_KEY di .env agar pembayaran dapat digunakan.</div>
    @endif

    <div class="average-card-custom p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Daftar Tagihan</h5>
            <span class="text-muted small">Hanya orang tua yang dapat melihat dan membayar</span>
        </div>
        <div class="table-responsive-custom">
            <table class="average-table table-bordered align-middle mb-0">
                <thead class="table-header-custom">
                    <tr>
                        <th>Invoice</th>
                        <th>Komponen</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Pembayaran Terakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fees as $fee)
                        @php($latestPayment = $fee->payments->first())
                        <tr>
                            <td>{{ $fee->INVOICE_CODE }}</td>
                            <td>{{ $fee->component->NAME ?? '-' }}</td>
                            <td>{{ $fee->periode->PERIODE ?? '-' }}</td>
                            <td>Rp {{ number_format($fee->AMOUNT, 0, ',', '.') }}</td>
                            <td>{{ $fee->DUE_DATE ?? '-' }}</td>
                            <td><span class="badge bg-{{ $fee->STATUS === 'Paid' ? 'success' : ($fee->STATUS === 'Overdue' ? 'danger' : 'secondary') }}">{{ $fee->STATUS }}</span></td>
                            <td>
                                @if($latestPayment)
                                    <div class="small text-muted">{{ $latestPayment->METHOD ?? 'Online' }} | {{ optional($latestPayment->PAID_AT)->format('d M Y H:i') }}</div>
                                    <div class="small">Status: {{ $latestPayment->STATUS }}</div>
                                @else
                                    <span class="text-muted small">Belum ada pembayaran</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-pay-fee="{{ $fee->ID_STUDENT_FEE }}" @if($fee->STATUS === 'Paid' || empty($clientKey)) disabled @endif>
                                    {{ $fee->STATUS === 'Paid' ? 'Lunas' : 'Bayar' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada tagihan untuk anak ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@if(!empty($clientKey))
    @push('scripts')
        <script src="{{ $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const basePayUrl = '{{ url('/orangtua/tagihan') }}';
                const buttons = document.querySelectorAll('[data-pay-fee]');

                buttons.forEach(btn => {
                    btn.addEventListener('click', async () => {
                        const feeId = btn.dataset.payFee;
                        btn.disabled = true;
                        const originalText = btn.textContent;
                        btn.textContent = 'Memproses...';

                        try {
                            const resp = await fetch(`${basePayUrl}/${feeId}/pay`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            });

                            const data = await resp.json();
                            if (!resp.ok || !data.token) {
                                alert(data.message || 'Gagal membuat transaksi');
                                btn.disabled = false;
                                btn.textContent = originalText;
                                return;
                            }

                            // Tampilkan Snap pop-up
                            snap.pay(data.token, {
                                onSuccess: () => window.location.reload(),
                                onPending: () => window.location.reload(),
                                onClose: () => {
                                    btn.disabled = false;
                                    btn.textContent = originalText;
                                },
                                onError: () => {
                                    alert('Terjadi kesalahan pada pembayaran');
                                    btn.disabled = false;
                                    btn.textContent = originalText;
                                },
                            });
                        } catch (error) {
                            alert('Gagal terhubung ke server');
                            btn.disabled = false;
                            btn.textContent = originalText;
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
