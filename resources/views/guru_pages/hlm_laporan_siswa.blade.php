@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
         <h4 class="mb-3">Halaman Laporan Nilai Siswa</h4>
         <p><strong>Nama Siswa:</strong> {{ $siswa->NAMA_SISWA }} &nbsp; | &nbsp; <strong>ID:</strong> {{ $siswa->ID_SISWA }}</p>

         <!-- Laporan Nilai Tugas Siswa -->
         <h5 class="mt-4">Laporan Nilai Tugas Siswa</h5>
         <div class="table-responsive">
         <table class="table table-bordered bg-white">
               <thead class="table-secondary">
               <tr>
                  <th>No.</th>
                  <th>Tugas</th>
                  <th>Mata Pelajaran</th>
                  <th>Nilai</th>
                  <th>Status</th>
               </tr>
               </thead>
               <tbody>
               <?php $counter = 1; ?>
               <?php foreach ($list_nilai_tugas as $nilai): ?>
                  <tr>
                        <td>{{ $counter++ }}</td>
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

         <!-- Nilai Rata-Rata per Tugas -->
         <div class="mt-4">
         <h5>Rata-Rata Nilai Tugas</h5>
         <?php foreach ($rata2_tugas as $r): ?>
            <div class="card bg-light p-3">
               <h6><strong>Rata-Rata Nilai Tugas {{ $r->nama_pelajaran }}:</strong> {{ $r->rata2 }}</h6>
            </div>
         <?php endforeach; ?>
         </div>

         <!-- Laporan Nilai Siswa -->
            <h5 class="mt-4">Laporan Nilai Siswa</h5>
            <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai UTS</th>
                    <th>Nilai Tugas</th>
                    <th>Nilai Akhir</th>
                    <th>Status</th>
                    <!-- <th>Action</th> -->
                </tr>
                </thead>
                <tbody>
                  <?php $counter = 1; ?>
                  <?php foreach ($list_nilai as $nilai): ?>
                     <tr>
                         <td>{{ $counter++ }}</td>
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
                         <!-- <td><a href="/guru/editnilai" class="btn btn-warning btn-sm">Edit</a></td> -->
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
                  <h6><strong>Rata-Rata Nilai Akhir:</strong> {{ $r->rata2 }}</h6>
               </div>
            <?php endforeach; ?>
            </div>

      </div>
@endsection