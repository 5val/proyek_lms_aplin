@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
          <h4 class="mb-3">Kelas</h4>
          <h5 class="mt-4">Kelas yang Anda Ajar:</h5>
        <div class="grid-container">
        <a href="/guru/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-calculator"></i>
            <h5>Matematika</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/guru/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-leaf"></i>
            <h5>Biologi</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/guru/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-book-open"></i>
            <h5>Bahasa Inggris</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/guru/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-flask"></i>
            <h5>Fisika</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/guru/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-vial"></i>
            <h5>Kimia</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/guru/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-pencil-alt"></i>
            <h5>Bahasa Indonesia</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        <a href="/guru/detail_pelajaran" class="text-decoration-none text-dark">
            <div class="grid-item">
            <i class="fas fa-history"></i>
            <h5>Sejarah</h5>
            <p>Guru: Ibu Lestari</p>
            </div>
        </a>
        </div>

        </div>
@endsection