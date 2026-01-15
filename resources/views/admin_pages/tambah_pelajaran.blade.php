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
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <div class="card mt-3">
            <div class="card-body">
                <form action="/admin/tambah_pelajaran" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="namaPelajaran" class="form-label">Nama Pelajaran</label>
                            <input type="text" class="form-control" id="namaPelajaran" name="name"
                                placeholder="Nama Pelajaran" required>
                        </div>
                        <div class="col-md-4">
                            <label for="classLevel" class="form-label">Tingkat/Kelas</label>
                            <input type="text" class="form-control" id="classLevel" name="class_level"
                                placeholder="contoh: Kelas 6 atau X IPA" maxlength="50" required>
                            <small class="text-muted">Digunakan untuk memetakan jadwal per kelas.</small>
                        </div>
                        <div class="col-md-4">
                            <label for="requiredHours" class="form-label">Jumlah Jam Wajib per Minggu</label>
                            <input type="number" class="form-control" id="requiredHours" name="required_hours"
                                placeholder="contoh: 5" min="0" max="40" required>
                            <small class="text-muted">Digunakan untuk penjadwalan agar jam wajib terpenuhi.</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
