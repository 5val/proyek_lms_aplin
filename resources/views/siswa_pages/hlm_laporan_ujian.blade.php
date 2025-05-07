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
          <div class="average-card">
            <h5>Rata-Rata Nilai Ujian</h5>
            <ul class="list-unstyled mt-3">
              <li><strong>Matematika:</strong> 88</li>
              <li><strong>Biologi:</strong> 84</li>
              <li><strong>Fisika:</strong> 79</li>
              <li><strong>Bahasa Inggris:</strong> 91</li>
              <li><strong>Kimia:</strong> 76</li>
            </ul>
          </div>

        </div>
@endsection