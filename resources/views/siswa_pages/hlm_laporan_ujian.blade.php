@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
    <h4 class="mb-3">Laporan Nilai Ujian</h4>
    <a href="{{ route('siswa.report.siswa', ['periode' => $selectedPeriode]) }}" class="btn btn-primary mb-3">Report</a>

    <!-- Dropdown Pilih Periode -->
    <form method="GET" action="{{ route('siswa.laporan_ujian') }}" class="mb-4">
        <label for="periodeSelect" class="form-label">Pilih Periode:</label>
        <select name="periode" id="periodeSelect" class="form-select" onchange="this.form.submit()">
            @foreach($daftarPeriode as $periode)
                <option value="{{ $periode->ID_PERIODE }}" {{ $selectedPeriode == $periode->ID_PERIODE ? 'selected' : '' }}>
                    {{ $periode->PERIODE }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- Card Ujian -->
    @foreach ($ujian as $u)
        <div class="exam-card">
            <h5>{{ $u->NAMA_PELAJARAN }} - Ujian Tengah Semester</h5>
            <p><strong>Nilai:</strong> {{ $u->NILAI_UTS }}</p>
            <p><strong>Guru:</strong> {{ $u->NAMA_GURU }}</p>
        </div>

        <div class="exam-card">
            <h5>{{ $u->NAMA_PELAJARAN }} - Ujian Akhir Semester</h5>
            <p><strong>Nilai:</strong> {{ $u->NILAI_UAS }}</p>
            <p><strong>Guru:</strong> {{ $u->NAMA_GURU }}</p>
        </div>
    @endforeach

    <!-- Rata-rata Nilai Ujian -->
    <div class="average-card-custom">
        <h5 class="average-card-title">Rata-Rata Nilai Ujian per Mata Pelajaran</h5>
        <table class="average-table table-bordered table-lg">
            <thead class="table-header-custom">
                <tr>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rataNilai as $rn)
                    <tr>
                        <td><strong>{{ $rn->NAMA_PELAJARAN }}:</strong></td>
                        <td>{{ number_format($rn->rata_nilai, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
