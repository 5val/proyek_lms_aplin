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
        <a href="/admin/list_pelajaran"><button class="btn btn-danger me-1">Back</button></a>

        <h3>Tambah Pelajaran</h3>
        @if ($errors->has('name'))
            <div class="alert alert-danger">
                {{ $errors->first('name') }}
            </div>
        @endif
        <div class="card mt-3">
            <div class="card-body">
                <form action="/admin/tambah_pelajaran" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama" class="form-label">Nama Pelajaran</label>
                            <input type="text" class="form-control" id="namaPelajaran" name="name"
                                placeholder="Nama Pelajaran">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection