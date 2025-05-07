@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
            <h4 class="mb-3">Halaman Laporan Nilai</h4>
            <p><strong>Nama Guru:</strong> Darren Susanto &nbsp; | &nbsp; <strong>NIP:</strong> G/001</p>

            <!-- Laporan Nilai Tugas Siswa -->
            <h5 class="mt-4">Laporan Nilai Tugas Siswa</h5>
            <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Tugas</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Andi S</td>
                    <td>Soal Turunan Fungsi</td>
                    <td>85</td>
                    <td><span class="badge bg-success">Lulus</span></td>
                    <td><a href="/guru/editnilai" class="btn btn-warning btn-sm">Edit</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Budi P</td>
                    <td>Soal Turunan Fungsi</td>
                    <td>78</td>
                    <td><span class="badge bg-warning">Perlu Perbaikan</span></td>
                    <td><a href="/guru/editnilai" class="btn btn-warning btn-sm">Edit</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Cici M</td>
                    <td>Soal Turunan Fungsi</td>
                    <td>92</td>
                    <td><span class="badge bg-success">Lulus</span></td>
                    <td><a href="edit_nilai.php" class="btn btn-warning btn-sm">Edit</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Dian R</td>
                    <td>Soal Turunan Fungsi</td>
                    <td>70</td>
                    <td><span class="badge bg-danger">Gagal</span></td>
                    <td><a href="edit_nilai.php" class="btn btn-warning btn-sm">Edit</a></td>
                </tr>
                </tbody>
            </table>
            </div>

            <!-- Nilai Rata-Rata per Tugas -->
            <div class="mt-4">
            <h5>Rata-Rata Nilai Tugas</h5>
            <div class="card bg-light p-3">
                <h6><strong>Rata-Rata Nilai Soal Turunan Fungsi:</strong> 81.25</h6>
            </div>
            </div>

        </div>
@endsection