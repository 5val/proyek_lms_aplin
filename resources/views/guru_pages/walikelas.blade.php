@extends('layouts.guru_app')

@section('guru_content')
<div class="topbar rounded mt-3">
          <h3>XII IPA 1 2025</h3>
          <div class="row">
            <div class="col">Jumlah Murid<br><strong>26</strong></div>
            <div class="col">Ruang Kelas<br><strong>F3/01</strong></div>
            <div class="col">Semester<br><strong>Ganjil</strong></div>
          </div>
        </div>
        <br>
<div class="content-box">
<h5>Daftar Siswa</h5>
<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="table-secondary">
            <tr>
            <th scope="col" class="w-25">ID</th>
            <th scope="col">Nama</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>220/0001</td>
            <td>Andi Santoso</td>
            <td><button class="btn btn-primary">Lihat Laporan</button></td>
            </tr>
            <tr>
            <td>220/0002</td>
            <td>Budi Wijaya</td>
            <td><button class="btn btn-primary">Lihat Laporan</button></td>
            </tr>
            <tr>
            <td>220/0003</td>
            <td>Citra Lestari</td>
            <td><button class="btn btn-primary">Lihat Laporan</button></td>
            </tr>
            <tr>
            <td>220/0004</td>
            <td>Dewi Kurnia</td>
            <td><button class="btn btn-primary">Lihat Laporan</button></td>
            </tr>
            <tr>
            <td>220/0005</td>
            <td>Eko Prasetyo</td>
            <td><button class="btn btn-primary">Lihat Laporan</button></td>
            </tr>
        </tbody>
    </table>
</div>
</div>
@endsection