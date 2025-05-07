@extends('layouts.guru_app')

@section('guru_content')
<button variant="contained" class="btn btn-sm btn-primary w-25 mb-3" onclick="window.location.href='/guru/detail_pelajaran'">
    Back
</button>
<h4 class="mb-3">Detail Tugas</h4>
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Tugas: Soal Aljabar</h5>
        <p class="card-text"><strong>Deskripsi:</strong> Selesaikan soal-soal aljabar di buku halaman 45-50.</p>
        <p class="card-text"><strong>Deadline:</strong> 25 April 2025</p>
        <p class="card-text"><strong>Status:</strong> <span class="status-belum">Belum Mengumpulkan</span></p>
    </div>
</div>
    <div class="btn-group">
        <button class="btn btn-warning" onclick="editTask()">Edit Tugas</button>
        <button class="btn btn-danger" onclick="deleteTask()">Hapus Tugas</button>
    </div>
    <div class="siswa-list mt-4">
        <h5>Siswa yang Sudah Mengumpulkan</h5>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Jessica Natalie</span>
            <div class="d-flex align-items-center">
                <span class="badge bg-success me-2">Sudah Mengumpulkan</span>
                <button class="btn btn-info btn-sm" onclick="viewTask('Jessica Natalie')">Lihat Tugas</button>
            </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>Brian Tanuwijaya</span>
            <div class="d-flex align-items-center">
                <span class="badge bg-success me-2">Sudah Mengumpulkan</span>
                <button class="btn btn-info btn-sm" onclick="viewTask('Brian Tanuwijaya')">Lihat Tugas</button>
            </div>
            </li>
        </ul>
    </div>
    <div class="siswa-list mt-4">
        <h5>Siswa yang Belum Mengumpulkan</h5>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
            Daniel Susilo
            <span class="badge bg-danger">Belum Mengumpulkan</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
            Tania Sari
            <span class="badge bg-danger">Belum Mengumpulkan</span>
            </li>
        </ul>
    </div>
@endsection