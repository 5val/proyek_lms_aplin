@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <div>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="average-card-custom">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="average-card-title mb-0">List Siswa</h4>
        <div class="d-flex gap-2 flex-wrap">
          <a class="btn btn-primary btn-sm" href="tambahsiswa">Tambah Siswa</a>
          <a class="btn btn-outline-primary btn-sm" href="uploadSiswa">Upload Excel</a>
        </div>
      </div>

      <div class="table-responsive-custom mt-2">
        <table class="average-table table-bordered table-lg align-middle">
          <thead class="table-header-custom">

          <tr>
            <th>ID Siswa</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>No. Telp</th>
            <th>Status</th>
            <th>Action</th>
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
          <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
            <a class="btn btn-warning btn-sm" href="{{ url('/admin/editsiswa/' . base64_encode($g->ID_SISWA)) }}" title="Edit">
              <i class="bi bi-pencil-square" aria-hidden="true"></i>
              <span class="visually-hidden">Edit</span>
            </a>
            <a class="btn btn-{{ $g->STATUS_SISWA == "Active" ? "danger text-white" : "primary" }} btn-sm" href="{{ url('/admin/listsiswa/' . base64_encode($g->ID_SISWA)) }}" title="{{ $g->STATUS_SISWA == "Active" ? "Hapus" : "Buat Aktif" }}">
              @if ($g->STATUS_SISWA == "Active")
                <i class="bi bi-trash" aria-hidden="true"></i>
                <span class="visually-hidden">Hapus</span>
              @else
                Buat Aktif
              @endif
            </a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
