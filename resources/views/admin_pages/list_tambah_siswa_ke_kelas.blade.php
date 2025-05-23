<?php
// Mock data

?>

@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        <a href="/admin/list_kelas" class="btn btn-danger">Back</a>
        <div hidden id="idKelas"><?=$id_kelas?></div>

        <h3>List Siswa di Kelas</h3>
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
                <tbody id="enrolledSiswa">
                    <?php foreach ($kelasList as $kelas):
        $siswa = $kelas->siswa ?>
                    <tr>
                        <td><?= $siswa['ID_SISWA'] ?></td>
                        <td><?= $siswa['NAMA_SISWA'] ?></td>
                        <td><?= $siswa['EMAIL_SISWA'] ?></td>
                        <td><?= $siswa['NO_TELPON_SISWA'] ?></td>
                        <td>
                            <div class="d-grid gap-1">
                                <a class="btn btn-danger btn-sm delete_siswa" data-id="<?= $siswa['ID_SISWA'] ?>">Remove
                                    from Class</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <hr>
        <h3>Tambah Siswa</h3>
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
                <tbody id="unenrolledSiswa">
                    <?php foreach ($siswaList as $siswa): ?>
                    <tr>
                        <td><?= $siswa['ID_SISWA'] ?></td>
                        <td><?= $siswa['NAMA_SISWA'] ?></td>
                        <td><?= $siswa['EMAIL_SISWA'] ?></td>
                        <td><?= $siswa['NO_TELPON_SISWA'] ?></td>
                        <td>
                            <div class="d-grid gap-1">
                                <a class="btn btn-primary btn-sm tambah_siswa" data-id="<?= $siswa['ID_SISWA'] ?>">Add to
                                    Class</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            const idkelas = $('#idKelas').text();


            $('body').on('click', '.tambah_siswa', function () {
                const idSiswa = $(this).data('id');
                if (confirm('Tambahkan siswa ' + idSiswa + ' ke kelas?')) {
                    // const safeId = classId.replace(/\//g, '__');
                    $.ajax({
                        url: '/admin/tambah_siswa_ke_kelas',  // Add
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            idSiswa: idSiswa,
                            idKelas: idkelas,
                            // Add CSRF token for security
                        },
                        success: function (response) {
                            alert(response.message);
                            loadEnrolledSiswa(idkelas)
                            loadUnenrolledSiswa(idkelas)
                        },
                        error: function (xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
            $('body').on('click', '.delete_siswa', function () {
                const idSiswa = $(this).data('id');
                if (confirm('Hapus siswa ' + idSiswa + ' dari kelas?')) {
                    // const safeId = classId.replace(/\//g, '__');
                    $.ajax({
                        url: '/admin/remove_siswa_dari_kelas',  // Add
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            idSiswa: idSiswa,
                            idKelas: idkelas,
                            // Add CSRF token for security
                        },
                        success: function (response) {
                            alert(response.message);
                            loadEnrolledSiswa(idkelas)
                            loadUnenrolledSiswa(idkelas)
                        },
                        error: function (xhr) {
                            alert('Error : ' + xhr.responseJSON.message);
                        }
                    });
                }
            });

            function loadEnrolledSiswa(kelasId) {
                $.ajax({
                    url: '/admin/get_list_siswa_di_kelas/' + kelasId,
                    type: 'GET',
                    success: function (data) {
                        let rows = '';
                        console.log(data);
                        data.forEach(function (kelas) {
                            siswa = kelas.siswa
                            rows += `
                                                <tr>
                                                    <td>${siswa.ID_SISWA}</td>
                                                    <td>${siswa.NAMA_SISWA}</td>
                                                    <td>${siswa.EMAIL_SISWA}</td>
                                                    <td>${siswa.NO_TELPON_SISWA}</td>
                                                    <td>
                                                        <div class="d-grid gap-1">
                                                            <a class="btn btn-danger btn-sm delete_siswa" data-id="${siswa.ID_SISWA}">Remove from Class</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                `;
                        });
                        $('#enrolledSiswa').html(rows);


                    },
                    error: function (xhr) {
                        console.error('Failed to load kelas:', xhr.responseText);
                    }
                });
            }
            function loadUnenrolledSiswa(kelasId) {
                $.ajax({
                    url: '/admin/get_list_siswa_available/' + kelasId,
                    type: 'GET',
                    success: function (data) {
                        let rows = '';
                        data.forEach(function (siswa) {
                            rows += `
                                <tr>
                                    <td>${siswa.ID_SISWA}</td>
                                    <td>${siswa.NAMA_SISWA}</td>
                                    <td>${siswa.EMAIL_SISWA}</td>
                                    <td>${siswa.NO_TELPON_SISWA}</td>
                                    <td>
                                        <div class="d-grid gap-1">
                                            <a class="btn btn-primary btn-sm tambah_siswa" data-id="${siswa.ID_SISWA}">Add to Class</a>
                                        </div>
                                    </td>
                                </tr>
                                `;
                        });
                        $('#unenrolledSiswa').html(rows);
                    },
                    error: function (xhr) {
                        console.error('Failed to load kelas:', xhr.responseText);
                    }
                });
            }
            loadEnrolledSiswa(idkelas)
            loadUnenrolledSiswa(idkelas)
        })
    </script>
@endsection