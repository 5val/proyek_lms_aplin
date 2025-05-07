@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
          <h4 class="mb-3">Detail Tugas</h4>

          <!-- Informasi Tugas -->
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Tugas: Soal Aljabar</h5>
              <p class="card-text"><strong>Deskripsi:</strong> Selesaikan soal-soal aljabar di buku halaman 45-50.</p>
              <p class="card-text"><strong>Deadline:</strong> 25 April 2025</p>
              <p class="card-text"><strong>Status:</strong> <span class="status-belum">Belum Mengumpulkan</span></p>
            </div>
          </div>

          <!-- Upload File -->
          <div class="card-upload">
            <h5>Upload Tugas</h5>
            <form>
              <div class="mb-3">
                <label for="formFile" class="form-label">Pilih File</label>
                <input class="form-control" type="file" id="formFile">
              </div>
              <button type="submit" class="btn btn-primary">Kumpulkan Tugas</button>
            </form>
          </div>

          <!-- Jika Sudah Upload, Tampilkan Nilai -->
          <div class="nilai-box mt-4">
            <h5>Nilai & Feedback</h5>
            <p><strong>Nilai:</strong> 90</p>
            <p><strong>Feedback:</strong> Sangat baik, perhitungan tepat.</p>
          </div>

        </div>
@endsection