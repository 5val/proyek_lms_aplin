@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
            <div>
                <a href="/admin/list_kelas"><button class="btn me-1">List</button></a>
                <a href="/admin/tambah_kelas" class="btn me-1">Tambah</a>
                <a href="/admin/upload_kelas" class="btn me-1"> Upload Kelas</a>
                <a href="/admin/upload_siswa" class="btn me-1">Upload Siswa</a>
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
                        <div class="col-md-4">
                            <label for="namaKelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="namaKelas" name="nama_kelas" value="<?= $kelas->NAMA_KELAS ?? ($kelas->detailKelas->NAMA_KELAS ?? '') ?>" maxlength="100" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="kapasitas" class="form-label fw-bold">Kapasitas (jumlah siswa)</label>
                        <input type="number" min="1" class="form-control" id="kapasitas" name="kapasitas"
                            value="<?= $kelas->KAPASITAS ?? '' ?>" required>
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
