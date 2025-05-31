@extends('layouts.guru_app')

@section('guru_content')
<div class="topbar rounded mt-3">
          <h3>{{ $mata_pelajaran->pelajaran->NAMA_PELAJARAN }}</h3>
          <p class="text-muted">{{ $kelas->detailKelas->NAMA_KELAS }}</p>
          <div class="row">
            <div class="col">Jumlah Murid<br><strong>{{ $jumlah }}</strong></div>
            <div class="col">Ruang Kelas<br><strong>{{ $kelas->ID_DETAIL_KELAS }}</strong></div>
            <div class="col">Hari<br><strong>{{ $mata_pelajaran->HARI_PELAJARAN }}</strong></div>
            <div class="col">Jam<br><strong>{{ $mata_pelajaran->JAM_PELAJARAN }}</strong></div>
            <div class="col">Semester<br><strong>{{ $semester }}</strong></div>
          </div>
        </div>
        <br>
        <div class="content-box">
            <button class="btn btn-danger"><a style="text-decoration: none; color: white;" href="{{ url('/guru/detail_pelajaran/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}">Back</a></button><br><br>
       <div class="material-box2">
        <form method="POST" action="{{ url('/guru/tambahpengumuman') }}">
         @csrf
         <h4 style="text-align: center;">Tambah Pengumuman</h4><br>
            <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Judul pengumuman</label>
            <input class="form-control" type="text" placeholder="Default input" name="Judul" aria-label="default input example">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Detail pengumuman</label>
            <textarea class="form-control" type="text" placeholder="Default input" name="Deskripsi" aria-label="default input example"></textarea>
          </div>
          
          <div class="d-grid gap-2">
            <button class="btn btn-success" type="submit">Tambah</button>
          </div>
           </form>
          </div>
@endsection