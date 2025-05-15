@extends('layouts.guru_app')

@section('guru_content')
<div class="topbar rounded mt-3">
        <!-- Tabs -->
       <br>
        <div class="content-box">
          <button class="btn btn-danger"><a style="text-decoration: none; color: white;" href="{{ url()->previous() }}">Back</a></button><br><br>
       <div class="material-box2">
         <form action="/guru/editmateri" method="POST" enctype="multipart/form-data">
          @csrf
          @method("PUT") 
         <h4 style="text-align: center;">Edit Materi</h4><br>
         <input type="hidden" name="ID_MATERI" value="{{ $materi->ID_MATERI }}">
         <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $materi->ID_MATA_PELAJARAN }}">
         <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama Materi</label>
            <input class="form-control" type="text" name="NAMA_MATERI" value="{{ $materi->NAMA_MATERI }}" aria-label="default input example" required>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Materi</label>
            <textarea class="form-control" aria-label="default input example" name="DESKRIPSI_MATERI" required>{{ $materi->DESKRIPSI_MATERI }}</textarea>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">File Materi</label>
            <input class="form-control" type="file" name="FILE_MATERI" aria-label="default input example">
          </div>
          
          <div class="d-grid gap-2">
            <button class="btn btn-success" type="submit">Edit</button>
          </div>
          </form>
          </div>
@endsection