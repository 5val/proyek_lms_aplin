@extends('layouts.guru_app')

@section('guru_content')
   <div>

      <h4 class="mb-3">Home Guru</h4>
      <p><strong>Nama Guru:</strong> {{ session('userActive')->NAMA_GURU }} &nbsp; | &nbsp; <strong>NIP:</strong>
        {{ session('userActive')->ID_GURU }} &nbsp; | &nbsp; <strong>Periode:</strong> {{ $periode->PERIODE }}</p>

      <!-- Info Wali Kelas -->
      <?php if ($wali_kelas): ?>
      <h5 class="mt-4">Wali Kelas</h5>
      <div class="bg-white shadow-sm rounded p-3 mb-4">
        <p>Anda merupakan wali dari kelas: <strong>{{ $wali_kelas->NAMA_KELAS }}</strong></p>
      </div>
      <?php endif; ?>

      <!-- Pelajaran yang Diajarkan -->
      <h5 class="mt-4">Pelajaran yang Diajarkan</h5>
      <div class="scroll-box mb-4 d-flex flex-row flex-nowrap overflow-auto">
        <?php foreach ($mata_pelajaran as $m): ?>
        <a href="{{ url('/guru/detail_pelajaran/' . base64_encode($m->id_mata_pelajaran)) }}">
          <div class="card p-3 me-3 text-center">
            <div class="card-body">
               <i class="fas fa-calculator fa-2x mb-2"></i>
               <h5>{{ $m->nama_pelajaran }}</h5>
               <p>Kelas: {{ $m->nama_kelas }}</p>
            </div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>

      <!-- Tugas yang Sedang Berlangsung -->
      <h5 class="mt-4">Tugas yang Sedang Berlangsung</h5>
      <div class="scroll-box mb-4 d-flex flex-row flex-nowrap overflow-auto">
        <?php foreach ($all_tugas as $t): ?>
        <a href="{{ url('/guru/hlm_detail_tugas/' . base64_encode($t->id_tugas)) }}">
          <div class="card p-3 me-3">
            <strong>{{ $t->nama_pelajaran }}</strong>
            <p>{{ $t->deskripsi_tugas }}</p>
            <small>Tenggat: {{ $t->deadline_tugas }}</small>
          </div>
        </a>
        <?php endforeach; ?>
      </div>

      <!-- Pengumuman -->
      <h5>Pengumuman</h5>
      <?php foreach ($all_pengumuman as $p): ?>
      <div class="bg-white shadow-sm rounded p-3 mb-3">
        <h6 class="fw-bold">{{ $p->Judul }}</h6>
        <p>{{ $p->Deskripsi }}</p>
      </div>
      <?php endforeach; ?>
   </div>

   <!-- Jadwal Mengajar Guru -->
   <div class="p-3">
      <h5>Jadwal Mengajar (Senin - Jumat)</h5>
      <?php $listHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
   $listJam = ['07:00-08:30', '08:30-10:00', '10:00-11:30', '12:00-13:30', '13:30-15:00'];
            ?>
      <div class="table-responsive">
        <table class="table table-bordered timetable-table bg-white no-data-table">
          <thead class="table-secondary">
            <tr>
               <th>Hari</th>
               <th>Jam ke-1 (07:00 - 08:30)</th>
               <th>Jam ke-2 (08:30 - 10:00)</th>
               <th>Jam ke-3 (10:00 - 11:30)</th>
               <th>Jam ke-4 (12:00 - 13:30)</th>
               <th>Jam ke-5 (13:30 - 15:00)</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($listHari as $hari): ?>
            <tr>
               <td>{{ $hari }}</td>
               <?php   foreach ($listJam as $jam): ?>
               <?php      if (isset($jadwal[$hari][$jam])): ?>
               <td>{{ $jadwal[$hari][$jam]->nama_pelajaran }} ({{ $jadwal[$hari][$jam]->nama_kelas }})</td>
               <?php      else: ?>
               <td>-</td>
               <?php      endif; ?>
               <?php   endforeach; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
   </div>
   </div>
@endsection