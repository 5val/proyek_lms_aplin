@extends('layouts.siswa_app')

@section('siswa_content')
<div class="container-fluid px-0">
  <div class="mb-3">
    <h4 class="mb-1">Buku Pelajaran</h4>
    <p class="text-muted small mb-0">Buku digital yang bisa kamu baca secara online.</p>
  </div>

  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif

  @if(!empty($blockedReason))
    <div class="alert alert-warning mb-3">{{ $blockedReason }}</div>
  @endif

  @if($books->isEmpty())
    <div class="alert alert-info mb-0">Belum ada buku yang tersedia.</div>
  @else
    <div class="row g-3">
      @foreach($books as $book)
        <div class="col-md-4 col-sm-6">
          <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
              <h6 class="card-title mb-1">{{ $book->JUDUL }}</h6>
              <p class="text-muted small mb-2">Kategori: {{ $book->KATEGORI ?? '-' }}</p>
              <p class="small text-muted flex-grow-1 mb-2">{{ $book->DESKRIPSI ?? 'Tidak ada deskripsi.' }}</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted">{{ number_format($book->FILE_SIZE / 1024 / 1024, 2) }} MB</span>
                <a href="{{ route($previewRoute ?? 'siswa.buku.preview', $book->ID_BUKU) }}" class="btn btn-primary btn-sm">Preview</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
