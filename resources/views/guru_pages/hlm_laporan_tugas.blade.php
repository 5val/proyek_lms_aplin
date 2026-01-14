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

            <!-- Charts -->
            <div class="row mt-4">
               <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                  <div class="average-card-custom">
                     <h5 class="average-card-title">Grafik Rata-Rata Nilai per Tugas</h5>
                     <div class="chart-container">
                        <canvas id="chartRataTugas"></canvas>
                     </div>
                  </div>
               </div>
               <div class="col-12 col-lg-6">
                  <div class="average-card-custom">
                     <h5 class="average-card-title">Grafik Rata-Rata Nilai per Siswa</h5>
                     <div class="chart-container">
                        <canvas id="chartRataSiswaTugas"></canvas>
                     </div>
                  </div>
               </div>
            </div>

            <!-- Laporan Nilai Tugas Siswa -->
            <div class="average-card-custom mt-4">
               <h5 class="average-card-title">Laporan Nilai Tugas Siswa</h5>
               <div class="table-responsive-custom">
               <table class="average-table table-bordered table-lg">
                <thead class="table-header-custom">
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
                              <td>{{ number_format($r->rata2, 2) }}</td>
                           </tr>
                        @endforeach
                     </tbody>
               </table>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
               document.addEventListener('DOMContentLoaded', function () {
                  const canvasTugas = document.getElementById('chartRataTugas');
                  const canvasSiswaTugas = document.getElementById('chartRataSiswaTugas');

                  if (canvasTugas) {
                     const labelsTugas = @json($rata2->pluck('nama_tugas'));
                     const dataTugas = @json($rata2->pluck('rata2'));

                     new Chart(canvasTugas, {
                        type: 'bar',
                        data: {
                           labels: labelsTugas,
                           datasets: [{
                              label: 'Rata-Rata Nilai per Tugas',
                              data: dataTugas,
                              backgroundColor: 'rgba(59, 130, 246, 0.5)',
                              borderColor: 'rgba(59, 130, 246, 1)',
                              borderWidth: 1,
                              borderRadius: 4,
                           }]
                        },
                        options: {
                           responsive: true,
                           maintainAspectRatio: false,
                           scales: {
                              y: {
                                 beginAtZero: true,
                                 max: 100,
                                 ticks: {
                                    stepSize: 10
                                 }
                              }
                           },
                           plugins: {
                              legend: {
                                 labels: {
                                    color: '#e5e7eb'
                                 }
                              }
                           }
                        }
                     });
                  }

                  if (canvasSiswaTugas) {
                     const labelsSiswaTugas = @json($rata2SiswaTugas->pluck('nama_siswa'));
                     const dataSiswaTugas = @json($rata2SiswaTugas->pluck('rata2'));

                     new Chart(canvasSiswaTugas, {
                        type: 'bar',
                        data: {
                           labels: labelsSiswaTugas,
                           datasets: [{
                              label: 'Rata-Rata Nilai Tugas per Siswa',
                              data: dataSiswaTugas,
                              backgroundColor: 'rgba(16, 185, 129, 0.5)',
                              borderColor: 'rgba(16, 185, 129, 1)',
                              borderWidth: 1,
                              borderRadius: 4,
                           }]
                        },
                        options: {
                           responsive: true,
                           maintainAspectRatio: false,
                           scales: {
                              y: {
                                 beginAtZero: true,
                                 max: 100,
                                 ticks: {
                                    stepSize: 10
                                 }
                              }
                           },
                           plugins: {
                              legend: {
                                 labels: {
                                    color: '#e5e7eb'
                                 }
                              }
                           }
                        }
                     });
                  }
               });
            </script>

        </div>
<?php else: ?>
   <div class="p-3">
      <h4 class="mb-3">Bukan Wali Kelas</h4>
   </div>
<?php endif; ?>

@endsection
