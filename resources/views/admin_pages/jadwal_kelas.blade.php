@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-4">
  <div class="average-card-custom">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="average-card-title mb-0">Jadwal Kelas</h3>
    </div>

    <div class="table-responsive-custom mt-2">
      <table class="average-table table-bordered table-lg align-middle no-data-table">
        <thead class="table-header-custom">
          <tr>
            <th>ID Kelas</th>
            <th>Nama Kelas</th>
            <th class="text-white">Wali Kelas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($kelasList as $kelas)
            <tr>
              <td>{{ $kelas->ID_KELAS }}</td>
              <td>{{ $kelas->detailKelas->NAMA_KELAS ?? '-' }}</td>
              <td class="text-white">{{ $kelas->wali->NAMA_GURU ?? '-' }}</td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{ route('jadwal_kelas.detail', $kelas->ID_KELAS) }}">Atur Jadwal</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
