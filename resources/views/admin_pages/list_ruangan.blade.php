@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-2">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @include('admin_pages.tambah_ruangan')
        <h3 class="mt-3">List Ruangan</h3>
        <div class="container mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Ruangan</th>
                        <th>Nama Ruangan</th>
                        <th>Nama Kelas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ruanganList as $ruangan): ?>
                    <tr>
                        <td class="id_ruangan"><?= $ruangan->ID_DETAIL_KELAS ?></td>
                        <td class="ruangan_kelas"><?= $ruangan->RUANGAN_KELAS ?></td>
                        <td class="nama_kelas"><?= $ruangan->NAMA_KELAS ?></td>
                        <td>
                            <a class="btn btn-primary edit_btn" data-id="<?=$ruangan->ID_DETAIL_KELAS?>">Edit</a>
                            <a class="btn btn-danger" href="/admin/delete_ruangan/<?=$ruangan->ID_DETAIL_KELAS?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#formMapel').attr('action', '/admin/list_ruangan');
            $('body').on('click', '.edit_btn', function () {
                var $currentRow = $(this).closest('tr');
                var idRuangan = $currentRow.find('.id_ruangan').text().trim();
                var ruanganKelas = $currentRow.find('.ruangan_kelas').text().trim();
                var namaKelas = $currentRow.find('.nama_kelas').text().trim();
                $('#formMapel').attr('action', '/admin/edit_ruangan');
                if (idRuangan) {
                    $('#id_ruangan').val(idRuangan)

                }
                if (ruanganKelas) {
                    $('#nama_ruangan').prop('readonly', true)
                    $('#nama_ruangan').val(ruanganKelas)
                }
                if (namaKelas) {
                    $('#nama_kelas').val(namaKelas)
                }
            })

        })
    </script>
@endsection