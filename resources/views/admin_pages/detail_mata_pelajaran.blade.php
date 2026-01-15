@extends('layouts.admin_app')

@section('admin_content')
<style>
.absensi-checkbox {
   width: 22px;
   height: 22px;
   transform: scale(1.25);
   cursor: pointer;
}
</style>
    <div class="container mt-5">
        <button onclick="window.history.back()">Back</button>
        <h5 class="mt-3 mb-3">Daftar Absensi Siswa</h5>
        <div class="table-responsive">
            <table class="table table-bordered bg-white shadow-sm">
                <thead class="table-light">
                     <tr>
                        <th style="width: 150px;">ID</th>
                        <th>Nama</th>
                        <?php $counter = 1; ?>
                        <?php foreach ($pertemuan as $p): ?>
                           <th class="text-center">Pertemuan {{ $counter++ }}</th>
                        <?php endforeach; ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($siswa as $s): ?>
                        <tr>
                        <td>{{ $s->siswa->ID_SISWA }}</td>
                        <td>{{ $s->siswa->NAMA_SISWA }}</td>
                        <?php foreach ($pertemuan as $p): ?>
                           <?php $a = $absen[$s->siswa->ID_SISWA][$p->ID_PERTEMUAN] ?? null; ?>
                           <td class="text-center">
                              <input type="checkbox" class="absensi-checkbox" data-siswa="{{ $s->siswa->ID_SISWA }}" data-pertemuan="{{ $p->ID_PERTEMUAN }}" {{ ($a === null || $a) ? 'checked' : '' }}>
                           </td>
                        <?php endforeach; ?>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection
