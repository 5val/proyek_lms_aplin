<?php
// Mock data
$ruanganList = ['L-101', 'L-202', 'L-303'];
$waktuList = ['08.00 - 10.00', '10.30 - 12.30', '13.15 - 15.15', '15.45 - 17.45'];
$asistenList = ['Ovaldo', 'Ovaldo OOO', 'Rafael'];
?>
@extends('layouts.admin_app')

@section('admin_content')
  <div class="container mt-5">
    <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
    <div>
      <a href="/admin/list_kelas"><button class="btn me-1">List</button></a>
      <a href="/admin/tambah_kelas"><button class="btn btn-primary me-1">Tambah</button></a>
      <a href="/admin/upload_file" class="btn me-1"> Upload Kelas</a>

      <button class="btn">Upload Siswa</button>
    </div>
    </div>
    <h3>Tambah Kelas</h3>
    <div class="card mt-3">
    <div class="card-body">
      <form action="submit_praktikum.php" method="post">
      <div class="row mb-3">
        <div class="col-md-4">
        <label for="ruangan" class="form-label">Ruangan Praktikum</label>
        <select class="form-select" id="ruangan" name="ruangan">
          <option selected disabled>Pilih Ruangan</option>
          <?php foreach ($ruanganList as $ruang): ?>
          <option value="<?= $ruang ?>"><?= $ruang ?></option>
          <?php endforeach; ?>
        </select>
        </div>
        <div class="col-md-4">
        <label for="hari" class="form-label">Hari</label>
        <select class="form-select" id="hari" name="hari">
          <option selected disabled>Pilih Hari</option>
          <option value="Senin">Senin</option>
          <option value="Selasa">Selasa</option>
          <option value="Rabu">Rabu</option>
          <option value="Kamis">Kamis</option>
          <option value="Jumat">Jumat</option>
        </select>
        </div>
      </div>

      <div class="mb-3">
        <label for="waliKelas" class="form-label fw-bold">Wali Kelas</label>
        <select class="form-select" id="waliKelas" name="wali_kelas">
        <option selected disabled>Pilih Wali Kelas</option>
        <?php foreach ($asistenList as $asisten): ?>
        <option value="<?= $asisten ?>"><?= $asisten ?></option>
        <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-success">Submit</button>
      </form>
    </div>
    </div>
  </div>
@endsection