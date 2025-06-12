@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <div>
    <h4>List Siswa</h4><br>
    <button class="btn btn-success"><a style="text-decoration: none; color: white;" href="tambahsiswa">Tambah
      Siswa</a></button>
    <a class="btn btn-success" style="text-decoration: none; color: white;" href="uploadSiswa">Upload
    Excel</a><br><br>
    <table class="table table-bordered align-middle">
    <thead>

      <tr class="thead" style="font-weight: bold; background-color: #608BC1;">
      <td>ID Siswa</td>
      <td>Nama</td>
      <td>Email</td>
      <td>Alamat</td>
      <td>No. Telp</td>
      <td>Status</td>
      <td>Action</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($allsiswa as $g): ?>
      <tr class="{{ $g->STATUS_SISWA == "Active" ? "" : "inactive" }}">
      <td>{{ $g->ID_SISWA }}</td>
      <td>{{ $g->NAMA_SISWA}}</td>
      <td>{{ $g->EMAIL_SISWA}}</td>
      <td>{{ $g->ALAMAT_SISWA}}</td>
      <td>{{ $g->NO_TELPON_SISWA}}</td>
      <td>{{ $g->STATUS_SISWA == "Active" ? "Aktif" : "Inaktif" }}</td>
      <td>
        <div style="display: flex; gap: 5px;">
        <button class="btn btn-primary"><a href="{{ url('/admin/editsiswa/' . base64_encode($g->ID_SISWA)) }}"
          style="text-decoration: none; color: white;">Edit</a></button>
        <button class="btn btn-danger"><a href="{{ url('/admin/listsiswa/' . base64_encode($g->ID_SISWA)) }}"
          style="text-decoration: none; color: white;">{{ $g->STATUS_SISWA == "Active" ? "Hapus" : "Buat Aktif" }}</a></button>
        </div>
      </td>
      </tr>
      <?php endforeach; ?>
    
    </tbody>
    </table>
  </div>
@endsection