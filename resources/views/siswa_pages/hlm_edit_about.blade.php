@extends('layouts.siswa_app')

@section('siswa_content')
<div class="content-box mt-4">
    <h3>Edit Biodata</h3> <br>
    <form action="{{ route('siswa.update_biodata') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $siswa->NAMA_SISWA) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $siswa->EMAIL_SISWA) }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ old('alamat', $siswa->ALAMAT_SISWA) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $siswa->NO_TELPON_SISWA) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="********" value="{{ old('password') }}">
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
            <a href="{{ route('siswa.hlm_about') }}" class="btn btn-danger">Batal</a>
        </div>
    </form>
</div>
@endsection