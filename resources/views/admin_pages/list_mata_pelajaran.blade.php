@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-2">
        <a href="/admin/list_kelas" class="btn btn-danger">Back</a>
        @include('admin_pages.tambah_mata_pelajaran')

        <!-- Table -->
        <div class="container mt-5">
            <hr>
            <h3>List Mata Pelajaran</h3>
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode Mata Pelajaran</th>
                        <th>Pelajaran</th>
                        <th>Pengajar</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kelasList as $pelajaran): ?>
                    <tr>
                        <td><?= $pelajaran->ID_MATA_PELAJARAN?></td>
                        <td><?= $pelajaran->pelajaran->NAMA_PELAJARAN ?></td>
                        <td><?= $pelajaran->guru->NAMA_GURU ?></td>
                        <td><?= $pelajaran->HARI_PELAJARAN ?></td>
                        <td><?= $pelajaran->JAM_PELAJARAN?></td>
                        <td>
                            <div class="d-grid gap-1">
                                <button class="btn btn-primary btn-sm">List Pertemuan</button>
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