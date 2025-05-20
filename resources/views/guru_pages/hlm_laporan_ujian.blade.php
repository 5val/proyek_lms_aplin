@extends('layouts.guru_app')

@section('guru_content')
<form method="GET" action="/guru/hlm_laporan_ujian" class="mb-4">
        <label for="periodeSelect" class="form-label">Pilih Periode:</label>
        <select name="periodeSelect" id="periodeSelect" class="form-select" onchange="this.form.submit()">
            @foreach($kelas_periode as $p)
                <option value="{{ $p->periode->ID_PERIODE }}" {{ $periode->ID_PERIODE == $p->periode->ID_PERIODE ? 'selected' : '' }}>
                    {{ $p->periode->PERIODE }}
                </option>
            @endforeach
        </select>
    </form>
<?php if($kelas): ?>
   <div class="p-3">
            <h4 class="mb-3">Halaman Laporan Nilai</h4>
            <p><strong>Nama Guru:</strong> {{ session('userActive')->NAMA_GURU }} &nbsp; | &nbsp; <strong>NIP:</strong> {{ session('userActive')->ID_GURU }} &nbsp; | &nbsp; <strong>Wali Kelas:</strong> {{ $kelas->detailKelas->NAMA_KELAS }}</p>

            <!-- Laporan Nilai Siswa -->
            <h5 class="mt-4">Laporan Nilai Siswa</h5>
            <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai UTS</th>
                    <th>Nilai Tugas</th>
                    <th>Nilai Akhir</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                  <?php $counter = 1; ?>
                  <?php foreach ($list_nilai as $nilai): ?>
                     <tr>
                         <td>{{ $counter++ }}</td>
                         <td>{{ $nilai->nama_siswa }}</td>
                         <td>{{ $nilai->nama_pelajaran }}</td>
                         <td>{{ $nilai->nilai_uts }}</td>
                         <td>{{ $nilai->nilai_tugas }}</td>
                         <td>{{ $nilai->nilai_akhir }}</td>
                         <?php if($nilai->nilai_akhir >= 80): ?>
                           <td><span class="badge bg-success">Lulus</span></td>
                         <?php elseif($nilai->nilai_akhir >= 70): ?>
                           <td><span class="badge bg-warning">Perlu Perbaikan</span></td>
                         <?php else: ?>
                           <td><span class="badge bg-danger">Gagal</span></td>
                         <?php endif; ?>
                     </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
            </div>

            <!-- Nilai Rata-Rata per Tugas -->
            <div class="mt-4">
            <h5>Rata-Rata Nilai Akhir</h5>
            <?php foreach ($rata2 as $r): ?>
               <div class="card bg-light p-3">
                  <h6><strong>Rata-Rata Nilai Akhir {{ $r->nama_pelajaran }}:</strong> {{ $r->rata2 }}</h6>
               </div>
            <?php endforeach; ?>
            </div>

        </div>
<?php else: ?>
   <div class="p-3">
      <h4 class="mb-3">Bukan Wali Kelas</h4>
   </div>
<?php endif; ?>
@endsection