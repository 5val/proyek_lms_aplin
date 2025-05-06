@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>
  <button class="btn btn-danger"><a style="text-decoration: none; color: white;" href="/admin/listguru">Back</a></button><br><br>
  <div class="material-box">
    <br>
    <h4 style="text-align: center;">Tambah Guru</h4><br>
    <form action="/admin/tambahguru" method="POST">
      @csrf
      <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Nama lengkap</label>
      <input class="form-control" type="text" name="nama" aria-label="default input example" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Email</label>
      <input class="form-control" type="text" name="email" aria-label="default input example" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Password</label>
      <input class="form-control" type="text" name="password" aria-label="default input example" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Alamat sekarang</label>
      <input class="form-control" type="text" name="alamat" aria-label="default input example" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Nomor telepon</label>
      <input class="form-control" type="text" name="telp" aria-label="default input example" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Status</label>
      <select class="form-select" aria-label="Default select example" name="status" required>
         <option selected>In aktif</option>
         <option value="1">Aktif</option>
      </select>
      </div>
      <div class="d-grid gap-2">
      <button class="btn btn-success" type="submit">Tambah</button>
      </div>
    </form>
  </div>
@endsection