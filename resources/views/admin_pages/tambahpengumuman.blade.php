@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>
  <button class="btn btn-danger"><a style="text-decoration: none;">Back</a></button><br><br>
  <div class="material-box">
    <br>
    <h4 style="text-align: center;">Tambah Pengumuman</h4><br>
    <div class="mb-3">
    <form action="/admin/tambahpengumuman" method="POST">
      @csrf
      <label for="exampleFormControlInput1" class="form-label">Judul Pengumuman</label>
      <input class="form-control" type="text" name="Judul" placeholder="Default input"
      aria-label="default input example">
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Isi</label>
    <textarea class="form-control" type="text" name="Deskripsi" placeholder="Default input"
      aria-label="default input example"></textarea>
    </div>
    <div class="d-grid gap-2">
    <button class="btn btn-success" type="submit">Tambah</button>
    </div>
    </form>
  </div>
  </div>
@endsection