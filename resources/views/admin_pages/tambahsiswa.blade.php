@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <button class="btn btn-danger"><a style="text-decoration: none;">Back</a></button><br><br>
  <div class="material-box">
    <br>
    <h4 style="text-align: center;">Tambah Siswa</h4><br>
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Nama lengkap</label>
    <input class="form-control" type="text" placeholder="Default input" aria-label="default input example">
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Email</label>
    <input class="form-control" type="text" placeholder="Default input" aria-label="default input example">
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Alamat sekarang</label>
    <input class="form-control" type="text" placeholder="Default input" aria-label="default input example">
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Nomor telepon</label>
    <input class="form-control" type="text" placeholder="Default input" aria-label="default input example">
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Status</label>
    <select class="form-select" aria-label="Default select example">
      <option selected>In aktif</option>
      <option value="1">Aktif</option>
    </select>
    </div>
    <div class="d-grid gap-2">
    <button class="btn btn-success" type="button">Tambah</button>
    </div>
  </div>
@endsection