@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
            <div>
                <a href="/admin/list_kelas"><button class="btn me-1">List</button></a>
                <a href="/admin/tambah_kelas"><button class="btn btn-primary me-1">Tambah</button></a>
                <a href="/admin/upload_file" class="btn me-1"> Upload Kelas</a>
            </div>
        </div>
        <h3>Edit Kelas</h3>
        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('update_kelas', $kelas->ID_KELAS) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <label for="id-kelas" class="form-label">ID Kelas</label>
                        <input type="text" disabled name="" id="" value="<?= $kelas->ID_KELAS?>">

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ruangan" class="form-label">Ruangan Kelas</label>
                            <select class="form-select" id="ruangan" name="ruangan">
                                <option selected value="<?= $kelas->detailKelas->ID_DETAIL_KELAS ?>">
                                    <?= $kelas->detailKelas->RUANGAN_KELAS ?>
                                </option>

                                <?php foreach ($availableRooms as $ruang): ?>
                                <option value="<?= $ruang->ID_DETAIL_KELAS ?>"><?= $ruang->RUANGAN_KELAS ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="waliKelas" class="form-label fw-bold">Wali Kelas</label>
                        <select class="form-select" id="waliKelas" name="wali_kelas">
                            <option selected value="<?= $kelas->wali->ID_GURU ?>">
                                <?= $kelas->wali->NAMA_GURU ?>
                            </option>
                            <?php foreach ($availableGuru as $guru): ?>
                            <option value="<?= $guru->ID_GURU ?>"><?= $guru->NAMA_GURU ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection