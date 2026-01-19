@extends('layouts.guru_app')

@section('guru_content')
<style>
.absensi-checkbox {
    width: 22px;
    height: 22px;
    transform: scale(1.25);
    cursor: pointer;
}
</style>
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

<!-- Modals -->
<!-- Tambah Materi Modal -->
<div class="modal fade" id="modalTambahMateri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title">Tambah Materi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/guru/uploadmateri') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                    <div class="mb-3">
                        <label class="form-label">Nama Materi</label>
                        <input type="text" name="NAMA_MATERI" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="DESKRIPSI_MATERI" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File Materi</label>
                        <input type="file" name="FILE_MATERI" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambah Tugas Modal -->
<div class="modal fade" id="modalTambahTugas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title">Tambah Tugas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/guru/uploadtugas') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                    <div class="mb-3">
                        <label class="form-label">Nama Tugas</label>
                        <input type="text" name="NAMA_TUGAS" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="DESKRIPSI_TUGAS" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <input type="datetime-local" name="DEADLINE_TUGAS" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambah Pertemuan Modal -->
<div class="modal fade" id="modalTambahPertemuan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title">Tambah Pertemuan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/guru/tambahpertemuan') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                    <div class="mb-3">
                        <label class="form-label">Detail Pertemuan</label>
                        <input type="text" name="DETAIL_PERTEMUAN" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pertemuan</label>
                        <input type="date" name="TANGGAL_PERTEMUAN" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambah Pengumuman Modal -->
<div class="modal fade" id="modalTambahPengumuman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title">Tambah Pengumuman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/guru/tambahpengumuman') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="Judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="Deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
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
        <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalTambahMateri">Tambah Materi</button>
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
                                    <button class="btn btn-sm btn-outline-primary w-50" data-bs-toggle="modal" data-bs-target="#modalEditMateri{{ $m->ID_MATERI }}">Edit</button>
                                    <!-- <button class="btn btn-sm btn-outline-primary w-50">
                                        <a href="{{ route('guru.deletemateri', $m->ID_MATERI) }}" style="text-decoration:none;">Hapus</a>
                                    </button> -->
                                    <form action="{{ route('guru.deletemateri', base64_encode($m->ID_MATERI)) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?');" class="w-50">
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

                @foreach ($materi as $m)
                <div class="modal fade" id="modalEditMateri{{ $m->ID_MATERI }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content bg-dark text-light border-0">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Edit Materi</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('guru.updatemateri', base64_encode($m->ID_MATERI)) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Materi</label>
                                        <input type="text" name="NAMA_MATERI" class="form-control" value="{{ $m->NAMA_MATERI }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="DESKRIPSI_MATERI" class="form-control" rows="3" required>{{ $m->DESKRIPSI_MATERI }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">File Materi (biarkan kosong jika tidak diganti)</label>
                                        <input type="file" name="FILE_MATERI" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
    </div>

    <!-- Tugas Tab -->
    <div class="tab-pane fade" id="tugas-tab-content" role="tabpanel" aria-labelledby="tugas-tab">
        <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">Tambah Tugas</button>
        <div class="row">
            @foreach ($tugas as $t)
               <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <a href="{{ url('/guru/hlm_detail_tugas/' . base64_encode($t->ID_TUGAS)) }}" style="text-decoration: none; color: black;">
                                <h5 class="card-title">{{ $t->NAMA_TUGAS }}</h5>
                                <p class="card-text flex-grow-1">{{ $t->DESKRIPSI_TUGAS }}</p>
                                <p>ID: {{ $t->ID_TUGAS }}</p>
                            </a>
                            <div class="mt-auto">
                                <p class="card-text">Deadline: {{ $t->DEADLINE_TUGAS }}</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50" data-bs-toggle="modal" data-bs-target="#modalEditTugas{{ $t->ID_TUGAS }}">Edit</button>
                                    <form action="{{ route('guru.deletetugas', base64_encode($t->ID_TUGAS)) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?');" class="w-50">
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

                @foreach ($tugas as $t)
                <div class="modal fade" id="modalEditTugas{{ $t->ID_TUGAS }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content bg-dark text-light border-0">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Edit Tugas</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('guru.updatetugas', base64_encode($t->ID_TUGAS)) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Tugas</label>
                                        <input type="text" name="NAMA_TUGAS" class="form-control" value="{{ $t->NAMA_TUGAS }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="DESKRIPSI_TUGAS" class="form-control" rows="3" required>{{ $t->DESKRIPSI_TUGAS }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deadline</label>
                                        <input type="datetime-local" name="DEADLINE_TUGAS" class="form-control" value="{{ \Carbon\Carbon::parse($t->DEADLINE_TUGAS)->format('Y-m-d\TH:i') }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
    </div>

    <!-- Siswa Tab -->
    <div class="tab-pane fade" id="siswa-tab-content" role="tabpanel" aria-labelledby="siswa-tab">
        <div class="average-card-custom mt-3">
            <h5 class="average-card-title mb-2">Daftar Siswa</h5>
            <div class="table-responsive-custom">
                <table class="average-table table-bordered table-lg align-middle mb-0">
                    <thead class="table-header-custom">
                        <tr>
                            <th scope="col" class="text-center" style="width: 90px;">Foto</th>
                            <th scope="col" class="w-20">ID</th>
                            <th scope="col" class="w-25">Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($siswa as $s): ?>
                         <tr>
                            <td class="text-center">
                                <img src="{{ $s->siswa->FOTO_SISWA }}" alt="{{ $s->siswa->NAMA_SISWA }}" class="rounded-circle" style="width: 44px; height: 44px; object-fit: cover; border: 1px solid var(--border);">
                            </td>
                            <td class="fw-semibold">{{ $s->siswa->ID_SISWA }}</td>
                            <td>{{ $s->siswa->NAMA_SISWA }}</td>
                         </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pertemuan Tab -->
    <div class="tab-pane fade" id="pertemuan-tab-content" role="tabpanel" aria-labelledby="pertemuan-tab">
        <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalTambahPertemuan">Tambah Pertemuan</button>
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
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50" data-bs-toggle="modal" data-bs-target="#modalEditPertemuan{{ $pt->ID_PERTEMUAN }}">Edit</button>
                                    <form action="{{ route('guru.deletepertemuan', base64_encode($pt->ID_PERTEMUAN)) }}" method="POST" class="w-50" onsubmit="return confirm('Hapus pertemuan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

                <?php foreach ($pertemuan as $pt): ?>
                <div class="modal fade" id="modalEditPertemuan{{ $pt->ID_PERTEMUAN }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content bg-dark text-light border-0">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Edit Pertemuan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('guru.updatepertemuan', base64_encode($pt->ID_PERTEMUAN)) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                                    <div class="mb-3">
                                        <label class="form-label">Detail Pertemuan</label>
                                        <input type="text" name="DETAIL_PERTEMUAN" class="form-control" value="{{ $pt->DETAIL_PERTEMUAN }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pertemuan</label>
                                        <input type="date" name="TANGGAL_PERTEMUAN" class="form-control" value="{{ $pt->TANGGAL_PERTEMUAN }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
    </div>

    <!-- Absensi Tab -->
    <div class="tab-pane fade" id="absensi-tab-content" role="tabpanel" aria-labelledby="absensi-tab">
        <h5 class="mt-3 mb-3">Daftar Absensi Siswa</h5>
          <div class="average-card-custom">
                <h5 class="average-card-title mb-2">Daftar Absensi Siswa</h5>
                <div class="table-responsive-custom">
                     <table class="average-table table-bordered table-lg align-middle mb-0">
                          <thead class="table-header-custom">
                                 <tr>
                                     <th style="width: 160px;">ID</th>
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
                                     <td class="fw-semibold">{{ $s->siswa->ID_SISWA }}</td>
                                     <td>{{ $s->siswa->NAMA_SISWA }}</td>
                                     <?php foreach ($pertemuan as $p): ?>
                                         <?php
                                            $a = $absen[$s->siswa->ID_SISWA][$p->ID_PERTEMUAN] ?? null;
                                            $isPresent = $a ? ($a->STATUS === 'Hadir') : true; // default hadir, respect stored status
                                         ?>
                                         <td class="text-center">
                                             <input type="checkbox" class="absensi-checkbox" data-siswa="{{ $s->siswa->ID_SISWA }}" data-pertemuan="{{ $p->ID_PERTEMUAN }}" {{ $isPresent ? 'checked' : '' }}>
                                         </td>
                                     <?php endforeach; ?>
                             </tr>
                             <?php endforeach; ?>
                          </tbody>
                     </table>
                </div>
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
                                <div class="average-card-custom">
                                <table class="average-table table-bordered table-lg align-middle mb-0">
                                    <thead class="table-header-custom">
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
                           <td><a href="{{ url('/guru/edit_nilai_tugas/' . base64_encode($nilai->id_submission)) }}" class="btn btn-warning btn-sm">Edit</a></td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>

                    </table>
                    </div>

                    <div class="mt-4">
                        <h5 class="average-card-title">Rata-Rata Nilai Tugas</h5>
                        <?php foreach ($rata2_tugas as $r): ?>
                            <div class="average-card-custom p-3 mb-2">
                                <h6 class="mb-0"><strong>Rata-Rata Nilai {{ $r->nama_tugas }}:</strong> {{ $r->rata2 }}</h6>
                            </div>
                        <?php endforeach; ?>
                    </div>
            </div>
            <!-- Ujian Sub-tab -->
            <div class="tab-pane fade" id="ujian" role="tabpanel" aria-labelledby="ujian-subtab">
               <a href="{{ route('uploadNilai.excel', ["id_mata_pelajaran" => $mata_pelajaran->ID_MATA_PELAJARAN]) }}" class="btn btn-primary mb-3">Upload Nilai</a>
                     <div class="average-card-custom">
                     <table class="average-table table-bordered table-lg align-middle mb-0">
                     <thead class="table-header-custom">
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
                         <td><a href="{{ url('/guru/edit_nilai_ujian/' . base64_encode($nilai->id_nilai)) }}" class="btn btn-warning btn-sm">Edit</a></td>
                     </tr>
                  <?php endforeach; ?>
                </tbody>
                </table>
                </div>

            <!-- Nilai Rata-Rata per Tugas -->
            <div class="mt-4">
                    <div class="average-card-custom p-3">
                        <h6 class="mb-0"><strong>Rata-Rata Nilai Akhir:</strong> {{ count($rata2)>0? $rata2[0]->rata2:"0"  }}</h6>
               </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Pengumuman Tab -->
    <div class="tab-pane fade" id="pengumuman-tab-content" role="tabpanel" aria-labelledby="pengumuman-tab">
         <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalTambahPengumuman">Tambah Pengumuman</button>
        <div class="row">
            <?php foreach ($pengumuman as $p): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Pengumuman <span> {{ $p->ID_PENGUMUMAN }}</span></h5>
                            <p class="card-text">{{ $p->JUDUL }}</p>
                            <p class="card-text flex-grow-1">{{ $p->ISI }}</p>
                            <div class="mt-auto">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary w-50" data-bs-toggle="modal" data-bs-target="#modalEditPengumuman{{ $p->ID_PENGUMUMAN }}">Edit</button>
                                   <form action="{{ route('guru.deletepengumuman', $p->ID_PENGUMUMAN) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');" class="w-50">
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

                        <?php foreach ($pengumuman as $p): ?>
                        <div class="modal fade" id="modalEditPengumuman{{ $p->ID_PENGUMUMAN }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content bg-dark text-light border-0">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Edit Pengumuman</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('guru.updatepengumuman', base64_encode($p->ID_PENGUMUMAN)) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                                            <div class="mb-3">
                                                <label class="form-label">Judul</label>
                                                <input type="text" name="Judul" class="form-control" value="{{ $p->JUDUL }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="Deskripsi" class="form-control" rows="3" required>{{ $p->ISI }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <?php foreach ($pertemuan as $pt): ?>
                        <div class="modal fade" id="modalEditPertemuan{{ $pt->ID_PERTEMUAN }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content bg-dark text-light border-0">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">Edit Pertemuan</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('guru.updatepertemuan', base64_encode($pt->ID_PERTEMUAN)) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <input type="hidden" name="ID_MATA_PELAJARAN" value="{{ $mata_pelajaran->ID_MATA_PELAJARAN }}">
                                            <div class="mb-3">
                                                <label class="form-label">Detail Pertemuan</label>
                                                <input type="text" name="DETAIL_PERTEMUAN" class="form-control" value="{{ $pt->DETAIL_PERTEMUAN }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Pertemuan</label>
                                                <input type="date" name="TANGGAL_PERTEMUAN" class="form-control" value="{{ $pt->TANGGAL_PERTEMUAN }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
   $(document).ready(function () {
      $('.absensi-checkbox').on('change', function() {
         const checkbox = $(this);
         const id_siswa = checkbox.data('siswa');
         const id_pertemuan = checkbox.data('pertemuan');
             // Kirim string status; uncheck -> alpa (disimpan sebagai tidak hadir)
             const status = checkbox.is(':checked') ? 'hadir' : 'alpa';

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
