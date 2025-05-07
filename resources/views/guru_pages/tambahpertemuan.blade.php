@extends('layouts.guru_app')

@section('guru_content')
<div class="topbar rounded mt-3">
    <h3>Fisika</h3>
    <p>XII IPA 1 2025</p>
    <div class="row">
    <div class="col">Jumlah Murid<br><strong>26</strong></div>
    <div class="col">Ruang Kelas<br><strong>F3/01</strong></div>
    <div class="col">Hari<br><strong>Selasa</strong></div>
    <div class="col">Jam<br><strong>08.00</strong></div>
    <div class="col">Semester<br><strong>Ganjil</strong></div>
    </div>
</div>
<br>
        <div class="content-box">
            <button class="btn btn-danger" onclick="window.location.href='/guru/detail_pelajaran'"><a style="text-decoration: none;">Back</a></button><br><br>
       <div class="material-box2">
         <h4 style="text-align: center;">Tambah Pertemuan</h4><br>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Detail pertemuan</label>
            <textarea class="form-control" type="text" placeholder="Default input" aria-label="default input example"></textarea>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Tanggal</label>
            <input class="form-control" type="datetime-local" placeholder="Default input" aria-label="default input example">
          </div>
          
          <div class="d-grid gap-2">
            <button class="btn btn-success" type="button">Tambah</button>
          </div>
          </div>
@endsection