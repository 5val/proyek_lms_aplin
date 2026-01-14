@extends('layouts.admin_app')

@section('admin_content')
  <div class="p-3">
    <div class="row g-4 mb-4">

    </div>

    <div>
    <div class="average-card-custom">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="average-card-title mb-0">List Guru</h4>
        <div class="d-flex gap-2 flex-wrap">
          <a class="btn btn-primary btn-sm" href="/admin/tambahguru">Tambah Guru</a>
          <a class="btn btn-outline-primary btn-sm" href="/admin/uploadGuru">Upload Excel</a>
        </div>
      </div>

      <div class="table-responsive-custom mt-2">
        <table class="average-table table-bordered table-lg align-middle">
          <thead class="table-header-custom">
          <tr>
            <th>ID Guru</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>No. Telp</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
      <?php foreach ($allGuru as $g): ?>
      <tr class="{{ $g->STATUS_GURU == "Active" ? "" : "inactive" }}">
        <td>{{ $g->ID_GURU }}</td>
        <td>{{ $g->NAMA_GURU }}</td>
        <td>{{ $g->EMAIL_GURU }}</td>
        <td>{{ $g->ALAMAT_GURU }}</td>
        <td>{{ $g->NO_TELPON_GURU }}</td>
        <td>{{ $g->STATUS_GURU == "Active" ? "Aktif" : "In aktif" }}</td>
        <td>
        <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
          <a class="btn btn-warning btn-sm" href="{{ url('/admin/editguru/' . base64_encode($g->ID_GURU)) }}" title="Edit">
            <i class="bi bi-pencil-square" aria-hidden="true"></i>
            <span class="visually-hidden">Edit</span>
          </a>
          <a class="btn btn-{{ $g->STATUS_GURU == "Active" ? "danger text-white" : "primary" }} btn-sm" href="{{ url('/admin/listguru/' . base64_encode($g->ID_GURU)) }}" title="{{ $g->STATUS_GURU == "Active" ? "Hapus" : "Buat Aktif" }}">
            @if ($g->STATUS_GURU == "Active")
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
