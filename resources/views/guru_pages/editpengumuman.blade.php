@extends('layouts.guru_app')

@section('guru_content')
<div class="topbar rounded mt-3">
       
        </div>

        <!-- Tabs -->
       <br>
        <div class="content-box">

       <div class="material-box2">
         <form action="{{ route('guru.updatepengumuman', base64_encode($pengumuman->ID)) }}" method="POST">
          @csrf
          @method("PUT") 
         <h4 style="text-align: center;">Edit Pengumuman</h4><br>
         <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran }}">
         <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Judul pengumuman</label>
            <input class="form-control" type="text" aria-label="default input example" name = "Judul" value="{{ old('Judul', $pengumuman->Judul) }}">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Detail pengumuman</label>
            <textarea class="form-control" type="text" name="Deskripsi" aria-label="default input example">{{ old('Deskripsi', $pengumuman->Deskripsi) }}</textarea>
          </div>
          
          <div class="d-grid gap-2">
            <button class="btn btn-success" type="submit">Edit</button>
          </div>
          </form>
          </div>
@endsection