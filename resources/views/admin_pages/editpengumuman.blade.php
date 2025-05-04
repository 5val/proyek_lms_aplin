@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>
  <button class="btn btn-danger"><a style="text-decoration: none;">Back</a></button><br><br>
  <div class="material-box">
    <br>
    <h4 style="text-align: center;">Edit Pengumuman</h4><br>
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">ID</label>
    <input class="form-control" type="text" placeholder="P0001" aria-label="default input example">
    </div>
    <div class="mb-3">
    <label for="exampleFormControlInput1" class="form-label">Judul Pengumuman</label>
    <input class="form-control" type="text" placeholder="Perubahan Jadwal UTS" aria-label="default input example">
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Isi</label>
    <textarea class="form-control" type="text" placeholder="UTS akan ditiadakan pada 20 April"
      aria-label="default input example"></textarea>
    </div>
    <div class="mb-3">
    <label for="exampleFormControlTextarea1" class="form-label">Tanggal</label>
    <input class="form-control" type="text" placeholder="20/04/25" aria-label="default input example">
    </div>
    <div class="d-grid gap-2">
    <button class="btn btn-success" type="button">Edit</button>
    </div>
  </div>
@endsection