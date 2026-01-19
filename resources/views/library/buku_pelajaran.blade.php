@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-4">
  <div class="average-card-custom">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
      <div>
        <h3 class="average-card-title mb-0">Library Buku Pelajaran</h3>
        <p class="text-muted small mb-0">Akses untuk Admin, Guru, Siswa, dan Orang Tua</p>
      </div>
      <form method="GET" class="d-flex align-items-center gap-2">
        <label class="text-light small mb-0">Filter Kelas</label>
        <select name="kelas" class="form-select form-select-sm bg-dark text-light border-secondary" onchange="this.form.submit()">
          <option value="">Semua Kelas</option>
          @foreach($kelasList as $kelas)
            <option value="{{ $kelas->ID_KELAS }}" {{ $kelasFilter == $kelas->ID_KELAS ? 'selected' : '' }}>
              {{ $kelas->ID_KELAS }}{{ $kelas->NAMA_KELAS ? ' - '.$kelas->NAMA_KELAS : '' }}
            </option>
          @endforeach
        </select>
      </form>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    @if(!empty($blockedReason))
      <div class="alert alert-warning mb-3">{{ $blockedReason }}</div>
    @endif

    @if($books->isEmpty())
      <div class="text-center text-light py-4">
        @if(!empty($blockedReason))
          Tagihan buku periode ini belum lunas. Silakan selesaikan pembayaran untuk mengakses buku.
        @else
          Belum ada buku yang tersedia.
        @endif
      </div>
    @else
      <div class="row g-3">
        @foreach($books as $book)
          <div class="col-md-4">
            <div class="card h-100 bg-dark text-light border-secondary">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $book->JUDUL }}</h5>
                <p class="text-muted small mb-1">Kategori: {{ $book->KATEGORI ?? '-' }}</p>
                <div class="small mb-2">Kelas:
                  @if($book->kelas->isEmpty())
                    <span class="text-muted">Umum</span>
                  @else
                    @foreach($book->kelas as $kelas)
                      <span class="badge bg-secondary me-1">{{ $kelas->ID_KELAS }}{{ $kelas->NAMA_KELAS ? ' - '.$kelas->NAMA_KELAS : '' }}</span>
                    @endforeach
                  @endif
                </div>
                <p class="flex-grow-1 small text-muted">{{ $book->DESKRIPSI ?? 'Tidak ada deskripsi.' }}</p>
                <div class="d-flex justify-content-between align-items-center mt-2">
                  <span class="small text-muted">{{ number_format($book->FILE_SIZE / 1024 / 1024, 2) }} MB</span>
                  <a href="{{ url(request()->path().'/'.$book->ID_BUKU.'/view') }}" class="btn btn-primary btn-sm" target="_blank">Lihat</a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection
