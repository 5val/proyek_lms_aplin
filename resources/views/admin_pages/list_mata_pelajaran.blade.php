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
                        <td class="id_mapel"><?= $pelajaran->ID_MATA_PELAJARAN?></td>
                        <td class="nama_mapel"><?= $pelajaran->pelajaran->NAMA_PELAJARAN ?></td>
                        <td class="nama_guru"><?= $pelajaran->guru->NAMA_GURU ?></td>
                        <td class="hari_pelajaran"><?= $pelajaran->HARI_PELAJARAN ?></td>
                        <td class="jam_pelajaran"><?= $pelajaran->JAM_PELAJARAN?></td>
                        <td>
                            <div class="d-grid gap-1">
                                <button class="btn btn-primary btn-sm">List Pertemuan</button>
                                <button class="btn btn-primary btn-sm edit-mapel">Edit</button>
                                <button class="btn btn-danger btn-sm delete-mapel">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            const idKelas = $('#idKelas').val();
            $('#formMapel').attr('action', '/admin/list_mata_pelajaran/' + idKelas);

            $('body').on('click', '.edit-mapel', function () {
                var $currentRow = $(this).closest('tr');
                var guruNameToEdit = $currentRow.find('.nama_guru').text().trim();
                var idMapelToEdit = $currentRow.find('.id_mapel').text().trim();
                var mapelNameToEdit = $currentRow.find('.nama_mapel').text().trim();
                var hariPelajaranToEdit = $currentRow.find('.hari_pelajaran').text().trim();
                var jamPelajaranToEdit = $currentRow.find('.jam_pelajaran').text().trim();
                $('#formMapel').attr('action', '/admin/update_mata_pelajaran/' + idMapelToEdit);

                if (guruNameToEdit) {
                    $('#pengajar option').filter(function () {
                        return $(this).text().trim() === guruNameToEdit;
                    }).prop('selected', true);
                    $('#pengajar').trigger('change');
                }
                if (idMapelToEdit) {
                    $('#idMapel').val(idMapelToEdit);
                    $('#pengajar').trigger('change');
                }
                if (mapelNameToEdit) {
                    $('#pelajaran option').filter(function () {
                        return $(this).text().trim() === mapelNameToEdit;
                    }).prop('selected', true);
                    $('#pelajaran').trigger('change');
                }
                if (hariPelajaranToEdit) {
                    $('#hari option').filter(function () {
                        return $(this).text().trim() === hariPelajaranToEdit
                    }).prop('selected', true);
                    $('#hari').trigger('change');
                }
                if (jamPelajaranToEdit) {
                    $('#waktu option').filter(function () {
                        return $(this).text().trim() === jamPelajaranToEdit;
                    }).prop('selected', true);
                    $('#waktu').trigger('change');
                }
                $('#submitBTN').text('Edit')
            })
            $('#formMapel').on('submit', function () {
                $('#submitBTN').text('Submit')
            })
            $('body').on('click', '.delete-mapel', function () {
                var currentRow = $(this).closest('tr');
                var idMapelToEdit = currentRow.find('.id_mapel').text().trim();
                delete_mapel(idMapelToEdit)

            })
            function delete_mapel(id_mapel) {
                $.ajax({
                    url: '/admin/delete_mata_pelajaran/' + id_mapel,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        kelas: idKelas
                    },
                    success: function (response) {
                        alert(response.message)
                        window.location.href = '/admin/list_mata_pelajaran/' + idKelas
                    },
                    error: function (response) {
                        alert(response.message)
                    }
                })
            }
        })
    </script>
@endsection