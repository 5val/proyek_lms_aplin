@extends('layouts.guru_app')

@section('guru_content')
   <div class="content">
          <h4 class="mb-3">Detail Pengumpulan Tugas</h4>

          <!-- Informasi Tugas -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tugas: Soal Aljabar</h5>
              <p class="card-text"><strong>Deskripsi:</strong> Selesaikan soal-soal aljabar di buku halaman 45-50.</p>
              <p class="card-text"><strong>Deadline:</strong> 25 April 2025</p>
              <p class="card-text"><strong>Status:</strong> <span class="badge bg-success">Sudah Dikirimkan</span></p>
            </div>
          </div>

          <!-- File Tugas -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tugas yang Dikirimkan oleh Siswa: Brian Tanuwijaya</h5>
              <p><strong>File Tugas:</strong> <a href="#" class="btn btn-info btn-sm">Unduh Tugas</a></p>
              <p><strong>Tanggal Pengumpulan:</strong> 24 April 2025</p>
              <p><strong>Catatan Siswa:</strong> <i>Mohon evaluasi soal nomor 3, saya kesulitan di bagian tersebut.</i></p>
            </div>
          </div>

          <!-- Form Feedback -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Berikan Nilai dan Feedback</h5>
              <form>
                <div class="mb-3">
                  <label for="nilai" class="form-label">Nilai</label>
                  <input type="number" class="form-control" id="nilai" placeholder="Masukkan nilai (0-100)">
                </div>
                <div class="mb-3">
                  <label for="feedback" class="form-label">Feedback</label>
                  <textarea class="form-control" id="feedback" rows="4" placeholder="Berikan feedback untuk siswa"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Feedback</button>
              </form>
            </div>
          </div>

        </div>
@endsection