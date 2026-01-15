@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-4">
    <div class="average-card-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="average-card-title mb-0">Master Jam Pelajaran</h3>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJam">Tambah</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="table-responsive-custom mt-2">
            <table class="average-table table-bordered table-lg align-middle">
                <thead class="table-header-custom">
                    <tr>
                        <th>Hari</th>
                        <th>Slot Ke</th>
                        <th>Jenis</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Label</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jamList as $jam)
                        <tr>
                            <td>{{ $jam->HARI_PELAJARAN }}</td>
                            <td>{{ $jam->SLOT_KE }}</td>
                            <td><span class="badge {{ $jam->JENIS_SLOT === 'Istirahat' ? 'bg-warning text-dark' : 'bg-success' }}">{{ $jam->JENIS_SLOT }}</span></td>
                            <td>{{ substr($jam->JAM_MULAI,0,5) }}</td>
                            <td>{{ substr($jam->JAM_SELESAI,0,5) }}</td>
                            <td>{{ $jam->LABEL }}</td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <button class="btn btn-warning btn-sm edit-jam" data-id="{{ $jam->ID_JAM_PELAJARAN }}" data-hari="{{ $jam->HARI_PELAJARAN }}" data-slot="{{ $jam->SLOT_KE }}" data-jenis="{{ $jam->JENIS_SLOT }}" data-mulai="{{ substr($jam->JAM_MULAI,0,5) }}" data-selesai="{{ substr($jam->JAM_SELESAI,0,5) }}" data-label="{{ $jam->LABEL }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('master_jam_pelajaran.delete', $jam->ID_JAM_PELAJARAN) }}" method="POST" onsubmit="return confirm('Hapus slot ini?')">
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
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahJam" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Jam Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('master_jam_pelajaran.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Hari</label>
              <select name="HARI_PELAJARAN" class="form-select" required>
                <option value="">Pilih Hari</option>
                <option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Slot Ke</label>
              <input type="number" name="SLOT_KE" class="form-control" min="1" max="20" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Jenis</label>
              <select name="JENIS_SLOT" class="form-select" required>
                <option value="Pelajaran">Pelajaran</option>
                <option value="Istirahat">Istirahat</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Jam Mulai</label>
              <input type="time" name="JAM_MULAI" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Jam Selesai</label>
              <input type="time" name="JAM_SELESAI" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Label (opsional)</label>
              <input type="text" name="LABEL" class="form-control" placeholder="Contoh: Matematika / Rehat 1">
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
<div class="modal fade" id="modalEditJam" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Jam Pelajaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="editJamForm">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Hari</label>
              <select name="HARI_PELAJARAN" id="editHari" class="form-select" required>
                <option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Slot Ke</label>
              <input type="number" name="SLOT_KE" id="editSlot" class="form-control" min="1" max="20" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Jenis</label>
              <select name="JENIS_SLOT" id="editJenis" class="form-select" required>
                <option value="Pelajaran">Pelajaran</option>
                <option value="Istirahat">Istirahat</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Jam Mulai</label>
              <input type="time" name="JAM_MULAI" id="editMulai" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Jam Selesai</label>
              <input type="time" name="JAM_SELESAI" id="editSelesai" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Label (opsional)</label>
              <input type="text" name="LABEL" id="editLabel" class="form-control" placeholder="Contoh: Matematika / Rehat 1">
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
    const editModal = new bootstrap.Modal(document.getElementById('modalEditJam'));
    const editForm = document.getElementById('editJamForm');
    const editHari = document.getElementById('editHari');
    const editSlot = document.getElementById('editSlot');
    const editJenis = document.getElementById('editJenis');
    const editMulai = document.getElementById('editMulai');
    const editSelesai = document.getElementById('editSelesai');
    const editLabel = document.getElementById('editLabel');
    const updateBaseUrl = "{{ url('/admin/master_jam_pelajaran') }}"; // keep admin prefix for edit

    document.querySelectorAll('.edit-jam').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        editForm.action = `${updateBaseUrl}/${id}`;
        editHari.value = btn.dataset.hari;
        editSlot.value = btn.dataset.slot;
        editJenis.value = btn.dataset.jenis;
        editMulai.value = btn.dataset.mulai;
        editSelesai.value = btn.dataset.selesai;
        editLabel.value = btn.dataset.label;
        editModal.show();
      });
    });
  });
</script>
@endsection
