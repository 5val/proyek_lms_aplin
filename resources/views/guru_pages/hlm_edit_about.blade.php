@extends('layouts.guru_app')

@section('guru_content')
<div class="content-box mt-4">
            <h3>Edit Biodata</h3> <br>
            <form action="{{ route('guru.update_biodata') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
               <label for="nama" class="form-label">Nama Lengkap</label>
               <input type="text" class="form-control" id="nama" name="NAMA_GURU" value="{{ old('NAMA_GURU', $guru->NAMA_GURU) }}">
            </div>

            <div class="mb-3">
               <label for="email" class="form-label">Email</label>
               <input type="email" class="form-control" id="email" name="EMAIL_GURU" value="{{ old('EMAIL_GURU', $guru->EMAIL_GURU) }}">
            </div>

            <div class="mb-3">
               <label for="alamat" class="form-label">Alamat</label>
               <textarea class="form-control" id="alamat" rows="2" name="ALAMAT_GURU">{{ old('ALAMAT_GURU', $guru->ALAMAT_GURU) }}</textarea>
            </div>

            <div class="mb-3">
               <label for="telepon" class="form-label">Nomor Telepon</label>
               <input type="text" class="form-control" id="telepon" name="NO_TELPON_GURU" value="{{ old('NO_TELPON_GURU', $guru->NO_TELPON_GURU) }}">
            </div>

            <div class="mb-3">
               <label for="password" class="form-label">Password</label>
               <input type="password" class="form-control" id="password" name="PASSWORD_GURU" value="{{ old('PASSWORD_GURU', $guru->PASSWORD_GURU) }}">
            </div>

            <div class="d-flex justify-content-end">
               <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
               <a href="{{ route('guru.hlm_about') }}" class="btn btn-danger">Batal</a>
            </div>
            </form>
         </div>
@endsection