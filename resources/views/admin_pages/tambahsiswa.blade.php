@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <button class="btn btn-danger"><a style="text-decoration: none;" href="/admin/listsiswa">Back</a></button><br><br>
  <br>
  <h4 style="text-align: center;">Tambah Siswa</h4><br>
  <form action="/admin/tambahsiswa" method="POST">
    @csrf
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Nama lengkap</label>
    <input class="form-control" type="text" name="nama" placeholder="Default input" aria-label="default input example"
      required>
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Email</label>
    <input class="form-control" type="email" name="email" placeholder="Default input" aria-label="default input example"
      required>
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Alamat sekarang</label>
    <input class="form-control" type="text" name="alamat" placeholder="Default input" aria-label="default input example"
      required>
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Nomor telepon</label>
    <input class="form-control" type="text" name="telp" placeholder="Default input" aria-label="default input example"
      required>
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Status</label>
    <select class="form-select" aria-label="Default select example" name="status">
      <option selected value="Active">Aktif</option>
      <option value="inactive">Inaktif</option>
    </select>
    </div>
    <div class="d-grid gap-2">
    <button class="btn btn-success" type="submit">Tambah</button>
    </div>
  </form>
  </div>
@endsection