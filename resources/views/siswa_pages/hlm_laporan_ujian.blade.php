@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
    <h4 class="mb-3">Laporan Nilai Ujian</h4>
    <a href="{{ route('siswa.report.siswa', ['periode' => $selectedPeriode]) }}" class="btn btn-primary mb-3">Report</a>

    <form method="GET" action="{{ route('siswa.laporan_ujian') }}" class="mb-4 average-card-custom">
        <label for="periodeSelect" class="form-label mb-2">Pilih Periode</label>
        <select name="periode" id="periodeSelect" class="form-select" onchange="this.form.submit()">
            @foreach($daftarPeriode as $periode)
                <option value="{{ $periode->ID_PERIODE }}" {{ $selectedPeriode == $periode->ID_PERIODE ? 'selected' : '' }}>
                    {{ $periode->PERIODE }}
                </option>
            @endforeach
        </select>
    </form>

    @php $ujianByPelajaran = $ujian->groupBy('NAMA_PELAJARAN'); @endphp

    <div class="row g-3 mb-4">
        @forelse($ujianByPelajaran as $mapel => $items)
            @php $row = $items->first(); @endphp
            <div class="col-md-4">
                <div class="exam-card h-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="mb-0">{{ $mapel }}</h5>
                        <span class="badge bg-secondary">{{ $selectedPeriode }}</span>
                    </div>
                    <p class="text-muted small mb-3">Guru: {{ $row->NAMA_GURU ?? '-' }}</p>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Nilai UTS</span>
                        <strong>{{ $row->NILAI_UTS ?? '-' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Nilai UAS</span>
                        <strong>{{ $row->NILAI_UAS ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="average-card-custom text-muted">Belum ada nilai ujian untuk periode ini.</div>
            </div>
        @endforelse
    </div>

    <!-- Rata-rata Nilai Ujian -->
    <div class="average-card-custom">
        <h5 class="average-card-title">Rata-Rata Nilai Ujian per Mata Pelajaran</h5>
        <div class="table-responsive">
            <table id="tableRataUjian" class="table table-sm align-middle mb-0 no-data-table">
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rataNilai as $rn)
                        <tr>
                            <td><strong>{{ $rn->NAMA_PELAJARAN }}</strong></td>
                            <td>{{ number_format($rn->rata_nilai, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-muted">Belum ada data rata-rata.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('custom-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table = $('#tableRataUjian');
        if (table.length && $.fn.DataTable) {
            table.DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: true,
                order: [[0, 'asc']],
                language: { emptyTable: 'Belum ada data rata-rata.' }
            });
        }
    });
</script>
@endsection
