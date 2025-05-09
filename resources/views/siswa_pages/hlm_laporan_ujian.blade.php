@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
          <h4 class="mb-3">Laporan Nilai Ujian</h4>

          <!-- Card Ujian -->
          <div class="exam-card">
            <h5>Matematika - Ujian Tengah Semester</h5>
            <p><strong>Nilai:</strong> 88</p>
            <p><strong>Feedback Guru:</strong> Pemahaman materi sangat baik.</p>
          </div>

          <div class="exam-card">
            <h5>Biologi - Ujian Akhir Semester</h5>
            <p><strong>Nilai:</strong> 84</p>
            <p><strong>Feedback Guru:</strong> Butuh pendalaman di bab Genetika.</p>
          </div>

          <div class="exam-card">
            <h5>Fisika - Ujian Tengah Semester</h5>
            <p><strong>Nilai:</strong> 79</p>
            <p><strong>Feedback Guru:</strong> Perlu latihan soal lebih banyak.</p>
          </div>

          <div class="exam-card">
            <h5>Bahasa Inggris - Ujian Akhir Semester</h5>
            <p><strong>Nilai:</strong> 91</p>
            <p><strong>Feedback Guru:</strong> Excellent grammar and writing skills!</p>
          </div>

          <div class="exam-card">
            <h5>Kimia - Ujian Tengah Semester</h5>
            <p><strong>Nilai:</strong> 76</p>
            <p><strong>Feedback Guru:</strong> Perlu perhatian di konsep reaksi kimia.</p>
          </div>


          <!-- Card rata-rata -->
          <div class="average-card-custom">
              <h5 class="average-card-title">Rata-Rata Nilai Ujian per Mata Pelajaran</h5>
              
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