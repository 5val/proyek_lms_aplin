@extends('layouts.guru_app')

@section('guru_content')
<form method="GET" action="/guru/hlm_laporan_tugas" class="mb-4">
        <label for="periodeSelect" class="form-label">Pilih Periode:</label>
        <select name="periodeSelect" id="periodeSelect" class="form-select" onchange="this.form.submit()">
            @foreach($allPeriode as $p)
                <option value="{{ $p->ID_PERIODE }}" {{ $periode->ID_PERIODE == $p->ID_PERIODE ? 'selected' : '' }}>
                    {{ $p->PERIODE }}
                </option>
            @endforeach
        </select>
    </form>
<?php if($kelas): ?>
   <div class="p-3">
            <h4 class="mb-3">Halaman Laporan Nilai</h4>
            <p><strong>Nama Guru:</strong> {{ session('userActive')->NAMA_GURU }} &nbsp; | &nbsp; <strong>NIP:</strong> {{ session('userActive')->ID_GURU }} &nbsp; | &nbsp; <strong>Wali Kelas:</strong> {{ $kelas->detailKelas->NAMA_KELAS }}</p>

            <!-- Laporan Nilai Tugas Siswa -->
            <h5 class="mt-4">Laporan Nilai Tugas Siswa</h5>
            <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Tugas</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                  <?php $counter = 1; ?>
                  <?php foreach ($list_nilai as $nilai): ?>
                     <tr>
                         <td>{{ $counter++ }}</td>
                         <td>{{ $nilai->nama_siswa }}</td>
                         <td>{{ $nilai->nama_tugas }}</td>
                         <td>{{ $nilai->nama_pelajaran }}</td>
                         <td>{{ $nilai->nilai_tugas }}</td>
                         <?php if($nilai->nilai_tugas >= 80): ?>
                           <td><span class="badge bg-success">Lulus</span></td>
                         <?php elseif($nilai->nilai_tugas >= 70): ?>
                           <td><span class="badge bg-warning">Perlu Perbaikan</span></td>
                         <?php else: ?>
                           <td><span class="badge bg-danger">Gagal</span></td>
                         <?php endif; ?>
                     </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
            </div>

            <!-- Rata-rata Nilai Ujian -->
            <div class="average-card-custom">
               <h5 class="average-card-title">Rata-Rata Nilai per Tugas</h5>
               <table class="average-table table-bordered table-lg">
                     <thead class="table-header-custom">
                        <tr>
                           <th>Nama Tugas</th>
                           <th>Nilai</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($rata2 as $r)
                           <tr>
                              <td><strong>{{ $r->nama_tugas }}</strong></td>
                              <td>{{ number_format($r->rata2, 2) }}</tddecimals: >
                           </tr>
                        @endforeach
                     </tbody>
               </table>
            </div>

        </div>
<?php else: ?>
   <div class="p-3">
      <h4 class="mb-3">Bukan Wali Kelas</h4>
   </div>
<?php endif; ?>

@endsection