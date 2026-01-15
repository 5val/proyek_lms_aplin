@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-4">
  <div class="average-card-custom">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="average-card-title mb-0">Master Buku Pelajaran</h3>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">Tambah</button>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive-custom mt-2">
      <table class="average-table table-bordered table-lg align-middle no-data-table" id="booksTable">
        <thead class="table-header-custom">
        <tr>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Kelas</th>
          <th>Status</th>
          <th>File</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
          <tr>
            <td>{{ $book->JUDUL }}</td>
            <td>{{ $book->KATEGORI ?? '-' }}</td>
            <td>
              @if($book->kelas->isEmpty())
                <span class="text-muted">-</span>
              @else
                <div class="d-flex flex-wrap gap-1">
                  @foreach($book->kelas as $kelas)
                    <span class="badge bg-secondary">{{ $kelas->ID_KELAS }}{{ $kelas->NAMA_KELAS ? ' - '.$kelas->NAMA_KELAS : '' }}</span>
                  @endforeach
                </div>
              @endif
            </td>
            <td>
              <span class="badge {{ $book->STATUS === 'Active' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $book->STATUS }}</span>
            </td>
            <td>
              <div class="small text-light">
                <div>{{ number_format($book->FILE_SIZE / 1024 / 1024, 2) }} MB</div>
                <div class="text-muted">{{ $book->FILE_EXT }}</div>
              </div>
            </td>
            <td>
              <div class="d-flex gap-2 flex-wrap">
                <a class="btn btn-primary btn-sm" href="{{ route('admin.buku.view', $book->ID_BUKU) }}" target="_blank" title="Lihat">
                  <i class="bi bi-eye"></i>
                </a>
                <button class="btn btn-warning btn-sm edit-btn"
                        data-id="{{ $book->ID_BUKU }}"
                        data-judul="{{ $book->JUDUL }}"
                        data-deskripsi="{{ $book->DESKRIPSI }}"
                        data-kategori="{{ $book->KATEGORI }}"
                        data-watermark="{{ $book->WATERMARK_TEXT }}"
                        data-status="{{ $book->STATUS }}"
                        data-kelas='@json($book->kelas->pluck('ID_KELAS'))'>
                  <i class="bi bi-pencil-square"></i>
                </button>
                <form action="{{ route('admin.buku.delete', $book->ID_BUKU) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
      @if($books->isEmpty())
        <div class="text-center text-light py-3">Belum ada buku.</div>
      @endif
    </div>
  </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Judul</label>
              <input type="text" name="JUDUL" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Kategori (opsional)</label>
              <input type="text" name="KATEGORI" class="form-control" placeholder="Mis. Matematika">
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi</label>
              <textarea name="DESKRIPSI" class="form-control" rows="2" placeholder="Ringkas mengenai buku"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Watermark</label>
              <input type="text" name="WATERMARK_TEXT" class="form-control" value="{{ $defaultWatermark }}" maxlength="255">
            </div>
            <div class="col-md-3">
              <label class="form-label">Status</label>
              <select name="STATUS" class="form-select" required>
                <option value="Active" selected>Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">File PDF (max 20MB)</label>
              <input type="file" name="file" class="form-control" accept="application/pdf" required>
            </div>
            <div class="col-12">
              <label class="form-label">Kelas Terkait (bisa pilih banyak)</label>
              <div class="d-flex flex-wrap gap-3 p-2 border rounded" style="max-height: 220px; overflow-y: auto;">
                @foreach($kelasList as $kelas)
                  <label class="form-check-label d-flex align-items-center gap-2">
                    <input type="checkbox" class="form-check-input" name="kelas_ids[]" value="{{ $kelas->ID_KELAS }}">
                    <span>{{ $kelas->ID_KELAS }}{{ $kelas->NAMA_KELAS ? ' - '.$kelas->NAMA_KELAS : '' }}</span>
                  </label>
                @endforeach
              </div>
              <small class="text-muted">Kosongkan jika buku bersifat umum.</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="editForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Judul</label>
              <input type="text" name="JUDUL" id="editJudul" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Kategori (opsional)</label>
              <input type="text" name="KATEGORI" id="editKategori" class="form-control" placeholder="Mis. Matematika">
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi</label>
              <textarea name="DESKRIPSI" id="editDeskripsi" class="form-control" rows="2" placeholder="Ringkas mengenai buku"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label">Watermark</label>
              <input type="text" name="WATERMARK_TEXT" id="editWatermark" class="form-control" maxlength="255">
            </div>
            <div class="col-md-3">
              <label class="form-label">Status</label>
              <select name="STATUS" id="editStatus" class="form-select" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Ganti File PDF (opsional)</label>
              <input type="file" name="file" class="form-control" accept="application/pdf">
              <small class="text-muted">Biarkan kosong jika tidak diganti.</small>
            </div>
            <div class="col-12">
              <label class="form-label">Kelas Terkait (bisa pilih banyak)</label>
              <div id="editKelasGroup" class="d-flex flex-wrap gap-3 p-2 border rounded" style="max-height: 220px; overflow-y: auto;">
                @foreach($kelasList as $kelas)
                  <label class="form-check-label d-flex align-items-center gap-2">
                    <input type="checkbox" class="form-check-input" name="kelas_ids[]" value="{{ $kelas->ID_KELAS }}">
                    <span>{{ $kelas->ID_KELAS }}{{ $kelas->NAMA_KELAS ? ' - '.$kelas->NAMA_KELAS : '' }}</span>
                  </label>
                @endforeach
              </div>
              <small class="text-muted">Kosongkan jika buku bersifat umum.</small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (!$.fn.DataTable.isDataTable('#booksTable')) {
      $('#booksTable').DataTable({
        order: [[0, 'asc']],
        columnDefs: [
          { targets: [2, 5], orderable: false }, // kelas, aksi
        ],
      });
    }

    const editModal = new bootstrap.Modal(document.getElementById('modalEdit'));
    const editForm = document.getElementById('editForm');
    const editJudul = document.getElementById('editJudul');
    const editKategori = document.getElementById('editKategori');
    const editDeskripsi = document.getElementById('editDeskripsi');
    const editWatermark = document.getElementById('editWatermark');
    const editStatus = document.getElementById('editStatus');
    const editKelasGroup = document.getElementById('editKelasGroup');

    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        editForm.action = `{{ url('/admin/buku') }}/${id}`;
        editJudul.value = btn.dataset.judul || '';
        editKategori.value = btn.dataset.kategori || '';
        editDeskripsi.value = btn.dataset.deskripsi || '';
        editWatermark.value = btn.dataset.watermark || '';
        editStatus.value = btn.dataset.status || 'Active';

        // Reset kelas selections (checkboxes)
        const kelasSelected = btn.dataset.kelas ? JSON.parse(btn.dataset.kelas) : [];
        Array.from(editKelasGroup.querySelectorAll('input[type="checkbox"]')).forEach(cb => {
          cb.checked = kelasSelected.includes(cb.value);
        });

        editModal.show();
      });
    });
  });
</script>
@endsection
