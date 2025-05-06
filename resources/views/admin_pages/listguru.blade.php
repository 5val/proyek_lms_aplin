@extends('layouts.admin_app')

@section('admin_content')
  <div class="p-3">
    <div class="row g-4 mb-4">

    </div>

    <div>
    <h4>List Guru</h4><br>
    <button class="btn btn-success"><a style="text-decoration: none; color: white;" href="/admin/tambahguru">Tambah
      Guru</a></button><br><br>
    <table class="table table-bordered align-middle">
      <thead>

      <tr class="thead" style="font-weight: bold; background-color: #608BC1;">
        <td>ID Guru</td>
        <td>Nama</td>
        <td>Email</td>
        <td>Alamat</td>
        <td>No. Telp</td>
        <td>Status</td>
        <td>Action</td>
      </tr>
      </thead>
      <tbody>
      <tbody>
         <?php foreach ($allGuru as $g): ?>
            <tr class="{{ $g->STATUS_GURU == "Active" ? "" : "inactive" }}">
              <td>{{ $g->ID_GURU }}</td>
              <td>{{ $g->NAMA_GURU }}</td>
              <td>{{ $g->EMAIL_GURU }}</td>
              <td>{{ $g->ALAMAT_GURU }}</td>
              <td>{{ $g->NO_TELPON_GURU }}</td>
              <td>{{ $g->STATUS_GURU == "Active" ? "Aktif" : "In aktif" }}</td>
              <td>
              <div style="display: flex; gap: 5px;">
                <button class="btn btn-primary"><a href="{{ url('/admin/editguru/' . urlencode($g->ID_GURU)) }}"
                  style="text-decoration: none; color: white;">Edit</a></button>
                <button class="btn btn-danger"><a href="{{ url('/admin/listguru/' . urlencode($g->ID_GURU)) }}"
                style="text-decoration: none; color: white;">{{ $g->STATUS_GURU == "Active" ? "Hapus" : "Buat Aktif" }}</a></button>
              </div>
              </td>
            </tr>
         <?php endforeach; ?>
      <!-- <tr>
        <td>G002</td>
        <td>Samantha</td>
        <td>samantha@gmail.com</td>
        <td>Jl. Kenari No. 3</td>
        <td>082345678912</td>
        <td>Aktif</td>
        <td>
        <div style="display: flex; gap: 5px; ">
          <button class="btn btn-primary">Edit</button>
          <button class="btn btn-danger">Hapus</button>
        </div>
        </td>
      </tr>
      <tr>
        <td>G003</td>
        <td>Rama</td>
        <td>rama@gmail.com</td>
        <td>Jl. Gajah Mada No. 21</td>
        <td>085678912345</td>
        <td>Aktif</td>
        <td>
        <div style="display: flex; gap: 5px; ">
          <button class="btn btn-primary">Edit</button>
          <button class="btn btn-danger">Hapus</button>
        </div>
        </td>
      </tr>
      <tr class="inactive">
        <td style="color: red;">G004</td>
        <td style="color: red;">Ingrid</td>
        <td style="color: red;">ingrid@gmail.com</td>
        <td style="color: red;">Jl. Cempaka No. 5</td>
        <td style="color: red;">087891234567</td>
        <td style="color: red;">In aktif</td>
        <td>
        <div style="display: flex; gap: 5px; ">
          <button class="btn btn-primary">Edit</button>
          <button class="btn btn-danger">Hapus</button>
        </div>
        </td>
      </tr>
      <tr>
        <td>G005</td>
        <td>Reza</td>
        <td>reza@gmail.com</td>
        <td>Jl. Sudirman No. 8</td>
        <td>083345672198</td>
        <td>Aktif</td>
        <td>
        <div style="display: flex; gap: 5px; ">
          <button class="btn btn-primary">Edit</button>
          <button class="btn btn-danger">Hapus</button>
        </div>
        </td>
      </tr> -->
      </tbody>
    </table>
    </div>
  </div>
@endsection