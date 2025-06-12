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
<class="content-box">
    <button class="btn btn-danger"><a style="text-decoration: none; color: white;" href="{{ url('/guru/detail_pelajaran/' . base64_encode($mata_pelajaran->ID_MATA_PELAJARAN)) }}">Back</a></button><br><br>
       <div class="material-box2">
         <form method="POST" action="/guru/uploadmateri" enctype="multipart/form-data">
         @csrf
            <h4 style="text-align: center;">Upload Materi</h4><br>
            <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
            <div class="mb-3">
               <label for="exampleFormControlInput1" class="form-label">Nama Materi</label>
               <input class="form-control" type="text" name="NAMA_MATERI" placeholder="Default input" aria-label="default input example" required>
            </div>
            <div class="mb-3">
               <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Materi</label>
               <textarea class="form-control" type="text" name="DESKRIPSI_MATERI" placeholder="Default input" aria-label="default input example" required></textarea>
            </div>
            <div class="mb-3">
               <label for="exampleFormControlTextarea1" class="form-label">File Materi</label>
               <input class="form-control" type="file" name="FILE_MATERI" placeholder="Default input" aria-label="default input example" required>
            </div>
            <div class="d-grid gap-2">
               <button class="btn btn-success" type="submit">Upload</button>
            </div>
         </form>
      </div>
</div>
@endsection