@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <button class="btn btn-danger"><a style="text-decoration: none; color: white;" href="/admin/listguru">Back</a></button><br><br>
  <div class="material-box">
    <br>
    <h4 style="text-align: center;">Edit Guru</h4><br>
    <form action="{{ url('/admin/editguru/' . urlencode($guru->ID_GURU)) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">ID</label>
      <input class="form-control" type="text" name="id" placeholder="G001" aria-label="default input example" readonly value="{{ $guru->ID_GURU }}">
      </div>
      <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Nama lengkap</label>
      <input class="form-control" type="text" name="nama" placeholder="Daniel" aria-label="default input example" value="{{ $guru->NAMA_GURU }}" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Email</label>
      <input class="form-control" type="email" name="email" placeholder="daniel@gmail.com" aria-label="default input example" value="{{ $guru->EMAIL_GURU }}" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Alamat sekarang</label>
      <input class="form-control" type="text" name="alamat" placeholder="Jl. Merdeka No. 10" aria-label="default input example" value="{{ $guru->ALAMAT_GURU }}" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Nomor telepon</label>
      <input class="form-control" type="text" name="telp" placeholder="081234567891" aria-label="default input example" value="{{ $guru->NO_TELPON_GURU }}" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Status</label>
      <select class="form-select" name="status" aria-label="Default select example" requireds>
         <option value="Inactive" {{ $guru->STATUS_GURU == "Inactive" ? 'selected' : '' }}>In aktif</option>
         <option value="Active" {{ $guru->STATUS_GURU == "Active" ? 'selected' : '' }}>Aktif</option>
      </select>
      </div>
      <div class="d-grid gap-2">
      <button class="btn btn-success" type="submit">Edit</button>
      </div>
    </form>
  </div>
@endsection