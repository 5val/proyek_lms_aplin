<?php
// Mock data

?>

@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        <a href="/admin/tambah_pelajaran" class="btn btn-success me-1">Tambah</a>
        <h3>List Kelas</h3>

        <!-- Table -->
        <div class="container mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Pelajaran</th>
                        <th>Nama Pelajaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kelasList as $pelajaran): ?>
                    <tr class="{{ $pelajaran->STATUS == "Active" ? "" : "inactive" }}">
                        <td><?= $pelajaran->ID_PELAJARAN ?></td>
                        <td><?= $pelajaran->NAMA_PELAJARAN ?></td>
                        <td>{{ $pelajaran->STATUS == "Active" ? "Aktif" : "Inaktif" }}</td>
                        <td>
                            <div class="d-grid gap-1">
                                <a href="{{ url('/admin/list_pelajaran/' . $pelajaran->ID_PELAJARAN) }}"
                                    class="btn btn-danger btn-sm">{{ $pelajaran->status == "Active" ? "Hapus" : "Buat Aktif" }}</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection