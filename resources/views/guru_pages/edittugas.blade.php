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

        <!-- Tabs -->
       <br>
        <div class="content-box">
          <button class="btn btn-danger"><a style="text-decoration: none; color: white;" href="{{ url('/guru/detail_pelajaran/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}">Back</a></button><br><br>
       <div class="material-box2">
         <form action="{{ route('guru.updatetugas', urlencode($tugas->ID_TUGAS)) }}" method="POST">
          @csrf
          @method("PUT") 
         <h4 style="text-align: center;">Edit Tugas</h4><br>
          <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
         <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama Tugas</label>
            <input class="form-control" type="text" name="NAMA_TUGAS" value="{{ old('NAMA_TUGAS', $tugas->NAMA_TUGAS) }}" aria-label="default input example">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Tugas</label>
            <textarea class="form-control"  name="DESKRIPSI_TUGAS" aria-label="default input example">{{ old('DESKRIPSI_TUGAS', $tugas->DESKRIPSI_TUGAS) }}</textarea>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Deadline</label>
            <input class="form-control" type="datetime-local" name="DEADLINE_TUGAS" value="{{ old('DEADLINE_TUGAS', $tugas->DEADLINE_TUGAS) }}" aria-label="default input example">
          </div>
          
          <div class="d-grid gap-2">
            <button class="btn btn-success" type="submit">Edit</button>
          </div>
          </form>
          </div>
        <!-- Tabs Content -->
@endsection