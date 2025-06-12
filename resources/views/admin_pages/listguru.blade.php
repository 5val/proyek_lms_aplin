@extends('layouts.admin_app')

@section('admin_content')
  <div class="p-3">
    <div class="row g-4 mb-4">

    </div>

    <div>
    <h4>List Guru</h4><br>
    <button class="btn btn-success"><a style="text-decoration: none; color: white;" href="/admin/tambahguru">Tambah
      Guru</a></button>
    <button class="btn btn-success"><a style="text-decoration: none; color: white;" href="/admin/uploadGuru">Upload
      Excel</a></button><br><br>
    <table class="table table-bordered align-middle">
      <thead>

      <tr class="thead" style="font-weight: bold; background-color: #608BC1;">
        <td>ID Guru</td>
        <td>Nama</td>
        <td>Email</td>
        <td>Alamat</td>
        <td>No. Telp</td>
        <td>Status</td>
        <td>Action</td>
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
        <div style="display: flex; gap: 5px;">
          <button class="btn btn-primary"><a href="{{ url('/admin/editguru/' . base64_encode($g->ID_GURU)) }}"
            style="text-decoration: none; color: white;">Edit</a></button>
          <button class="btn btn-danger"><a href="{{ url('/admin/listguru/' . base64_encode($g->ID_GURU)) }}"
            style="text-decoration: none; color: white;">{{ $g->STATUS_GURU == "Active" ? "Hapus" : "Buat Aktif" }}</a></button>
        </div>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    </div>
  </div>
@endsection