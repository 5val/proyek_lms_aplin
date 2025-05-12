@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
    <h4 class="mb-3">Laporan Nilai Tugas</h4>

    <!-- Tasks that have been submitted (Table) -->
    <h5>Sudah Dikumpulkan</h5>
    <table class="table table-bordered mb-4">
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

    <!-- Tasks that have not been submitted (Cards) -->
    <h5>Belum Dikumpulkan</h5>
    <div class="row">
        @foreach ($tugasBelumDikirim as $t)
            <div class="col-md-4 mb-3">
                <div class="task-card">
                    <h5>{{ $t->NAMA_PELAJARAN }} - {{ $t->NAMA_TUGAS }}</h5>
                    <p><strong>Nilai:</strong> -</p>
                    <span class="task-status status-belum">Belum Dikumpulkan</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Card rata-rata -->
    <div class="average-card-custom">
        <h5 class="average-card-title">Rata-Rata Nilai per Mata Pelajaran</h5>
        
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
