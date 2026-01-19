@extends('layouts.siswa_app')

@section('siswa_content')
<div class="content-box mt-3">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ $siswa->FOTO_SISWA ?? 'https://via.placeholder.com/120?text=Avatar' }}" alt="Avatar" class="rounded-circle border" width="110" height="110">
            <div>
                <h4 class="mb-1 fw-bold">{{ $siswa->NAMA_SISWA }}</h4>
                <div class="text-muted">{{ $siswa->ID_SISWA }}</div>
                <div class="small">{{ $kelasInfo->NAMA_KELAS ?? '-' }} - {{ $kelasInfo->PERIODE ?? '-' }}</div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary" href="/siswa/hlm_edit_about">Edit Biodata / Foto</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="average-card-custom h-100">
                <h6 class="mb-3 fw-bold">Biodata</h6>
                <table class="table table-borderless no-data-table mb-0">
                    <tr><th class="text-muted">Email</th><td>{{ $siswa->EMAIL_SISWA ?? '-' }}</td></tr>
                    <tr><th class="text-muted">Alamat</th><td>{{ $siswa->ALAMAT_SISWA ?? '-' }}</td></tr>
                    <tr><th class="text-muted">No. Telepon</th><td>{{ $siswa->NO_TELPON_SISWA ?? '-' }}</td></tr>
                    <tr><th class="text-muted">Terakhir Kelas</th><td>{{ $kelasInfo->NAMA_KELAS ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="average-card-custom h-100">
                <h6 class="mb-3 fw-bold">Riwayat Kelas</h6>
                <ul class="list-group list-group-flush">
                    @forelse($kelasHistory as $k)
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                            <span>{{ $k->NAMA_KELAS }} <span class="text-muted">({{ $k->ID_KELAS }})</span></span>
                            <span class="badge bg-secondary">{{ $k->PERIODE }}</span>
                        </li>
                    @empty
                        <li class="list-group-item bg-transparent text-muted px-0">Belum ada data kelas.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="average-card-custom h-100">
                <h6 class="mb-3 fw-bold">Rekap Aktivitas</h6>
                @php
                    $totalHadir = $attendanceStats?->TOTAL_HADIR ?? 0;
                    $totalKehadiran = $attendanceStats?->TOTAL_KEHADIRAN ?? 0;
                    $persenHadir = $totalKehadiran > 0 ? round(($totalHadir / $totalKehadiran) * 100, 1) : 0;
                @endphp
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between"><span class="text-muted">Tugas dikumpulkan</span><strong>{{ $tugasStats?->TOTAL_SUBMISSION ?? 0 }}</strong></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Sudah dinilai</span><strong>{{ $tugasStats?->SUDAH_DINILAI ?? 0 }}</strong></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Rata nilai tugas</span><strong>{{ $tugasStats?->RATA_TUGAS ? number_format($tugasStats->RATA_TUGAS, 1) : '-' }}</strong></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Persentase hadir</span><strong>{{ $persenHadir }}%</strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-lg-7">
            <div class="average-card-custom h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">Performa Nilai (Periode ke Periode)</h6>
                    <small class="text-muted">Nilai akhir rata-rata</small>
                </div>
                <div class="chart-container" style="height:260px;">
                    <canvas id="chartNilaiKelas"></canvas>
                </div>
                @if($nilaiPerPeriode->isEmpty())
                    <p class="mt-3 text-muted">Belum ada nilai akhir yang tercatat.</p>
                @endif
            </div>
        </div>

        <div class="col-lg-5">
            <div class="average-card-custom h-100">
                <h6 class="fw-bold mb-3">Rekap Nilai per Kelas</h6>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0 no-data-table">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Periode</th>
                                <th class="text-end">Rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nilaiRingkasan as $n)
                                <tr>
                                    <td>{{ $n->NAMA_KELAS }}</td>
                                    <td>{{ $n->PERIODE }}</td>
                                    <td class="text-end">{{ number_format($n->RATA_AKHIR, 1) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-muted">Belum ada nilai akhir.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-12">
            <div class="average-card-custom">
                <h6 class="fw-bold mb-3">Rekap Kehadiran per Periode</h6>
                @php $attendanceGrouped = $attendanceBreakdown->groupBy('PERIODE'); @endphp
                @if($attendanceGrouped->isEmpty())
                    <p class="text-muted mb-0">Belum ada data kehadiran.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0 no-data-table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceGrouped as $periode => $items)
                                    @foreach($items as $index => $item)
                                        <tr>
                                            @if($index === 0)
                                                <td rowspan="{{ $items->count() }}">{{ $periode }}</td>
                                            @endif
                                            <td>{{ $item->STATUS ?? '-' }}</td>
                                            <td class="text-end">{{ $item->TOTAL }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartNilaiKelas');
        if (!ctx) return;

        const labels = @json($nilaiLabels);
        const data = @json($nilaiValues);

        if (!labels.length) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Rata nilai akhir',
                    data,
                    borderColor: 'rgba(34,211,238,1)',
                    backgroundColor: 'rgba(34,211,238,0.15)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.25,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 100,
                        ticks: { stepSize: 10, color: '#e5e7eb' }
                    },
                    x: { ticks: { color: '#e5e7eb' } }
                },
                plugins: {
                    legend: { labels: { color: '#e5e7eb' } },
                    tooltip: { callbacks: { label: ctx => `${ctx.parsed.y}` } }
                }
            }
        });
    });
</script>
@endsection
