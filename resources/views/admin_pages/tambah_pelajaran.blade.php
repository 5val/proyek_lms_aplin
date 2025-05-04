<?php
// Mock data
$mataKuliahList = ['Sistem Digital', 'Algoritma dan Pemrograman', 'Basis Data'];
$ruanganList = ['L-101', 'L-202', 'L-303'];
$waktuList = ['08.00 - 10.00', '10.30 - 12.30', '13.15 - 15.15', '15.45 - 17.45'];
$asistenList = ['Josephine Dermawan', 'Febrian Alexandro', 'Michael Wijaya'];
?>

@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
            <div>
                <a href="/admin/list_pelajaran"><button class="btn me-1">List</button></a>
                <a href="/admin/tambah_pelajaran"><button class="btn btn-primary me-1">Tambah</button></a>
            </div>
        </div>
        <h3>Tambah Pelajaran</h3>
        <div class="card mt-3">
            <div class="card-body">
                <form action="submit_praktikum.php" method="post">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id" class="form-label">ID Pelajaran</label>
                            <input type="text" class="form-control" id="inputID" placeholder="ID Pelajaran">
                        </div>
                        <div class="col-md-4">
                            <label for="nama" class="form-label">Nama Pelajaran</label>
                            <input type="text" class="form-control" id="namaPelajaran" placeholder="Nama Pelajaran">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection