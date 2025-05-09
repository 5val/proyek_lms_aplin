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
                <th>Feedback Guru</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Matematika - Persamaan Kuadrat</td>
                <td>90</td>
                <td>Sangat baik, pertahankan!</td>
                <td><span class="task-status status-selesai">Sudah Dikumpulkan</span></td>
            </tr>
            <tr>
                <td>Matematika - Statistika</td>
                <td>85</td>
                <td>Masih kurang di bagian diagram.</td>
                <td><span class="task-status status-selesai">Sudah Dikumpulkan</span></td>
            </tr>
            <tr>
                <td>Biologi - Sistem Reproduksi</td>
                <td>88</td>
                <td>Cukup baik, pelajari lebih dalam bagian hormon.</td>
                <td><span class="task-status status-selesai">Sudah Dikumpulkan</span></td>
            </tr>
            <tr>
                <td>Bahasa Inggris - Essay</td>
                <td>92</td>
                <td>Penulisan sangat rapi dan sesuai grammar.</td>
                <td><span class="task-status status-selesai">Sudah Dikumpulkan</span></td>
            </tr>
        </tbody>
    </table>

    <!-- Tasks that have not been submitted (Cards) -->
    <h5>Belum Dikumpulkan</h5>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="task-card">
                <h5>Fisika - Gerak Lurus</h5>
                <p><strong>Nilai:</strong> -</p>
                <p><strong>Feedback Guru:</strong> -</p>
                <span class="task-status status-belum">Belum Dikumpulkan</span>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="task-card">
                <h5>Fisika - Gerak Lurus</h5>
                <p><strong>Nilai:</strong> -</p>
                <p><strong>Feedback Guru:</strong> -</p>
                <span class="task-status status-belum">Belum Dikumpulkan</span>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="task-card">
                <h5>Fisika - Gerak Lurus</h5>
                <p><strong>Nilai:</strong> -</p>
                <p><strong>Feedback Guru:</strong> -</p>
                <span class="task-status status-belum">Belum Dikumpulkan</span>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="task-card">
                <h5>Fisika - Gerak Lurus</h5>
                <p><strong>Nilai:</strong> -</p>
                <p><strong>Feedback Guru:</strong> -</p>
                <span class="task-status status-belum">Belum Dikumpulkan</span>
            </div>
        </div>
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
                <tr>
                    <td><strong>Matematika:</strong></td>
                    <td>87.5</td>
                </tr>
                <tr>
                    <td><strong>Biologi:</strong></td>
                    <td>88</td>
                </tr>
                <tr>
                    <td><strong>Fisika:</strong></td>
                    <td>-</td>
                </tr>
                <tr>
                    <td><strong>Bahasa Inggris:</strong></td>
                    <td>92</td>
                </tr>
            </tbody>
        </table>
    </div>



</div>
@endsection
