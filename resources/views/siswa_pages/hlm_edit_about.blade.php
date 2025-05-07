@extends('layouts.siswa_app')

@section('siswa_content')
<div class="content-box mt-4">
            <h3>Edit Biodata</h3> <br>
            <form>
            <div class="mb-3">
               <label for="nama" class="form-label">Nama Lengkap</label>
               <input type="text" class="form-control" id="nama" value="JESSICA NATALIE">
            </div>

            <div class="mb-3">
               <label for="email" class="form-label">Email</label>
               <input type="email" class="form-control" id="email" value="jessicacondro@gmail.com">
            </div>

            <div class="mb-3">
               <label for="alamat" class="form-label">Alamat</label>
               <textarea class="form-control" id="alamat" rows="2">Jl. Yang Sangat Indah No. 1</textarea>
            </div>

            <div class="mb-3">
               <label for="telepon" class="form-label">Nomor Telepon</label>
               <input type="text" class="form-control" id="telepon" value="08123456789">
            </div>

            <div class="mb-3">
               <label for="password" class="form-label">Password</label>
               <input type="password" class="form-control" id="password" placeholder="********">
            </div>

            <div class="d-flex justify-content-end">
               <button type="submit" class="btn btn-primary me-2" onclick="window.location.href='/siswa/hlm_about'">Simpan Perubahan</button>
               <button type="reset" class="btn btn-danger" onclick="window.location.href='/siswa/hlm_about'">Batal</button>
            </div>
            </form>
         </div>
@endsection