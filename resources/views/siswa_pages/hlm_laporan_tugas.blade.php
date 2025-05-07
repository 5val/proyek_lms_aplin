@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
          <h4 class="mb-3">Laporan Nilai Tugas</h4>

          <!-- Card tugas -->
          <div class="task-card">
            <h5>Matematika - Persamaan Kuadrat</h5>
            <p><strong>Nilai:</strong> 90</p>
            <p><strong>Feedback Guru:</strong> Sangat baik, pertahankan!</p>
            <span class="task-status status-selesai">Sudah Dikumpulkan</span>
          </div>

          <div class="task-card">
            <h5>Matematika - Statistika</h5>
            <p><strong>Nilai:</strong> 85</p>
            <p><strong>Feedback Guru:</strong> Masih kurang di bagian diagram.</p>
            <span class="task-status status-selesai">Sudah Dikumpulkan</span>
          </div>

          <div class="task-card">
            <h5>Biologi - Sistem Reproduksi</h5>
            <p><strong>Nilai:</strong> 88</p>
            <p><strong>Feedback Guru:</strong> Cukup baik, pelajari lebih dalam bagian hormon.</p>
            <span class="task-status status-selesai">Sudah Dikumpulkan</span>
          </div>

          <div class="task-card">
            <h5>Fisika - Gerak Lurus</h5>
            <p><strong>Nilai:</strong> - </p>
            <p><strong>Feedback Guru:</strong> - </p>
            <span class="task-status status-belum">Belum Dikumpulkan</span>
          </div>

          <div class="task-card">
            <h5>Bahasa Inggris - Essay</h5>
            <p><strong>Nilai:</strong> 92</p>
            <p><strong>Feedback Guru:</strong> Penulisan sangat rapi dan sesuai grammar.</p>
            <span class="task-status status-selesai">Sudah Dikumpulkan</span>
          </div>

          <!-- Card rata-rata -->
          <div class="average-card">
            <h5>Rata-Rata Nilai per Mata Pelajaran</h5>
            <ul class="list-unstyled mt-3">
              <li><strong>Matematika:</strong> 87.5</li>
              <li><strong>Biologi:</strong> 88</li>
              <li><strong>Fisika:</strong> - (Belum dikumpulkan)</li>
              <li><strong>Bahasa Inggris:</strong> 92</li>
            </ul>
          </div>

        </div>
@endsection