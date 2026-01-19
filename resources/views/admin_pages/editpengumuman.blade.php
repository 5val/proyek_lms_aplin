@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>
  <button class="btn btn-danger"><a style="text-decoration: none;">Back</a></button><br><br>
  <div class="material-box">
    <br>
    <h4 style="text-align: center;">Edit Pengumuman</h4><br>
    <form action="{{ url('/admin/editpengumuman/' . base64_encode($pengumuman->ID_PENGUMUMAN)) }}" method="POST">
    @csrf
    @method("PUT")
    <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Judul Pengumuman</label>
      <input class="form-control" type="text" name="Judul" aria-label="default input example"
      value="{{ $pengumuman->JUDUL }}">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Isi</label>
      <textarea class="form-control" type="text" name="Deskripsi"
      aria-label="default input example">{{ $pengumuman->ISI }}</textarea>
    </div>
    <div class="d-grid gap-2">
      <button class="btn btn-success" type="submit">Edit</button>
    </div>
    </form>
  </div>
@endsection