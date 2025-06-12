@extends('layouts.guru_app')

@section('guru_content')
<button variant="contained" class="btn btn-sm btn-primary w-25 mb-3">
   <a style="text-decoration: none; color: white;" href="{{ url()->previous() }}">Back</a>
</button>
<h4 class="mb-3">Detail Tugas</h4>
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Tugas: {{ $tugas->NAMA_TUGAS }}</h5>
        <p class="card-text"><strong>Deskripsi:</strong>{{ $tugas->DESKRIPSI_TUGAS }}</p>
        <p class="card-text"><strong>Deadline:</strong>{{ $tugas->DEADLINE_TUGAS }}</p>
        <p class="card-text"><strong>Status:</strong>
        @if ($submissions->count()> 0)
            <span class="status-selesai">Sudah Dikumpulkan</span>
        @else
            <span class="status-belum">Belum Mengumpulkan</span>
        @endif
        </p>
    </div>
</div>
    <div class="btn-group">
        <button class="btn btn-warning" onclick="editTask()">Edit Tugas</button>
        <button class="btn btn-danger" onclick="deleteTask()">Hapus Tugas</button>
    </div>
   <div class="siswa-list mt-4">
    <h5>Siswa yang Sudah Mengumpulkan</h5>
    <ul class="list-group">
        @forelse($submissions as $s)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $s->siswa->NAMA_SISWA }}</span>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success me-2">Sudah Mengumpulkan</span>
                    <a href="{{ url('/guru/hlm_detail_pengumpulan/' . base64_encode($s->ID_SUBMISSION)) }}" class="text-decoration-none text-dark">
                    <button class="btn btn-info btn-sm">Lihat Tugas</button></a>
                </div>
            </li>
        @empty
            <li class="list-group-item">Belum ada yang mengumpulkan.</li>
        @endforelse
    </ul>
</div>

    <div class="siswa-list mt-4">
    <h5>Siswa yang Belum Mengumpulkan</h5>
    <ul class="list-group">
        @forelse($siswaBelum as $siswa)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $siswa->NAMA_SISWA }}
                <span class="badge bg-danger">Belum Mengumpulkan</span>
            </li>
        @empty
            <li class="list-group-item">Semua siswa sudah mengumpulkan.</li>
        @endforelse
    </ul>
</div>
@endsection