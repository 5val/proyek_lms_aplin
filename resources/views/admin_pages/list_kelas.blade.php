@extends('layouts.admin_app')

@section('admin_content')
  <div class="container mt-5">
    <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
    <div>
      <button class="btn btn-primary me-1">List</button>
      <a href="/admin/tambah_kelas" class="btn me-1">Tambah</a>
      <a href="/admin/upload_file" class="btn me-1"> Upload Kelas</a>
      <button class="btn">Upload Siswa</button>
    </div>
    <div>
      <select class="form-select" style="width: 250px;">
      <?php foreach ($semesters as $semester): ?>
      <option><?= $semester ?></option>
      <?php endforeach; ?>
      </select>
    </div>
    </div>
    <h3>List Kelas</h3>

    <!-- Table -->
    <div class="container mt-4">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
      <tr>
        <th>Kode Kelas</th>
        <th>Wali Kelas</th>
        <th>Ruangan</th>
        <th>Aksi</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($kelasList as $kelas): ?>
      <tr>
        <td><?= $kelas['id_kelas'] ?></td>
        <td><?= $kelas['nama_wali'] ?></td>
        <td><?= $kelas['ruangan'] ?></td>
        <td>
        <div class="d-grid gap-1">
          <a href="/admin/list_mata_pelajaran" class="btn btn-primary btn-sm">Detail Kelas</a>
          <a href="/admin/list_tambah_siswa_ke_kelas" class="btn btn-primary btn-sm">List Siswa</a>
          <button class="btn btn-primary btn-sm">Edit</button>
          <button class="btn btn-danger btn-sm">Delete</button>
        </div>
        </td>
      </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    </div>
  </div>
@endsection