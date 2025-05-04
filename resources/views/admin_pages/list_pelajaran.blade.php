<?php
// Mock data

?>

@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
            <div>
                <a href="/admin/list_pelajaran" class="btn btn-primary me-1">List</a>
                <a href="/admin/tambah_pelajaran" class="btn me-1">Tambah</a>
            </div>
        </div>
        <h3>List Kelas</h3>

        <!-- Table -->
        <div class="container mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Pelajaran</th>
                        <th>Nama Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kelasList as $kelas): ?>
                    <tr>
                        <td><?= $kelas['id_pelajaran'] ?></td>
                        <td><?= $kelas['nama_pelajaran'] ?></td>
                        <td>
                            <div class="d-grid gap-1">
                                <button class="btn btn-primary btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection