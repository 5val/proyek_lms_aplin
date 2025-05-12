@extends('layouts.siswa_app')

@section('siswa_content')
<div class="topbar rounded mt-3">
    <h3>{{ $namaPelajaran }}</h3>
    <p class="text-muted">{{ $detailKelas->NAMA_KELAS }} - {{ $semester }}</p>
    <div class="row">
        <div class="col">Jumlah Murid<br><strong>{{ $jumlahMurid }}</strong></div>
        <div class="col">Ruang Kelas<br><strong>{{ $ruangKelas }}</strong></div>
        <div class="col">Hari<br><strong>{{ $mataPelajaran->HARI_PELAJARAN }}</strong></div>
        <div class="col">Jam Pelajaran<br><strong>{{ $mataPelajaran->JAM_PELAJARAN }}</strong></div>
        <div class="col">Periode<br><strong>{{ $semester }}</strong></div>
    </div>
</div>

<ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi-tab-content" type="button">Materi</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tugas-tab" data-bs-toggle="tab" data-bs-target="#tugas-tab-content" type="button">Tugas</button>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <!-- Materi Tab -->
    <div class="tab-pane fade show active" id="materi-tab-content" role="tabpanel">
        <div class="row g-4">
            @foreach($materi as $m)
            <div class="col-md-4">
                <div class="card h-100 p-3 d-flex flex-column">
                    <h5 class="card-title">{{ $m->NAMA_MATERI }}</h5>
                    <p class="card-text">{{ $m->DESKRIPSI_MATERI }}</p>
                    <a href="{{ asset('storage/'.$m->FILE_MATERI) }}" class="mt-auto align-self-start">Download Materi</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tugas Tab -->
    <div class="tab-pane fade" id="tugas-tab-content" role="tabpanel">
        <div class="row g-4">
            @foreach($tugas as $t)
            <div class="col-md-4">
                <a href="{{ url('/siswa/hlm_detail_tugas/' . urlencode($t->ID_TUGAS)) }}" class="card h-100 p-3 d-flex flex-column">
                    <h5 class="card-title">{{ $t->NAMA_TUGAS }}</h5>
                    <p class="card-text">{{ $t->DESKRIPSI_TUGAS }}</p>
                    <p class="card-deadline mt-auto text-end">Deadline: {{ $t->DEADLINE_TUGAS }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
