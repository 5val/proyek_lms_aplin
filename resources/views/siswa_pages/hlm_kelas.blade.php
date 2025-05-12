@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
          <h4 class="mb-3">Kelas Siswa</h4>
          <p><strong>Kelas:</strong> {{ $kelas->NAMA_KELAS }} &nbsp; | &nbsp; <strong>Periode:</strong> {{ $kelas->PERIODE }}</p>

          <h5 class="mt-4">Kelas Pelajaran</h5>
        <div class="grid-container">
            @foreach($matapelajaran as $mp)
            <a href="{{ url('/siswa/detail_pelajaran/' . urlencode($mp->ID_MATA_PELAJARAN)) }}" class="text-decoration-none text-dark">
                <div class="grid-item">
                    <i class="fas fa-book"></i>
                    <h5>{{ $mp->NAMA_PELAJARAN }}</h5>
                    <p>Guru: {{ $mp->NAMA_GURU }}</p>
                </div>
            </a>
            @endforeach
        <!-- <a href="/siswa/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-calculator"></i>
            <h5>Matematika</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/siswa/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-leaf"></i>
            <h5>Biologi</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/siswa/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-book-open"></i>
            <h5>Bahasa Inggris</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/siswa/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-flask"></i>
            <h5>Fisika</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/siswa/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-vial"></i>
            <h5>Kimia</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/siswa/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-pencil-alt"></i>
            <h5>Bahasa Indonesia</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/siswa/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-history"></i>
            <h5>Sejarah</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a> -->
        </div>

        </div>
@endsection