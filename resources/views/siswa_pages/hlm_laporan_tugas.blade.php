@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
    <h4 class="mb-3">Laporan Nilai Tugas</h4>
    <a href="{{ route('siswa.report.siswa', ['periode' => $selectedPeriode]) }}" class="btn btn-primary mb-3">Report</a>

    <form method="GET" action="{{ route('siswa.laporan_tugas') }}" class="mb-4 average-card-custom">
        <label for="periodeSelect" class="form-label mb-2">Pilih Periode</label>
        <select name="periode" id="periodeSelect" class="form-select" onchange="this.form.submit()">
            @foreach($daftarPeriode as $periode)
                <option value="{{ $periode->ID_PERIODE }}" {{ $selectedPeriode == $periode->ID_PERIODE ? 'selected' : '' }}>
                    {{ $periode->PERIODE }}
                </option>
            @endforeach
        </select>
    </form>

    <div class="average-card-custom mb-4">
        <h5 class="mb-3">Sudah Dikumpulkan</h5>
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0 no-data-table">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugasSudahDikirim as $t)
                        <tr>
                            <td>{{ $t->NAMA_PELAJARAN }} - {{ $t->NAMA_TUGAS }}</td>
                            <td>{{ $t->NILAI_TUGAS }}</td>
                            <td><span class="task-status status-selesai">Sudah Dikumpulkan</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tasks that have not been submitted (Cards) -->
    <div class="average-card-custom mb-4">
        <h5 class="mb-3">Belum Dikumpulkan</h5>
        <div class="row">
            @php $now = now(); @endphp
            @foreach ($tugasBelumDikirim as $t)
                @php $isOverdue = isset($t->DEADLINE_TUGAS) && $now->gt($t->DEADLINE_TUGAS); @endphp
                @if($isOverdue)
                    @continue
                @endif
                <div class="col-md-4 mb-3">
                    <a href="{{ url('/siswa/hlm_detail_tugas/' . base64_encode($t->ID_TUGAS)) }}" class="text-decoration-none" style="color: var(--text);">
                        <div class="task-card h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $t->NAMA_PELAJARAN }} - {{ $t->NAMA_TUGAS }}</h6>
                                <p class="mb-1 small text-muted">Deadline: {{ $t->DEADLINE_TUGAS ? \Carbon\Carbon::parse($t->DEADLINE_TUGAS)->format('d M Y H:i') : '-' }}</p>
                                <p class="mb-1"><strong>Nilai:</strong> -</p>
                            </div>
                            <span class="task-status status-belum">Belum Dikumpulkan</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Rata-rata Nilai -->
    <div class="average-card-custom">
        <h5 class="average-card-title">Rata-Rata Nilai per Mata Pelajaran</h5>
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0 no-data-table">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rataNilai as $rn)
                        <tr>
                            <td><strong>{{ $rn->NAMA_PELAJARAN }}</strong></td>
                            <td>{{ number_format($rn->rata_nilai, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
