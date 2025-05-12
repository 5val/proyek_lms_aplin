@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
    <h4 class="mb-3">Laporan Nilai Ujian</h4>

    <!-- Card Ujian -->
    @foreach ($ujian as $u)
        <div class="exam-card">
            <h5>{{ $u->NAMA_PELAJARAN }} - Ujian Tengah Semester</h5>
            <p><strong>Nilai:</strong> {{ $u->NILAI_UTS }}</p>
            <p><strong>Guru:</strong> {{ $u->NAMA_GURU }}.</p>
        </div>
        
        <div class="exam-card">
            <h5>{{ $u->NAMA_PELAJARAN }} - Ujian Akhir Semester</h5>
            <p><strong>Nilai:</strong> {{ $u->NILAI_UAS }}</p>
            <p><strong>Guru:</strong> {{ $u->NAMA_GURU }}</p>
        </div>
    @endforeach

    <!-- Card rata-rata -->
    <div class="average-card-custom">
        <h5 class="average-card-title">Rata-Rata Nilai Ujian per Mata Pelajaran</h5>
        
        <!-- Table for average scores -->
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