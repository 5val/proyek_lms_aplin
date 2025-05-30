@extends('layouts.guru_app')

@section('guru_content')
<a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
   <h3>Upload Nilai {{ $mata_pelajaran->pelajaran->NAMA_PELAJARAN }}</h3>
@endsection