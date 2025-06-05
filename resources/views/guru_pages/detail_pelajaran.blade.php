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
                                    <button class="btn btn-sm btn-outline-primary w-50">
                                        <a href="{{ route('guru.editmateri', $m->ID_MATERI) }}" style="text-decoration:none;">Edit</a>
                                    </button>
                                    <form action="{{ route('guru.deletemateri', $m->ID_MATERI) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');" class="w-50">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                                    </form>
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
               <a style="text-decoration: none; color: black;" href="{{ url('/guru/hlm_detail_tugas/' . urlencode($t->ID_TUGAS)) }}">
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
                                     <form action="{{ route('guru.deletetugas', $t->ID_TUGAS) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');" class="w-50">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
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
                  <?php foreach ($siswa as $s): ?>
                     <tr><td>{{ $s->siswa->ID_SISWA }}</td><td>{{ $s->siswa->NAMA_SISWA }}</td></tr>
                  <?php endforeach; ?>
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
            <?php $counter = 1; ?>
            <?php foreach ($pertemuan as $pt): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Pertemuan {{ $counter++ }}</h5>
                            <p class="card-text flex-grow-1">{{ $pt->DETAIL_PERTEMUAN }}</p>
                            <div class="mt-auto">
                                <p>{{ $pt->TANGGAL_PERTEMUAN }}</p>
                                <!-- <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50" onclick="window.location.href='/guru/editmateri'">Edit</button>
                                    <button class="btn btn-sm btn-outline-danger w-50">Hapus</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
                        <?php $counter = 1; ?>
                        <?php foreach ($pertemuan as $p): ?>
                           <th class="text-center">Pertemuan {{ $counter++ }}</th>
                        <?php endforeach; ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($siswa as $s): ?>
                        <tr>
                        <td>{{ $s->siswa->ID_SISWA }}</td>
                        <td>{{ $s->siswa->NAMA_SISWA }}</td>
                        <?php foreach ($pertemuan as $p): ?>
                           <?php $a = $absen[$s->siswa->ID_SISWA][$p->ID_PERTEMUAN] ?? null; ?>
                           <td class="text-center">
                              <input type="checkbox" class="absensi-checkbox" data-siswa="{{ $s->siswa->ID_SISWA }}" data-pertemuan="{{ $p->ID_PERTEMUAN }}" {{ $a ? 'checked' : '' }}>
                           </td>
                        <?php endforeach; ?>
                  </tr>
                  <?php endforeach; ?>
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
                <table class="table table-bordered bg-white">
                  <thead class="table-secondary">
                  <tr>
                     <th>No.</th>
                     <th>Nama Siswa</th>
                     <th>Tugas</th>
                     <th>Nilai</th>
                     <th>Status</th>
                     <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                     <?php $counter = 1; ?>
                     <?php foreach ($list_nilai_tugas as $nilai): ?>
                        <tr>
                           <td>{{ $counter++ }}</td>
                           <td>{{ $nilai->nama_siswa }}</td>
                           <td>{{ $nilai->nama_tugas }}</td>
                           <td>{{ $nilai->nilai_tugas }}</td>
                           <?php if($nilai->nilai_tugas >= 80): ?>
                              <td><span class="badge bg-success">Lulus</span></td>
                           <?php elseif($nilai->nilai_tugas >= 70): ?>
                              <td><span class="badge bg-warning">Perlu Perbaikan</span></td>
                           <?php else: ?>
                              <td><span class="badge bg-danger">Gagal</span></td>
                           <?php endif; ?>
                           <td><a href="{{ url('/guru/edit_nilai_tugas/' . urlencode($nilai->id_submission)) }}" class="btn btn-warning btn-sm">Edit</a></td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>

               <div class="mt-4">
                  <h5>Rata-Rata Nilai Tugas</h5>
                  <?php foreach ($rata2_tugas as $r): ?>
                     <div class="card bg-light p-3">
                        <h6><strong>Rata-Rata Nilai {{ $r->nama_tugas }}:</strong> {{ $r->rata2 }}</h6>
                     </div>
                  <?php endforeach; ?>
               </div>
            </div>
            <!-- Ujian Sub-tab -->
            <div class="tab-pane fade" id="ujian" role="tabpanel" aria-labelledby="ujian-subtab">
               <a href="{{ route('uploadNilai.excel', ["id_mata_pelajaran" => $mata_pelajaran->ID_MATA_PELAJARAN]) }}" class="btn btn-primary mb-3">Upload Nilai</a>
                <table class="table table-bordered bg-white">
                <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Nilai UTS</th>
                    <th>Nilai UAS</th>
                    <th>Nilai Tugas</th>
                    <th>Nilai Akhir</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php $counter = 1; ?>
                  <?php foreach ($list_nilai as $nilai): ?>
                     <tr>
                         <td>{{ $counter++ }}</td>
                         <td>{{ $nilai->nama_siswa }}</td>
                         <td>{{ $nilai->nilai_uts }}</td>
                         <td>{{ $nilai->nilai_uas }}</td>
                         <td>{{ $nilai->nilai_tugas }}</td>
                         <td>{{ $nilai->nilai_akhir }}</td>
                         <?php if($nilai->nilai_akhir >= 80): ?>
                           <td><span class="badge bg-success">Lulus</span></td>
                         <?php elseif($nilai->nilai_akhir >= 70): ?>
                           <td><span class="badge bg-warning">Perlu Perbaikan</span></td>
                         <?php else: ?>
                           <td><span class="badge bg-danger">Gagal</span></td>
                         <?php endif; ?>
                         <td><a href="{{ url('/guru/edit_nilai_ujian/' . urlencode($nilai->id_nilai)) }}" class="btn btn-warning btn-sm">Edit</a></td>
                     </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Nilai Rata-Rata per Tugas -->
            <div class="mt-4">
               <div class="card bg-light p-3">
                  <h6><strong>Rata-Rata Nilai Akhir:</strong> {{ count($rata2)>0? $rata2[0]->rata2:"0"  }}</h6>
               </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Pengumuman Tab -->
    <div class="tab-pane fade" id="pengumuman-tab-content" role="tabpanel" aria-labelledby="pengumuman-tab">
         <button class="btn btn-primary my-3">
            <a href="{{ url('/guru/tambahpengumuman/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Pengumuman</a>
        </button>
        <div class="row">
            <?php foreach ($pengumuman as $p): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Pengumuman <span> {{ $p->ID }}</span></h5>
                            <p class="card-text">{{ $p->Judul }}</p>
                            <p class="card-text flex-grow-1">{{ $p->Deskripsi }}</p>
                            <div class="mt-auto">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50">
                                    <a href="{{ route('guru.editpengumuman', ['ID' => $p->ID, 'mata_pelajaran' => $mata_pelajaran->ID_MATA_PELAJARAN]) }}" style="text-decoration:none;">
                                        Edit
                                    </a>
                                    </button>
                                    <!-- <button class="btn btn-sm btn-outline-primary w-50"><a href="{{ route('guru.editpengumuman', $p->ID) }}" style="text-decoration:none;">Edit</a></button> -->
                                   <form action="{{ route('guru.deletepengumuman', $p->ID) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');" class="w-50">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<script>
   $(document).ready(function () {
      $('.absensi-checkbox').on('change', function() {
         const checkbox = $(this);
         const id_siswa = checkbox.data('siswa');
         const id_pertemuan = checkbox.data('pertemuan');
         const status = checkbox.is(':checked');

         $.ajax({
            url: '/guru/absensi',
            method: 'POST',
            data: {
               _token: '{{ csrf_token() }}',
               id_siswa: id_siswa,
               id_pertemuan: id_pertemuan,
               status: status
            },
            success: function (response) {
               console.log(response.message);
            },
            error: function (response) {
               alert("Ajax tidak jalan");
            }
         });
      });
   });
</script>
@endsection