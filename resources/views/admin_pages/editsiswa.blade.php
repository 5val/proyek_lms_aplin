@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <div>
    <a class="btn btn-danger" style="text-decoration: none;" href="/admin/listsiswa">Back</a><br><br>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="material-box">
    <br>
    <h4 style="text-align: center;">Edit Siswa</h4><br>
    <form action="{{ url('/admin/editsiswa/' . base64_encode($siswa->ID_SISWA)) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">ID</label>
      <input class="form-control" type="text" name="id" placeholder="G001" aria-label="default input example" readonly
        value="{{ $siswa->ID_SISWA }}">
      </div>
      <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Nama lengkap</label>
      <input class="form-control" type="text" name="nama" placeholder="Daniel" aria-label="default input example"
        value="{{ $siswa->NAMA_SISWA }}" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Email</label>
      <input class="form-control" type="email" name="email" placeholder="daniel@gmail.com"
        aria-label="default input example" value="{{ $siswa->EMAIL_SISWA }}" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Email Orang Tua</label>
      <input class="form-control" type="email" name="email_orangtua" placeholder="ortu@gmail.com"
        aria-label="default input example" value="{{ $siswa->EMAIL_ORANGTUA }}">
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Alamat sekarang</label>
      <input class="form-control" type="text" name="alamat" placeholder="Jl. Merdeka No. 10"
        aria-label="default input example" value="{{ $siswa->ALAMAT_SISWA }}" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Nomor telepon</label>
      <input class="form-control" type="text" name="telp" placeholder="081234567891"
        aria-label="default input example" value="{{ $siswa->NO_TELPON_SISWA }}" required>
      </div>
      <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Status</label>
      <select class="form-select" name="status" aria-label="Default select example" requireds>
        <option value="Inactive" {{ $siswa->STATUS_SISWA == "Inactive" ? 'selected' : '' }}>In aktif</option>
        <option value="Active" {{ $siswa->STATUS_SISWA == "Active" ? 'selected' : '' }}>Aktif</option>
      </select>
      </div>
      <div class="d-grid gap-2">
      <button class="btn btn-success" type="submit">Edit</button>
      </div>
    </form>
    </div>
  @endsection
