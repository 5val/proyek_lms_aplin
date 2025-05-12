@extends('layouts.siswa_app')

@section('siswa_content')
<div class="content-box mt-4">
    <div class="row align-items-center mb-4">
        <div class="col-auto">
            <img src="../asset/default_img.png" alt="Avatar" class="rounded-circle" width="100" height="100">
        </div>
        <div class="col">
            <h4 class="mb-1">{{ $siswa->NAMA_SISWA }}</h4>
            <p class="mb-0">{{ $siswa->ID_SISWA }}</p>
            <p class="mb-0">{{ $kelasInfo->NAMA_KELAS }}</p> <!-- Menampilkan nama kelas dari kelasInfo -->
        </div>
        <div class="col-auto">
            <button class="btn btn-primary me-2" onclick="window.location.href='/siswa/hlm_edit_about'">Edit Biodata</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h5 class="mb-3">Biodata</h5>
            <table class="table table-borderless">
                <tr><th>Email</th><td>{{ $siswa->EMAIL_SISWA }}</td></tr>
                <tr><th>Alamat</th><td>{{ $siswa->ALAMAT_SISWA }}</td></tr>
                <tr><th>No. Telepon</th><td>{{ $siswa->NO_TELPON_SISWA }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection