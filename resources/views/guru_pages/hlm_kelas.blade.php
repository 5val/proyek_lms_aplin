@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
          <h4 class="mb-3">Kelas</h4>
          <p><strong>Periode:</strong> {{ $periode->PERIODE }}</p>
          <h5 class="mt-4">Kelas yang Anda Ajar:</h5>
        <div class="grid-container">
         <?php foreach ($all_kelas as $k) : ?>
            <a href="{{ url('/guru/detail_pelajaran/' . urlencode($k->id_mata_pelajaran)) }}" class="text-decoration-none text-dark">
               <div class="grid-item">
               <i class="fas fa-calculator"></i>
               <h5>{{ $k->nama_pelajaran }}</h5>
               <p>Kelas: {{ $k->nama_kelas }}</p>
               </div>
            </a>
         <?php endforeach; ?>
        
        </div>

        </div>
@endsection