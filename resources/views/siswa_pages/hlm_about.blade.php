@extends('layouts.siswa_app')

@section('siswa_content')
<div class="content-box mt-4">
            <div class="row align-items-center mb-4">
               <div class="col-auto">
                 <img src="../asset/default_img.png" alt="Avatar" class="rounded-circle" width="100" height="100">
               </div>
               <div class="col">
                  <h4 class="mb-1">JESSICA NATALIE</h4>
                  <p class="mb-0">220/0001</p>
                  <p class="mb-0">XII IPA 1</p>
               </div>
               <div class="col-auto">
                 <button class="btn btn-primary me-2" onclick="window.location.href='/siswa/hlm_edit_about'">Edit Biodata</button>
               </div>
             </div>

            <div class="row">
            <div class="col-md-6">
               <h5 class="mb-3">Biodata</h5>
               <table class="table table-borderless">
                  <tr><th>Email</th><td>jessicacondro@gmail.com</td></tr>
                  <tr><th>Alamat</th><td>Jl. Yang Sangat Indah No. 1</td></tr>
                  <tr><th>No. Telepon</th><td>08123456789</td></tr>
               </table>
            </div>
            </div>
         </div>
@endsection