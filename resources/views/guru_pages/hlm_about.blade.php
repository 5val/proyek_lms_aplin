@extends('layouts.guru_app')

@section('guru_content')
<div class="content-box mt-3">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ $guru->FOTO_GURU ?? 'https://via.placeholder.com/110?text=Avatar' }}" alt="Avatar" class="rounded-circle border" width="110" height="110">
            <div>
                <h4 class="mb-1 fw-bold">{{ $guru->NAMA_GURU }}</h4>
                <div class="text-muted">{{ $guru->ID_GURU }}</div>
                <div class="small">Wali Kelas: {{ $wali_kelas->NAMA_KELAS ?? '-' }}</div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary" href="/guru/hlm_edit_about">Edit Biodata</a>
        </div>
    </div>

    @php
        $totalKelas = $periodeReports->sum('TOTAL_KELAS');
        $totalMapel = $periodeReports->sum('TOTAL_MAPEL');
        $totalTugas = $periodeReports->sum('TOTAL_TUGAS');
        $totalMateri = $periodeReports->sum('TOTAL_MATERI');
        $avgNilai = $periodeReports->avg('RATA_NILAI_AKHIR');
    @endphp

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="average-card-custom h-100">
                <h6 class="mb-3 fw-bold">Biodata</h6>
                <table class="table table-borderless no-data-table mb-0">
                    <tr><th class="text-muted">Email</th><td>{{ $guru->EMAIL_GURU ?? '-' }}</td></tr>
                    <tr><th class="text-muted">Alamat</th><td>{{ $guru->ALAMAT_GURU ?? '-' }}</td></tr>
                    <tr><th class="text-muted">No. Telepon</th><td>{{ $guru->NO_TELPON_GURU ?? '-' }}</td></tr>
                    <tr><th class="text-muted">Total Kelas</th><td>{{ $totalKelas }}</td></tr>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="average-card-custom h-100">
                <h6 class="mb-3 fw-bold">Kelas yang Diampu</h6>
                <ul class="list-group list-group-flush">
                    @forelse($kelasDiampu as $kelas)
                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                            <span>{{ $kelas->NAMA_KELAS }}</span>
                            <span class="badge bg-secondary">{{ $kelas->PERIODE }}</span>
                        </li>
                    @empty
                        <li class="list-group-item bg-transparent text-muted px-0">Belum ada kelas tercatat.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="average-card-custom h-100">
                <h6 class="mb-3 fw-bold">Ringkasan Aktivitas</h6>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between"><span class="text-muted">Mapel diampu</span><strong>{{ $totalMapel }}</strong></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Tugas dibuat</span><strong>{{ $totalTugas }}</strong></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Materi dibagikan</span><strong>{{ $totalMateri }}</strong></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Rata nilai akhir siswa</span><strong>{{ $avgNilai ? number_format($avgNilai, 1) : '-' }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-lg-7">
            <div class="average-card-custom h-100">
                <h6 class="fw-bold mb-3">Laporan Per Periode</h6>
                @if($periodeReports->isEmpty())
                    <p class="text-muted mb-0">Belum ada data periode untuk guru ini.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0 no-data-table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th class="text-end">Kelas</th>
                                    <th class="text-end">Mapel</th>
                                    <th class="text-end">Tugas</th>
                                    <th class="text-end">Materi</th>
                                    <th class="text-end">Rata Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($periodeReports as $p)
                                    <tr>
                                        <td>{{ $p->PERIODE }}</td>
                                        <td class="text-end">{{ $p->TOTAL_KELAS }}</td>
                                        <td class="text-end">{{ $p->TOTAL_MAPEL }}</td>
                                        <td class="text-end">{{ $p->TOTAL_TUGAS }}</td>
                                        <td class="text-end">{{ $p->TOTAL_MATERI }}</td>
                                        <td class="text-end">{{ $p->RATA_NILAI_AKHIR ? number_format($p->RATA_NILAI_AKHIR, 1) : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-5">
            <div class="average-card-custom h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">Tren Nilai Akhir</h6>
                    <small class="text-muted">Rata-rata per periode</small>
                </div>
                <div class="chart-container" style="height:260px;">
                    <canvas id="chartGuruPeriode"></canvas>
                </div>
                @if($chartPeriodeLabels->isEmpty())
                    <p class="mt-3 text-muted">Belum ada nilai yang tercatat.</p>
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
        const ctx = document.getElementById('chartGuruPeriode');
        if (!ctx) return;

        const labels = @json($chartPeriodeLabels);
        const data = @json($chartPeriodeValues);

        if (!labels.length) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Rata nilai akhir',
                    data,
                    backgroundColor: 'rgba(249,115,22,0.4)',
                    borderColor: 'rgba(249,115,22,1)',
                    borderWidth: 1.5,
                    borderRadius: 6
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
