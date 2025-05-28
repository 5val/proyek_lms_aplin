@extends('layouts.admin_app')

@section('admin_content')
  <div class="p-3">
    <div class="row g-4 mb-4">

    </div>

    <div>
    <h4>List Pengumuman</h4><br>
    <button class="btn btn-success"><a style="text-decoration: none; color: white;" href="tambahpengumuman">Tambah
      Pengumuman</a></button><br><br>
    <table class="table table-bordered align-middle">
      <thead>

      <tr class="thead" style="font-weight: bold; background-color: #608BC1;">
        <td>ID Pengumuman</td>
        <td>Tanggal Pengumuman</td>
        <td>Judul Pengumuman</td>
        <td>Isi Pengumumn</td>
        <td>Action</td>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($allpengumuman as $g): ?>
      <tr>
        <td>{{ $g->ID }}</td>
        <td>{{ $g->updated_at == null ? $g->created_at : $g->updated_at}}</td>
        <td>{{ $g->Judul}}</td>
        <td>{{ $g->Deskripsi}}</td>
        <td>
        <div style="display: flex; gap: 5px;">
          <button class="btn btn-primary"><a href="{{ url('/admin/editpengumuman/' . urlencode($g->ID)) }}"
            style="text-decoration: none; color: white;">Edit</a></button>
          <button class="btn btn-danger"><a href="{{ url('/admin/listpengumuman/' . urlencode($g->ID)) }}"
            style="text-decoration: none; color: white;">Delete</a></button>
        </div>
        </td>
      </tr>
      <?php endforeach; ?>

      </tbody>
    </table>
    </div>
  </div>
@endsection