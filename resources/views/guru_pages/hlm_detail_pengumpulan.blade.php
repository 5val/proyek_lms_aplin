@extends('layouts.guru_app')

@section('guru_content')
   <div class="content">
      <button class="btn btn-danger"><a style="text-decoration: none; color: white;" href="{{ url('/guru/hlm_detail_tugas/' . base64_encode($submission->ID_TUGAS)) }}">Back</a></button><br><br>
          <h4 class="mb-3">Detail Pengumpulan Tugas</h4>

          <!-- Informasi Tugas -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tugas: {{ $submission->tugas->NAMA_TUGAS }}</h5>
              <p class="card-text"><strong>Deskripsi:</strong> {{ $submission->tugas->DESKRIPSI_TUGAS }}</p>
              <p class="card-text"><strong>Deadline:</strong> {{ $submission->tugas->DEADLINE_TUGAS }}</p>
              <p class="card-text"><strong>Status:</strong> <span class="badge bg-success">Sudah Dikirimkan</span></p>
            </div>
          </div>

          <!-- File Tugas -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tugas yang Dikirimkan oleh Siswa: {{ $submission->siswa->NAMA_SISWA }}</h5>
              <p><strong>File Tugas:</strong> <a href="{{ asset('storage/uploads/tugas/' . $submission->FILE_TUGAS) }}" download class="btn btn-info btn-sm">Unduh Tugas</a></p>
              <p><strong>Tanggal Pengumpulan:</strong> {{ $submission->TANGGAL_SUBMISSION }}</p>
              <p><strong>Nilai:</strong> {{ $submission->NILAI_TUGAS ? $submission->NILAI_TUGAS : 'Belum Dinilai' }}</p>
            </div>
          </div>

          <!-- Form Feedback -->
           <?php if(!$submission->NILAI_TUGAS): ?>
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Berikan Nilai</h5>
                <form method="POST" action="/guru/hlm_detail_pengumpulan">
                  @csrf
                  @method("PUT") 
                  <input type="hidden" name="ID_SUBMISSION" value="{{ $submission->ID_SUBMISSION }}">
                  <div class="mb-3">
                    <label for="nilai" class="form-label">Nilai</label>
                    <input type="number" class="form-control" name="nilai" id="nilai" placeholder="Masukkan nilai (0-100)">
                  </div>
                  <button type="submit" class="btn btn-primary">Kirim Nilai</button>
                </form>
              </div>
            </div>
           <?php endif; ?>

        </div>
@endsection