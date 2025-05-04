@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <div>
    <button class="btn btn-danger"><a style="text-decoration: none;">Back</a></button><br><br>
    <div class="material-box">
    <br>
    <h4 style="text-align: center;">Edit Siswa</h4>
    <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">ID</label>
      <input class="form-control" type="text" placeholder="2200001" aria-label="default input example" readonly>
    </div>
    <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Nama lengkap</label>
      <input class="form-control" type="text" placeholder="Andi Saputra" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Email</label>
      <input class="form-control" type="text" placeholder="andi.saputra@gmail.com" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Alamat sekarang</label>
      <input class="form-control" type="text" placeholder="Jl. Pahlawan No. 10" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Nomor telepon</label>
      <input class="form-control" type="text" placeholder="081234567891" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Status</label>
      <select class="form-select" aria-label="Default select example">
      <option selected>Aktif</option>
      <option value="1">In aktif</option>
      </select>
    </div>
    <div class="d-grid gap-2">
      <button class="btn btn-success" type="button">Edit</button>
    </div>
    </div>

  </div>
@endsection