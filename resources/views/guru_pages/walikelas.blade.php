@extends('layouts.guru_app')

@section('guru_content')
<form method="GET" action="/guru/walikelas" class="mb-4">
        <label for="periodeSelect" class="form-label">Pilih Periode:</label>
        <select name="periodeSelect" id="periodeSelect" class="form-select" onchange="this.form.submit()">
            @foreach($allPeriode as $p)
                <option value="{{ $p->ID_PERIODE }}" {{ $periode->ID_PERIODE == $p->ID_PERIODE ? 'selected' : '' }}>
                    {{ $p->PERIODE }}
                </option>
            @endforeach
        </select>
    </form>
<?php if ($wali_kelas) : ?>
<div class="topbar rounded mt-3">
   <h3>{{ $wali_kelas->NAMA_KELAS }}</h3>
   <div class="row">
   <div class="col">Jumlah Murid<br><strong>{{ $jumlah }}</strong></div>
   <div class="col">Ruang Kelas<br><strong>{{ $wali_kelas->ID_DETAIL_KELAS }}</strong></div>
   <div class="col">Semester<br><strong>{{ $semester }}</strong></div>
   </div>
</div>
<br>
<div class="average-card-custom mt-3">
<h5 class="average-card-title">Daftar Siswa</h5>
<div class="table-responsive-custom mt-3">
    <table class="average-table table-bordered table-lg">
        <thead class="table-header-custom">
            <tr>
            <th scope="col" class="w-25">ID</th>
            <th scope="col">Nama</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
          <tbody>
            <?php foreach ($daftar_siswa as $s) : ?>
                <tr>
                <td>{{ $s->siswa->ID_SISWA }}</td>
                <td>{{ $s->siswa->NAMA_SISWA }}</td>
                <td>
                    <a href="{{ url('/guru/laporan_siswa/' . base64_encode($s->ID_SISWA)) }}" class="btn btn-outline-primary btn-sm" title="Lihat Laporan">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                        <span class="visually-hidden">Lihat Laporan</span>
                    </a>
                </td>
                </tr>
            <?php endforeach; ?>
          </tbody>
    </table>
</div>
</div>
<?php else : ?>
   <div class="topbar rounded mt-3">
   <h3>Bukan Wali Kelas</h3>
</div>
<?php endif; ?>

@endsection
