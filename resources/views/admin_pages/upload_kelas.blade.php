@extends('layouts.admin_app')

@section('admin_content')
    <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
        <div>
            <a href="/admin/list_kelas"><button class="btn me-1">List</button></a>
            <a href="/admin/tambah_kelas"><button class="btn  me-1">Tambah</button></a>
            <a href="/admin/upload_kelas" class="btn btn-primary me-1"> Upload Kelas</a>
            <a href="/admin/upload_siswa" class="btn me-1">Upload Siswa</a>
        </div>
    </div>

    <div class="container mt-3">
        <!-- Download Soal -->
        <div class="card-custom mb-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Template Excel</h4>
            <button class="btn btn-outline-primary">Download</button>
        </div>

        <div class="row">

            <!-- Tugas Section -->
            <div class="col-md-6">
                <div class="card-custom">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Tempat upload</h5>
                    </div>
                    <div class="dropzone mb-3">
                        <div style="font-size: 2rem;">📁</div>
                        <p class="mb-0">Drag File Here</p>
                    </div>
                    <button class="btn btn-primary w-100 mb-2">Send</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection