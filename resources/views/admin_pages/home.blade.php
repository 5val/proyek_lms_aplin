@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">
    <div class="col-md-4">
    <div class="card h-100 d-flex flex-column">
      <div class="board text-center card-body d-flex flex-column">
      <h5 class="card-title">Periode Saat Ini</h5>
      <p class="card-text flex-grow-1"><?= $latestPeriode->PERIODE?></p>
      </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="card h-100 d-flex flex-column">
      <div class="board text-center card-body d-flex flex-column">
      <h5 class="card-title">Jumlah Siswa</h5>
      <p class="card-text flex-grow-1"><?= $jumlahSiswa?></p>
      </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="card h-100 d-flex flex-column">
      <div class="board text-center card-body d-flex flex-column">
      <h5 class="card-title">Jumlah Guru</h5>
      <p class="card-text flex-grow-1"><?= $jumlahGuru?></p>
      </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="card h-100 d-flex flex-column">
      <div class="board text-center card-body d-flex flex-column">
      <h5 class="card-title">Jumlah Kelas</h5>
      <p class="card-text flex-grow-1"><?= $jumlahKelas?></p>
      </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="card h-100 d-flex flex-column">
      <div class="board text-center card-body d-flex flex-column">
      <h5 class="card-title">Jumlah Pelajaran</h5>
      <p class="card-text flex-grow-1"><?= $jumlahPelajaran?></p>
      </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="card h-100 d-flex flex-column">
      <div class="board text-center card-body d-flex flex-column">
      <h5 class="card-title">Jumlah Mata Pelajaran</h5>
      <p class="card-text flex-grow-1"><?= $jumlahMataPelajaran?></p>
      </div>
    </div>
    </div>
  </div>

  <div>
    <h5>Pengumuman Terbaru</h5>
    <div>
    <?php foreach ($listPengumuman as $pengumuman):?>
      <div class="announcement-card p-3 mb-3">
      <h5 class="fw-bold"><?= $pengumuman->Judul?></h5>
      <p><?= $pengumuman->Deskripsi?></p>
    </div>
    <?php endforeach;?>
    </div>
  @endsection
