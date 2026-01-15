@extends('layouts.admin_app')

@section('admin_content')
  <div class="container mt-5">
    <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
    <div>
      <a href="/admin/list_kelas"><button class="btn me-1">List</button></a>
      <a href="/admin/tambah_kelas"><button class="btn btn-primary me-1">Tambah</button></a>
      <a href="/admin/upload_kelas" class="btn me-1"> Upload Kelas</a>
      <a href="/admin/upload_siswa_ke_kelas" class="btn me-1">Upload Siswa</a>

    </div>
    </div>
    <h3>Tambah Kelas</h3>
    <div class="card mt-3">
    <div class="card-body">
      <form action="{{ route('add_kelas') }}" method="post">
      @csrf
      <div class="row mb-3">
        <div class="col-md-4">
        <label for="ruangan" class="form-label">Ruangan Kelas</label>
        <select class="form-select" id="ruangan" name="ruangan">
          <option selected disabled>Pilih Ruangan</option>
          <?php foreach ($availableRooms as $ruang): ?>
          <option value="<?= $ruang->ID_DETAIL_KELAS ?>"><?= $ruang->RUANGAN_KELAS ?></option>
          <?php endforeach; ?>
        </select>
        </div>
        <div class="col-md-4">
          <label for="namaKelas" class="form-label">Nama Kelas</label>
          <input type="text" class="form-control" id="namaKelas" name="nama_kelas" placeholder="Contoh: Kelas 6A" maxlength="100" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="kapasitas" class="form-label fw-bold">Kapasitas (jumlah siswa)</label>
        <input type="number" min="1" class="form-control" id="kapasitas" name="kapasitas" placeholder="Contoh: 30" required>
      </div>

      <div class="mb-3">
        <label for="waliKelas" class="form-label fw-bold">Wali Kelas</label>
        <select class="form-select" id="waliKelas" name="wali_kelas">
        <option selected disabled>Pilih Wali Kelas</option>
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
