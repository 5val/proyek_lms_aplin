@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-3 text-light">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="average-card-title mb-0">Beranda Orang Tua</h3>
        <span class="text-muted small">Anak: {{ $siswa->NAMA_SISWA }} ({{ $siswa->ID_SISWA }})</span>
    </div>

    <div class="row g-3 mb-3" id="absensi">
        <div class="col-md-3">
            <div class="average-card-custom p-3">
                <div class="text-light">Hadir</div>
                <div class="fs-4 fw-bold text-success">{{ $attendanceStats['Hadir'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="average-card-custom p-3">
                <div class="text-light">Izin</div>
                <div class="fs-4 fw-bold text-warning">{{ $attendanceStats['Izin'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="average-card-custom p-3">
                <div class="text-light">Sakit</div>
                <div class="fs-4 fw-bold text-info">{{ $attendanceStats['Sakit'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="average-card-custom p-3">
                <div class="text-light">Alpa</div>
                <div class="fs-4 fw-bold text-danger">{{ $attendanceStats['Alpa'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="average-card-custom p-3 mb-3" id="jadwal">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Jadwal Mata Pelajaran</h5>
            <span class="text-muted small">{{ $kelasInfo->NAMA_KELAS ?? '-' }} | {{ $kelasInfo->PERIODE ?? '-' }}</span>
        </div>
        <div class="table-responsive-custom">
            <table class="average-table table-bordered align-middle mb-0">
                <thead class="table-header-custom">
                    <tr>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $j)
                        <tr>
                            <td>{{ $j->HARI_PELAJARAN }}</td>
                            <td>{{ $j->JAM_PELAJARAN }}</td>
                            <td>{{ $j->NAMA_PELAJARAN }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">Belum ada jadwal</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6" id="tugas">
            <div class="average-card-custom p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Tugas Mendatang</h5>
                    <span class="text-muted small">Maks 5 terdekat</span>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($tugas as $t)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">{{ $t->NAMA_TUGAS }}</div>
                                <div class="text-muted small">{{ $t->NAMA_PELAJARAN }}</div>
                            </div>
                            <span class="badge bg-primary">{{ \Carbon\Carbon::parse($t->DEADLINE_TUGAS)->format('d M Y') }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Tidak ada tugas terjadwal</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-6" id="materi">
            <div class="average-card-custom p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Materi Terbaru</h5>
                    <span class="text-muted small">Maks 5</span>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($materi as $m)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">{{ $m->NAMA_MATERI }}</div>
                                <div class="text-muted small">{{ $m->NAMA_PELAJARAN }}</div>
                            </div>
                            <span class="badge bg-secondary">{{ $m->TGL_UPLOAD ?? '-' }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada materi</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="average-card-custom p-3 mb-3" id="info">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Info Sekolah</h5>
            <span class="text-muted small">Pengumuman terbaru</span>
        </div>
        <ul class="list-group list-group-flush">
            @forelse($pengumuman as $p)
                <li class="list-group-item">
                        <div class="fw-bold">{{ $p->JUDUL ?? $p->Judul ?? 'Pengumuman' }}</div>
                        <div class="text-muted small">{{ $p->ISI ?? $p->Deskripsi ?? '' }}</div>
                </li>
            @empty
                <li class="list-group-item text-muted">Belum ada pengumuman</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
