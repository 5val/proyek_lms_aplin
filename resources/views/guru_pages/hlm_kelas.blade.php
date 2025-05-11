@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
          <h4 class="mb-3">Kelas</h4>
          <h5 class="mt-4">Kelas yang Anda Ajar:</h5>
        <div class="grid-container">
         <?php foreach ($all_kelas as $k) : ?>
            <a href="{{ url('/guru/detail_pelajaran/' . urlencode($k->ID_MATA_PELAJARAN)) }}" class="text-decoration-none text-dark">
               <div class="grid-item">
               <i class="fas fa-calculator"></i>
               <h5>{{ $k->pelajaran->NAMA_PELAJARAN }}</h5>
               <p>Kelas: {{ $k->kelas->ID_DETAIL_KELAS }}</p>
               </div>
            </a>
         <?php endforeach; ?>
        
        </div>

        </div>
@endsection