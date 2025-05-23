@extends('layouts.admin_app')

@section('admin_content')
  <div class="container mt-5">
    <div class="top-bar d-flex justify-content-between align-items-center border-bottom">
    <div>
      <button class="btn btn-primary me-1">List</button>
      <a href="/admin/tambah_kelas" class="btn me-1">Tambah</a>
      <a href="/admin/upload_kelas" class="btn me-1"> Upload Kelas</a>
      <a href="/admin/upload_siswa" class="btn me-1">Upload Siswa</a>

    </div>
    <div>
      <select class="form-select" id="semesterSelect" style="width: 250px;">
      <?php foreach ($semesters as $semester): ?>
      <option value="{{ $semester->ID_PERIODE }}" <?= $semester->ID_PERIODE == $latestPeriode ? 'selected' : '' ?>>
        <?= $semester->PERIODE ?>
      </option>
      <?php endforeach; ?>
      </select>
    </div>
    </div>
    <h3>List Kelas</h3>

    <!-- Table -->
    <div class="container mt-4">
    <table class="table table-bordered align-middle" id="classTable">
      <thead class="table-light">
      <tr>
        <th>Kode Kelas</th>
        <th>Wali Kelas</th>
        <th>Ruangan</th>
        <th>Kelas</th>
        <th>Aksi</th>
      </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
    $('body').on('click', '.delete-class', function () {
      const classId = $(this).data('id');
      if (confirm('Yakin mau delete kelas?')) {
      // const safeId = classId.replace(/\//g, '__');
      $.ajax({
        url: '/admin/delete_class/' + classId,  // Use the DELETE route
        type: 'GET',
        data: {
        "_token": "{{ csrf_token() }}",  // Add CSRF token for security
        },
        success: function (response) {
        alert(response.message);
        // You can remove the row from the table on success, like:
        $(this).closest('tr').remove();
        },
        error: function (xhr) {
        alert('Error deleting class: ' + xhr.responseJSON.message);
        }
      });
      }
    });

    function loadKelas(periodeId) {
      $.ajax({
      url: '/admin/get_classes/' + periodeId,
      type: 'GET',
      success: function (data) {
        let rows = '';
        data.forEach(function (kelas) {
        rows += `
      <tr>
      <td>${kelas.id_kelas}</td>
      <td>${kelas.nama_wali}</td>
      <td>${kelas.ruangan_kelas}</td>
      <td>${kelas.nama_kelas}</td>
      <td>
      <div class="btn-group" role="group">
      <a href="/admin/list_mata_pelajaran/${kelas.id_kelas}" class="btn btn-outline-primary btn-sm" title="Detail">
      <i class="bi bi-eye"></i>
      </a>
      <a href="/admin/list_tambah_siswa_ke_kelas/${kelas.id_kelas}" class="btn btn-outline-secondary btn-sm" title="List Siswa">
       <i class="bi bi-people"></i>
      </a>
      <a href="/admin/edit_kelas/${kelas.id_kelas}" class="btn btn-outline-warning btn-sm" title="Edit">
      <i class="bi bi-pencil-square"></i>
      </a>
      <button class="btn btn-outline-danger btn-sm delete-class" data-id='${kelas.id_kelas}' title="Hapus">
      <i class="bi bi-trash"></i>
      </button>
      </div>
      </td>
      </tr>
      `;
        });
        $('#classTable tbody').html(rows);
      },
      error: function (xhr) {
        console.error('Failed to load kelas:', xhr.responseText);
      }
      });
    }

    // ini yang pake button biasa :
    // <div class="d-grid gap-1">
    // <a href="/admin/list_mata_pelajaran/${kelas.id_kelas}" class="btn btn-primary btn-sm">Detail Kelas</a>
    // <a href="/admin/list_tambah_siswa_ke_kelas/${kelas.id_kelas}" class="btn btn-primary btn-sm">List Siswa</a>
    // <a href="/admin/edit_kelas/${kelas.id_kelas}" class="btn btn-primary btn-sm">Edit</a>
    // <button class="btn btn-danger btn-sm delete-class" data-id='${kelas.id_kelas}'>Delete</button>
    // </div>

    // Initial load (on page open)
    const selectedPeriode = $('#semesterSelect').val();
    loadKelas(selectedPeriode);

    // Optional: re-load when user selects different semester
    $('#semesterSelect').change(function () {
      const periodeId = $(this).val();
      loadKelas(periodeId);
    });
    });

  </script>

@endsection