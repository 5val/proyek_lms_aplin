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
<ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi-tab-content" type="button" role="tab" aria-controls="materi-tab-content" aria-selected="true">Materi</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tugas-tab" data-bs-toggle="tab" data-bs-target="#tugas-tab-content" type="button" role="tab" aria-controls="tugas-tab-content" aria-selected="false">Tugas</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa-tab-content" type="button" role="tab" aria-controls="siswa-tab-content" aria-selected="false">Siswa</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pertemuan-tab" data-bs-toggle="tab" data-bs-target="#pertemuan-tab-content" type="button" role="tab" aria-controls="pertemuan-tab-content" aria-selected="false">Pertemuan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi-tab-content" type="button" role="tab" aria-controls="absensi-tab-content" aria-selected="false">Absensi</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan-tab-content" type="button" role="tab" aria-controls="laporan-tab-content" aria-selected="false">Laporan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pengumuman-tab" data-bs-toggle="tab" data-bs-target="#pengumuman-tab-content" type="button" role="tab" aria-controls="pengumuman-tab-content" aria-selected="false">Pengumuman</button>
    </li>
</ul>

<!-- Tabs Content -->
<div class="tab-content" id="myTabContent">
    <!-- Materi Tab -->
    <div class="tab-pane fade show active" id="materi-tab-content" role="tabpanel" aria-labelledby="materi-tab">
        <button class="btn btn-primary my-3">
            <a href="{{ url('/guru/uploadmateri/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Materi</a>
        </button>
        <div class="row">
            @foreach ($materi as $m)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $m->NAMA_MATERI }}</h5>
                            <p class="card-text flex-grow-1">{{ $m->DESKRIPSI_MATERI }}</p>
                            <div class="mt-auto">
                                <a href="{{ asset('storage/uploads/materi/' . $m->FILE_MATERI) }}" download class="d-block mb-2">Download Materi</a>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50" onclick="window.location.href='/guru/editmateri'">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger w-50">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tugas Tab -->
    <div class="tab-pane fade" id="tugas-tab-content" role="tabpanel" aria-labelledby="tugas-tab">
        <button class="btn btn-primary my-3">
            <a href="{{ url('/guru/uploadtugas/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Tugas</a>
        </button>
        <div class="row">
            @foreach ($tugas as $t)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $t->NAMA_TUGAS }}</h5>
                            <p class="card-text flex-grow-1">{{ $t->DESKRIPSI_TUGAS }}</p>
                            <p>ID: {{ $t->ID_TUGAS }}</p>
                            <div class="mt-auto">
                                <p class="card-text">Deadline: {{ $t->DEADLINE_TUGAS }}</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50">
                                        <a href="{{ route('guru.edittugas', $t->ID_TUGAS) }}" style="text-decoration:none;">Edit</a>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger w-50">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Siswa Tab -->
    <div class="tab-pane fade" id="siswa-tab-content" role="tabpanel" aria-labelledby="siswa-tab">
        <h5 class="mt-3">Daftar Siswa</h5>
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col" class="w-25">ID</th>
                        <th scope="col">Nama</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>220/0001</td><td>Andi Santoso</td></tr>
                    <tr><td>220/0002</td><td>Budi Wijaya</td></tr>
                    <tr><td>220/0003</td><td>Citra Lestari</td></tr>
                    <tr><td>220/0004</td><td>Dewi Kurnia</td></tr>
                    <tr><td>220/0005</td><td>Eko Prasetyo</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pertemuan Tab -->
    <div class="tab-pane fade" id="pertemuan-tab-content" role="tabpanel" aria-labelledby="pertemuan-tab">
        <button class="btn btn-primary my-3">
            <a href="{{ url('/guru/tambahpertemuan/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Pertemuan</a>
        </button>
        <div class="row">
            @foreach ($pertemuan as $pt)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Pertemuan</h5>
                            <p class="card-text flex-grow-1">{{ $pt->DETAIL_PERTEMUAN }}</p>
                            <div class="mt-auto">
                                <p>{{ $pt->TANGGAL_PERTEMUAN }}</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50" onclick="window.location.href='/guru/editmateri'">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger w-50">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Absensi Tab -->
    <div class="tab-pane fade" id="absensi-tab-content" role="tabpanel" aria-labelledby="absensi-tab">
        <h5 class="mt-3 mb-3">Daftar Absensi Siswa</h5>
        <div class="table-responsive">
            <table class="table table-bordered bg-white shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th style="width: 150px;">ID</th>
                        <th>Nama</th>
                        <th class="text-center">Pertemuan 1</th>
                        <th class="text-center">Pertemuan 2</th>
                        <th class="text-center">Pertemuan 3</th>
                        <th class="text-center">Pertemuan 4</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>220/0001</td>
                        <td>Andi Santoso</td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><input type="checkbox"></td>
                    </tr>
                    <tr>
                        <td>220/0002</td>
                        <td>Budi Wijaya</td>
                        <td class="text-center"><input type="checkbox" checked></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                        <td class="text-center"><input type="checkbox"></td>
                    </tr>
                    <tr>
                        <td>220/0003</td>
                        <td>Citra Lestari</td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                    </tr>
                    <tr>
                        <td>220/0004</td>
                        <td>Dewi Kurnia</td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                    </tr>
                    <tr>
                        <td>220/0005</td>
                        <td>Eko Prasetyo</td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                        <td class="text-center"><input type="checkbox" checked></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Laporan Tab -->
    <div class="tab-pane fade" id="laporan-tab-content" role="tabpanel" aria-labelledby="laporan-tab">
        <h5 class="mt-3 mb-3">Laporan Nilai Siswa</h5>
        <!-- Sub-tabs -->
        <ul class="nav nav-tabs" id="laporanTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tugas-subtab" data-bs-toggle="tab" data-bs-target="#tugas" type="button" role="tab" aria-controls="tugas" aria-selected="true">Tugas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ujian-subtab" data-bs-toggle="tab" data-bs-target="#ujian" type="button" role="tab" aria-controls="ujian" aria-selected="false">Ujian</button>
            </li>
        </ul>
        <div class="tab-content mt-3" id="laporanTabContent">
            <!-- Tugas Sub-tab -->
            <div class="tab-pane fade show active" id="tugas" role="tabpanel" aria-labelledby="tugas-subtab">
                <table class="table table-bordered bg-white shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 150px;">ID Siswa</th>
                            <th>Nama Siswa</th>
                            <th>Nilai Tugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>220/0001</td><td>Andi Santoso</td><td>80</td></tr>
                        <tr><td>220/0002</td><td>Budi Wijaya</td><td>90</td></tr>
                        <tr><td>220/0003</td><td>Citra Lestari</td><td>85</td></tr>
                        <tr><td>220/0004</td><td>Dewi Kurnia</td><td>75</td></tr>
                        <tr><td>220/0005</td><td>Eko Prasetyo</td><td>95</td></tr>
                    </tbody>
                </table>
            </div>
            <!-- Ujian Sub-tab -->
            <div class="tab-pane fade" id="ujian" role="tabpanel" aria-labelledby="ujian-subtab">
                <table class="table table-bordered bg-white shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 150px;">ID Siswa</th>
                            <th>Nama Siswa</th>
                            <th>Nilai Ujian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>220/0001</td><td>Andi Santoso</td><td>90</td></tr>
                        <tr><td>220/0002</td><td>Budi Wijaya</td><td>88</td></tr>
                        <tr><td>220/0003</td><td>Citra Lestari</td><td>84</td></tr>
                        <tr><td>220/0004</td><td>Dewi Kurnia</td><td>79</td></tr>
                        <tr><td>220/0005</td><td>Eko Prasetyo</td><td>92</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pengumuman Tab -->
    <div class="tab-pane fade" id="pengumuman-tab-content" role="tabpanel" aria-labelledby="pengumuman-tab">
         <button class="btn btn-primary my-3">
            <a href="{{ url('/guru/tambahpengumuman/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Pengumuman</a>
        </button>
        <div class="row">
            @foreach ($pengumuman as $p)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Pengumuman <span> {{ $p->ID }}</span></h5>
                            <p class="card-text">{{ $p->Judul }}</p>
                            <p class="card-text flex-grow-1">{{ $p->Deskripsi }}</p>
                            <div class="mt-auto">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50"><a href="{{ route('guru.editpengumuman', $p->ID) }}" style="text-decoration:none;">Edit</a></button>
                                    <button class="btn btn-sm btn-outline-danger w-50">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
