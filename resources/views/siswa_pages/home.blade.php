@extends('layouts.siswa_app')

@section('siswa_content')
<h4 class="mb-3">Home Siswa</h4>
          <p><strong>Kelas:</strong> XII IPA 1 &nbsp; | &nbsp; <strong>Semester:</strong> Genap</p>

          <!-- Pelajaran Siswa -->
          <h5 class="mt-4">Pelajaran</h5>
          <div class="scroll-box mb-4">
            <a href="detail_pelajaran.php">
            <div class="card p-3">
              <div class="card-body">
                <i class="fas fa-calculator"></i>
                <h5>Matematika</h5>
              </div>
            </div>
            </a>
            <div class="card p-3">
              <div class="card-body">
                <i class="fas fa-leaf"></i>
                <h5>Biologi</h5>
              </div>
            </div>
            <div class="card p-3">
              <div class="card-body">
                <i class="fas fa-book-open"></i>
                <h5>Bahasa Inggris</h5>
              </div>
            </div>
            <div class="card p-3">
              <div class="card-body">
                <i class="fas fa-flask"></i>
                <h5>Fisika</h5>
              </div>
            </div>
            <div class="card p-3">
              <div class="card-body">
                <i class="fas fa-vial"></i>
                <h5>Kimia</h5>
              </div>
            </div>
            <div class="card p-3">
              <div class="card-body">
                <i class="fas fa-pencil-alt"></i>
                <h5>Bahasa Indonesia</h5>
              </div>
            </div>
            <div class="card p-3">
              <div class="card-body">
                <i class="fas fa-history"></i>
                <h5>Sejarah</h5>

              </div>
            </div>
          </div>

          <!-- Tugas yang Sedang Berlangsung -->
          <h5 class="mt-4">Tugas yang Sedang Berlangsung</h5>
          <div class="scroll-box mb-4">
          <a href="hlm_detail_tugas.php">
            <div class="card p-3">
              <strong>Matematika</strong>
              <p>Kerjakan soal fungsi kuadrat</p>
              <small>Tenggat: 25 Apr 2025</small>
            </div>
            </a>
            <div class="card p-3">
              <strong>Bahasa Indonesia</strong>
              <p>Tulis teks eksplanasi</p>
              <small>Tenggat: 26 Apr 2025</small>
            </div>
            <div class="card p-3">
              <strong>Biologi</strong>
              <p>Infografis organel sel</p>
              <small>Tenggat: 28 Apr 2025</small>
            </div>
          </div>

          <!-- Pengumuman -->
          <h5>Pengumuman</h5>
          <div class="bg-white shadow-sm rounded p-3 mb-3">
            <h6 class="fw-bold">Pengumpulan Tugas Bahasa Indonesia</h6>
            <p>Dikumpulkan paling lambat tanggal 25 April 2025.</p>
          </div>
          <div class="bg-white shadow-sm rounded p-3 mb-4">
            <h6 class="fw-bold">Ujian Akhir Semester</h6>
            <p>Akan dilaksanakan mulai 10 Juni 2025.</p>
          </div>

          <!-- Timetable -->
          <h5>Jadwal Pelajaran (Senin - Jumat)</h5>
          <div class="table-responsive">
            <table class="table table-bordered timetable-table bg-white">
              <thead class="table-secondary">
                <tr>
                  <th>Hari</th>
                  <th>Jam ke-1 (07:00 - 08:30)</th>
                  <th>Jam ke-2 (08:30 - 10:00)</th>
                  <th>Jam ke-3 (10:30 - 12:00)</th>
                  <th>Jam ke-4 (12:30 - 14:00)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Senin</td>
                  <td>Matematika</td>
                  <td>Biologi</td>
                  <td>Fisika</td>
                  <td>Sejarah</td>
                </tr>
                <tr>
                  <td>Selasa</td>
                  <td>Bahasa Indonesia</td>
                  <td>Kimia</td>
                  <td>Biologi</td>
                  <td>Matematika</td>
                </tr>
                <tr>
                  <td>Rabu</td>
                  <td>Bahasa Inggris</td>
                  <td>Kimia</td>
                  <td>Fisika</td>
                  <td>Matematika</td>
                </tr>
                <tr>
                  <td>Kamis</td>
                  <td>Biologi</td>
                  <td>Bahasa Indonesia</td>
                  <td>Sejarah</td>
                  <td>Matematika</td>
                </tr>
                <tr>
                  <td>Jumat</td>
                  <td>Bahasa Inggris</td>
                  <td>Fisika</td>
                  <td>Kimia</td>
                  <td>Bahasa Indonesia</td>
                </tr>
              </tbody>
            </table>
@endsection