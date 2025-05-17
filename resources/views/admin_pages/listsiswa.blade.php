@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <div>
    <h4>List Siswa</h4><br>
    <button class="btn btn-success"><a style="text-decoration: none; color: white;" href="tambahsiswa">Tambah
      Siswa</a></button>
    <a class="btn btn-success" style="text-decoration: none; color: white;" href="uploadSiswa">Upload
    Excel</a><br><br>
    <table class="table table-bordered align-middle">
    <thead>

      <tr class="thead" style="font-weight: bold; background-color: #608BC1;">
      <td>ID Siswa</td>
      <td>Nama</td>
      <td>Email</td>
      <td>Alamat</td>
      <td>No. Telp</td>
      <td>Status</td>
      <td>Action</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($allsiswa as $g): ?>
      <tr class="{{ $g->STATUS_SISWA == "Active" ? "" : "inactive" }}">
      <td>{{ $g->ID_SISWA }}</td>
      <td>{{ $g->NAMA_SISWA}}</td>
      <td>{{ $g->EMAIL_SISWA}}</td>
      <td>{{ $g->ALAMAT_SISWA}}</td>
      <td>{{ $g->NO_TELPON_SISWA}}</td>
      <td>{{ $g->STATUS_SISWA == "Active" ? "Aktif" : "Inaktif" }}</td>
      <td>
        <div style="display: flex; gap: 5px;">
        <button class="btn btn-primary"><a href="{{ url('/admin/editsiswa/' . urlencode($g->ID_SISWA)) }}"
          style="text-decoration: none; color: white;">Edit</a></button>
        <button class="btn btn-danger"><a href="{{ url('/admin/listsiswa/' . urlencode($g->ID_SISWA)) }}"
          style="text-decoration: none; color: white;">{{ $g->STATUS_SISWA == "Active" ? "Hapus" : "Buat Aktif" }}</a></button>
        </div>
      </td>
      </tr>
      <?php endforeach; ?>
      <!-- <tr>
      <td>2200001</td>
      <td>Andi Saputra</td>
      <td>andi.saputra@gmail.com</td>
      <td>Jl. Pahlawan No. 10</td>
      <td>081234567891</td>
      <td>Aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary"><a style="color: white;" href="editsiswa.php">Edit</a></button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr class="inactive">
      <td style="color: red;">2200002</td>
      <td style="color: red;">Budi Santoso</td>
      <td style="color: red;">budi.santoso@gmail.com</td>
      <td style="color: red;">Jl. Merdeka No. 25</td>
      <td style="color: red;">081298765432</td>
      <td style="color: red;">In aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr>
      <td>2200003</td>
      <td>Citra Lestari</td>
      <td>citra.lestari@gmail.com</td>
      <td>Jl. Anggrek No. 8</td>
      <td>081276543210</td>
      <td>Aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr>
      <td>2200004</td>
      <td>Dewi Ayu</td>
      <td>dewi.ayu@gmail.com</td>
      <td>Jl. Melati No. 3</td>
      <td>081212345678</td>
      <td>Aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr class="inactive">
      <td style="color: red;">2200005</td>
      <td style="color: red;">Erik Gunawan</td>
      <td style="color: red;">erik.gunawan@gmail.com</td>
      <td style="color: red;">Jl. Mawar No. 15</td>
      <td style="color: red;">081322334455</td>
      <td style="color: red;">In aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr>
      <td>2200006</td>
      <td>Fitri Hasanah</td>
      <td>fitri.hasanah@gmail.com</td>
      <td>Jl. Kenanga No. 20</td>
      <td>081344556677</td>
      <td>Aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr class="inactive">
      <td style="color: red;"> 2200007</td>
      <td style="color: red;">Gilang Ramadhan</td>
      <td style="color: red;">gilang.ramadhan@gmail.com</td>
      <td style="color: red;">Jl. Flamboyan No. 9</td>
      <td style="color: red;">081377788899</td>
      <td style="color: red;">In aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr>
      <td>2200008</td>
      <td>Hana Putri</td>
      <td>hana.putri@gmail.com</td>
      <td>Jl. Cemara No. 2</td>
      <td>081366677788</td>
      <td>Aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr>
      <td>2200009</td>
      <td>Iqbal Maulana</td>
      <td>iqbal.maulana@gmail.com</td>
      <td>Jl. Sudirman No. 88</td>
      <td>081399988877</td>
      <td>Aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr>
      <tr class="inactive">
      <td style="color: red;">2200010</td>
      <td style="color: red;">Joko Widodo</td>
      <td style="color: red;">joko.widodo@gmail.com</td>
      <td style="color: red;">Jl. Kartini No. 100</td>
      <td style="color: red;">081311122233</td>
      <td style="color: red;">In aktif</td>
      <td>
      <div style="display: flex; gap: 5px;">
      <button class="btn btn-primary">Edit</button>
      <button class="btn btn-danger">Hapus</button>
      </div>
      </td>
      </tr> -->

    </tbody>
    </table>
  </div>
@endsection