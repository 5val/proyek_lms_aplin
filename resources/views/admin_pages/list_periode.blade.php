@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
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
        <a href="/admin/add_periode" class="btn btn-success me-1">Tambah</a>
        <h3>List Periode</h3>
        <div class="container mt-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Periode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($periodeList as $periode): ?>
                    <tr>
                        <td><?= $periode->PERIODE ?></td>
                        <td>
                            <a class="btn btn-danger" href="/admin/delete_periode/<?=$periode->ID_PERIODE?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection