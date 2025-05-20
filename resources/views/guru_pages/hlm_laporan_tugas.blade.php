@extends('layouts.guru_app')

@section('guru_content')
<?php if($kelas): ?>
   <div class="p-3">
            <h4 class="mb-3">Halaman Laporan Nilai</h4>
            <p><strong>Nama Guru:</strong> {{ session('userActive')->NAMA_GURU }} &nbsp; | &nbsp; <strong>NIP:</strong> {{ session('userActive')->ID_GURU }}</p>

            <!-- Laporan Nilai Tugas Siswa -->
            <h5 class="mt-4">Laporan Nilai Tugas Siswa</h5>
            <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Tugas</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php $counter = 1; ?>
                  <?php foreach ($list_nilai as $nilai): ?>
                     <tr>
                         <td>{{ $counter++ }}</td>
                         <td>{{ $nilai->nama_siswa }}</td>
                         <td>{{ $nilai->nama_tugas }}</td>
                         <td>{{ $nilai->nilai_tugas }}</td>
                         <?php if($nilai->nilai_tugas >= 80): ?>
                           <td><span class="badge bg-success">Lulus</span></td>
                         <?php elseif($nilai->nilai_tugas >= 70): ?>
                           <td><span class="badge bg-warning">Perlu Perbaikan</span></td>
                         <?php else: ?>
                           <td><span class="badge bg-danger">Gagal</span></td>
                         <?php endif; ?>
                         <td><a href="{{ url('/guru/edit_nilai_tugas/') }}" class="btn btn-warning btn-sm">Edit</a></td>
                     </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
            </div>

            <!-- Nilai Rata-Rata per Tugas -->
            <div class="mt-4">
            <h5>Rata-Rata Nilai Tugas</h5>
            <?php foreach ($rata2 as $r): ?>
               <div class="card bg-light p-3">
                  <h6><strong>Rata-Rata Nilai {{ $r->nama_tugas }}:</strong> {{ $r->rata2 }}</h6>
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