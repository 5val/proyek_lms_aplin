@extends('layouts.guru_app')

@section('guru_content')

        <div class="p-3">
            <h4 class="mb-3">Halaman Laporan Nilai</h4>
            <p><strong>Nama Guru:</strong> Darren Susanto &nbsp; | &nbsp; <strong>NIP:</strong> G/001</p>

            <!-- Laporan Nilai Ujian -->
            <h5 class="mt-4">Laporan Nilai Ujian</h5>
            <div class="table-responsive">
            <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Ujian</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Andi S</td>
                    <td>Ujian Matematika</td>
                    <td>88</td>
                    <td><span class="badge bg-success">Lulus</span></td>
                    <td><a href="edit_nilai.php" class="btn btn-warning btn-sm">Edit</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Budi P</td>
                    <td>Ujian Matematika</td>
                    <td>75</td>
                    <td><span class="badge bg-warning">Perlu Perbaikan</span></td>
                    <td><a href="edit_nilai.php" class="btn btn-warning btn-sm">Edit</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Cici M</td>
                    <td>Ujian Matematika</td>
                    <td>95</td>
                    <td><span class="badge bg-success">Lulus</span></td>
                    <td><a href="edit_nilai.php" class="btn btn-warning btn-sm">Edit</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Dian R</td>
                    <td>Ujian Matematika</td>
                    <td>60</td>
                    <td><span class="badge bg-danger">Gagal</span></td>
                    <td><a href="edit_nilai.php" class="btn btn-warning btn-sm">Edit</a></td>
                </tr>
                </tbody>
            </table>
            </div>

            <!-- Nilai Rata-Rata per Kelas -->
            <div class="mt-4">
            <h5>Rata-Rata Nilai Kelas</h5>
            <div class="card bg-light p-3">
                <h6><strong>Rata-Rata Nilai Ujian Matematika:</strong> 79.5</h6>
            </div>
            </div>
        </div>
@endsection