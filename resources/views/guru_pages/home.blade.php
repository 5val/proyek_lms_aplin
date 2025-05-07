@extends('layouts.guru_app')

@section('guru_content')
<h4 class="mb-3">Home Guru</h4>
            <p><strong>Nama Guru:</strong> Darren Susanto &nbsp; | &nbsp; <strong>NIP:</strong> G/001</p>
            
            <!-- Info Wali Kelas -->
            <h5 class="mt-4">Wali Kelas</h5>
            <div class="bg-white shadow-sm rounded p-3 mb-4">
            <p>Anda merupakan wali dari kelas: <strong>XII IPA 1</strong></p>
            </div>

            <!-- Pelajaran yang Diajarkan -->
            <h5 class="mt-4">Pelajaran yang Diajarkan</h5>
            <div class="scroll-box mb-4 d-flex flex-row flex-nowrap overflow-auto">
               <a href="/guru/detail_pelajaran">
               <div class="card p-3 me-3 text-center">
                  <div class="card-body">
                  <i class="fas fa-calculator fa-2x mb-2"></i>
                  <h5>Matematika</h5>
                  </div>
               </div>
            </a>
            <div class="card p-3 me-3 text-center">
                <div class="card-body">
                <i class="fas fa-flask fa-2x mb-2"></i>
                <h5>Fisika</h5>
                </div>
            </div>
            <div class="card p-3 me-3 text-center">
                <div class="card-body">
                <i class="fas fa-vial fa-2x mb-2"></i>
                <h5>Kimia</h5>
                </div>
            </div>
            </div>

            <!-- Tugas yang Sedang Berlangsung -->
            <h5 class="mt-4">Tugas yang Sedang Berlangsung</h5>
            <div class="scroll-box mb-4 d-flex flex-row flex-nowrap overflow-auto">
               <a href="/guru/hlm_detail_tugas">
            <div class="card p-3 me-3">
                <strong>Matematika</strong>
                <p>Membuat soal turunan fungsi</p>
                <small>Tenggat: 24 Apr 2025</small>
            </div>
            </a>
            <div class="card p-3 me-3">
                <strong>Fisika</strong>
                <p>Praktikum Hukum Newton</p>
                <small>Tenggat: 26 Apr 2025</small>
            </div>
            <div class="card p-3 me-3">
                <strong>Kimia</strong>
                <p>Analisis Reaksi Asam Basa</p>
                <small>Tenggat: 28 Apr 2025</small>
            </div>
            </div>

            <!-- Pengumuman -->
            <h5>Pengumuman</h5>
            <div class="bg-white shadow-sm rounded p-3 mb-3">
            <h6 class="fw-bold">Rapat Koordinasi Guru</h6>
            <p>Rapat akan diadakan pada Jumat, 25 April 2025 pukul 13.00 WIB di ruang rapat 1.</p>
            </div>
            <div class="bg-white shadow-sm rounded p-3 mb-4">
            <h6 class="fw-bold">Pengumpulan RPP Semester Ganjil</h6>
            <p>Mohon dikumpulkan paling lambat tanggal 30 April 2025.</p>
            </div>

            <!-- Jadwal Mengajar Guru -->
            <h5>Jadwal Mengajar (Senin - Jumat)</h5>
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
                    <td>Matematika (XII IPA 1)</td>
                    <td>-</td>
                    <td>Fisika (XII IPA 2)</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Selasa</td>
                    <td>Kimia (XI IPA 1)</td>
                    <td>Matematika (XII IPA 1)</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Rabu</td>
                    <td>Fisika (XII IPA 2)</td>
                    <td>-</td>
                    <td>Kimia (XI IPA 1)</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Kamis</td>
                    <td>Matematika (XII IPA 1)</td>
                    <td>Fisika (XII IPA 2)</td>
                    <td>-</td>
                    <td>Kimia (XI IPA 1)</td>
                </tr>
                <tr>
                    <td>Jumat</td>
                    <td>Kimia (XI IPA 1)</td>
                    <td>Fisika (XII IPA 2)</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                </tbody>
            </table>
@endsection