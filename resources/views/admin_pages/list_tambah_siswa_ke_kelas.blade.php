<?php
// Mock data

?>

@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        <a href="/admin/list_kelas" class="btn btn-danger">Back</a>

        <h3>List Siswa di Kelas</h3>
        <div class="card mt-3">
            <div class="card-body">
                <form action="submit_praktikum.php" method="post">
                    <div class="mb-3">
                        <label for="pengajar" class="form-label fw-bold">Guru Pengajar</label>
                        <select class="form-select" id="pengajar" name="pengajar">
                            <option selected disabled>Pilih Siswa yang mau ditambahkan</option>
                            <?php foreach ($asistenList as $asisten): ?>
                            <option value="<?= $asisten ?>"><?= $asisten ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
        <!-- Table -->
        <div class="container mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Siswa</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telpon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kelasList as $kelas):
        $siswa = $kelas->siswa ?>
                    <tr>
                        <td><?= $siswa['ID_SISWA'] ?></td>
                        <td><?= $siswa['NAMA_SISWA'] ?></td>
                        <td><?= $siswa['EMAIL_SISWA'] ?></td>
                        <td><?= $siswa['NO_TELPON_SISWA'] ?></td>
                        <td>
                            <div class="d-grid gap-1">
                                <button class="btn btn-danger btn-sm">Remove from Class</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection