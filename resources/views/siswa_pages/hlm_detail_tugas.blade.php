@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
    <h4 class="mb-3">Detail Tugas</h4>

    <!-- Informasi Tugas -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Tugas: {{ $tugas->NAMA_TUGAS }}</h5>
            <p class="card-text"><strong>Deskripsi:</strong> {{ $tugas->DESKRIPSI_TUGAS }}</p>
            <p class="card-text"><strong>Deadline:</strong> {{ $tugas->DEADLINE_TUGAS }}</p>
            <p class="card-text"><strong>Status:</strong> 
                @if ($submission)
                    <span class="status-selesai">Sudah Dikumpulkan</span>
                @else
                    <span class="status-belum">Belum Mengumpulkan</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Upload File -->
    @if (!$submission)  <!-- Hanya tampilkan form upload jika tugas belum dikumpulkan -->
    <div class="card-upload">
        <h5>Upload Tugas</h5>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="formFile" class="form-label">Pilih File</label>
                <input class="form-control" type="file" id="formFile" name="file_tugas">
            </div>
            <button type="submit" class="btn btn-primary">Kumpulkan Tugas</button>
        </form>
    </div>
    @endif

    <!-- Jika Sudah Upload, Tampilkan Nilai -->
    @if ($submission && $nilai !== null)
    <div class="nilai-box mt-4">
        <h5>Nilai & Feedback</h5>
        <p><strong>Nilai:</strong> {{ $nilai }}</p>
    </div>
    @endif

</div>
@endsection
