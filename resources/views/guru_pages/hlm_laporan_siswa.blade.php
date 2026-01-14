@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
         <h4 class="mb-3">Halaman Laporan Nilai Siswa</h4>
         <p><strong>Nama Siswa:</strong> {{ $siswa->NAMA_SISWA }} &nbsp; | &nbsp; <strong>ID:</strong> {{ $siswa->ID_SISWA }}</p>

         <!-- Charts -->
         <div class="row mt-4">
            <div class="col-12 col-lg-6 mb-3 mb-lg-0">
               <div class="average-card-custom">
                  <h5 class="average-card-title">Grafik Rata-Rata Nilai Tugas per Mapel</h5>
                  <div class="chart-container">
                     <canvas id="chartTugasMapel"></canvas>
                  </div>
               </div>
            </div>
            <div class="col-12 col-lg-6">
               <div class="average-card-custom">
                  <h5 class="average-card-title">Grafik Rata-Rata Nilai Akhir</h5>
                  <div class="chart-container">
                     <canvas id="chartNilaiAkhir"></canvas>
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
         </div>

         <!-- Nilai Rata-Rata per Tugas -->
         <div class="average-card-custom mt-4">
            <h5 class="average-card-title">Rata-Rata Nilai Tugas</h5>
            <?php foreach ($rata2_tugas as $r): ?>
               <div class="nilai-box p-3 mb-2">
                  <h6><strong>Rata-Rata Nilai Tugas {{ $r->nama_pelajaran }}:</strong> {{ $r->rata2 }}</h6>
               </div>
            <?php endforeach; ?>
         </div>

         <!-- Laporan Nilai Siswa -->
         <div class="average-card-custom mt-4">
            <h5 class="average-card-title">Laporan Nilai Siswa</h5>
            <div class="table-responsive-custom">
               <table class="average-table table-bordered table-lg">
                   <thead class="table-header-custom">
                   <tr>
                       <th>No.</th>
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
         </div>

            <!-- Nilai Rata-Rata per Tugas -->
            <div class="average-card-custom mt-4">
               <h5 class="average-card-title">Rata-Rata Nilai Akhir</h5>
               <?php foreach ($rata2 as $r): ?>
                  <div class="nilai-box p-3 mb-2">
                     <h6><strong>Rata-Rata Nilai Akhir:</strong> {{ $r->rata2 }}</h6>
                  </div>
               <?php endforeach; ?>
            </div>

      </div>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
         document.addEventListener('DOMContentLoaded', function () {
            const canvasTugasMapel = document.getElementById('chartTugasMapel');
            const canvasNilaiAkhir = document.getElementById('chartNilaiAkhir');

            if (canvasTugasMapel) {
               const labelsTugas = @json($rata2_tugas->pluck('nama_pelajaran'));
               const dataTugas = @json($rata2_tugas->pluck('rata2'));

               new Chart(canvasTugasMapel, {
                  type: 'bar',
                  data: {
                     labels: labelsTugas,
                     datasets: [{
                        label: 'Rata-Rata Nilai Tugas',
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

            if (canvasNilaiAkhir) {
               const labelsNilai = ['Rata-Rata Nilai Akhir'];
               const dataNilai = @json($rata2->pluck('rata2'));

               new Chart(canvasNilaiAkhir, {
                  type: 'bar',
                  data: {
                     labels: labelsNilai,
                     datasets: [{
                        label: 'Nilai',
                        data: dataNilai,
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
@endsection
