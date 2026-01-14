@extends('layouts.admin_app')

@section('admin_content')
  <div class="container mt-5">
    <div class="average-card-custom">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div class="d-flex align-items-center gap-3 flex-wrap">
          <h3 class="average-card-title mb-0">List Kelas</h3>
          <div class="d-flex align-items-center gap-2">
            <label for="semesterSelect" class="text-light small mb-0">Periode</label>
            <select class="form-select form-select-sm bg-dark text-light border-secondary" id="semesterSelect" style="width: 220px;">
              <?php foreach ($semesters as $semester): ?>
              <option value="{{ $semester->ID_PERIODE }}" <?= $semester->ID_PERIODE == $latestPeriode ? 'selected' : '' ?>>
                <?= $semester->PERIODE ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <a href="/admin/tambah_kelas" class="btn btn-primary btn-sm">Tambah</a>
          <a href="/admin/upload_kelas" class="btn btn-primary btn-sm">Upload Kelas</a>
          <a href="/admin/upload_siswa_ke_kelas" class="btn btn-primary btn-sm">Upload Siswa</a>
        </div>
      </div>

      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div class="d-flex align-items-center gap-2">
          <span class="text-light small">Show</span>
          <select id="pageSizeSelect" class="form-select form-select-sm bg-dark text-light border-secondary" style="width: 80px;">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
          </select>
          <span class="text-light small">entries</span>
        </div>
        <div class="d-flex align-items-center gap-2">
          <label for="tableSearch" class="text-light small mb-0">Search:</label>
          <input type="text" class="form-control form-control-sm bg-dark text-light border-secondary" id="tableSearch" placeholder="Cari kelas..." style="width: 240px;">
        </div>
      </div>

      <div class="table-responsive-custom">
        <table class="average-table table-bordered table-lg align-middle mb-0 no-data-table" id="classTable">
          <thead class="table-header-custom">
          <tr>
            <th>Kode Kelas</th>
            <th>Wali Kelas</th>
            <th>Ruangan</th>
            <th>Kelas</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="5" class="text-center text-light py-4">Memuat data...</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
        <small class="text-light" id="tableSummary">Showing 0 to 0 of 0 entries</small>
        <div class="d-flex gap-2">
          <button class="btn btn-secondary btn-sm" id="prevPage">Previous</button>
          <button class="btn btn-secondary btn-sm" id="nextPage">Next</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      const $tableBody = $('#classTable tbody');
      const $summary = $('#tableSummary');
      const $search = $('#tableSearch');
      const $pageSizeSelect = $('#pageSizeSelect');
      const $prevBtn = $('#prevPage');
      const $nextBtn = $('#nextPage');
      const $semesterSelect = $('#semesterSelect');

      let kelasData = [];
      let currentPage = 1;
      let pageSize = parseInt($pageSizeSelect.val(), 10) || 10;

      function renderTable() {
        const term = $search.val().toLowerCase();
        const filtered = term
          ? kelasData.filter((kelas) => `${kelas.id_kelas} ${kelas.nama_wali} ${kelas.ruangan_kelas} ${kelas.nama_kelas}`.toLowerCase().includes(term))
          : [...kelasData];

        const total = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / pageSize));
        currentPage = Math.min(currentPage, totalPages);

        const startIndex = total === 0 ? 0 : (currentPage - 1) * pageSize;
        const pageItems = filtered.slice(startIndex, startIndex + pageSize);

        if (pageItems.length === 0) {
          $tableBody.html('<tr><td colspan="5" class="text-center text-light py-4">Tidak ada data kelas.</td></tr>');
        } else {
          const rows = pageItems.map((kelas) => `
              <tr>
                <td>${kelas.id_kelas}</td>
                <td>${kelas.nama_wali}</td>
                <td>${kelas.ruangan_kelas}</td>
                <td>${kelas.nama_kelas}</td>
                <td>
                  <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                    <a href="/admin/list_mata_pelajaran/${kelas.id_kelas}" class="btn btn-primary btn-sm" title="Detail">
                      <i class="bi bi-eye"></i>
                    </a>
                    <a href="/admin/list_tambah_siswa_ke_kelas/${kelas.id_kelas}" class="btn btn-primary btn-sm" title="List Siswa">
                      <i class="bi bi-people"></i>
                    </a>
                    <a href="/admin/edit_kelas/${kelas.id_kelas}" class="btn btn-primary btn-sm" title="Edit">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <button class="btn btn-primary btn-sm delete-class" data-id="${kelas.id_kelas}" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            `).join('');

          $tableBody.html(rows);
        }

        const start = total === 0 ? 0 : startIndex + 1;
        const end = total === 0 ? 0 : Math.min(startIndex + pageSize, total);
        $summary.text(`Showing ${start} to ${end} of ${total} entries`);

        $prevBtn.prop('disabled', currentPage <= 1 || total === 0);
        $nextBtn.prop('disabled', currentPage >= totalPages || total === 0);
      }

      function loadKelas(periodeId) {
        $tableBody.html('<tr><td colspan="5" class="text-center text-light py-4">Memuat data...</td></tr>');

        $.ajax({
          url: '/admin/get_classes/' + periodeId,
          type: 'GET',
          success: function (data) {
            kelasData = data || [];
            currentPage = 1;
            renderTable();
          },
          error: function (xhr) {
            $tableBody.html('<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data.</td></tr>');
            console.error('Failed to load kelas:', xhr.responseText);
          }
        });
      }

      $('body').on('click', '.delete-class', function () {
        const classId = $(this).data('id');
        if (!confirm('Yakin mau delete kelas?')) return;

        $.ajax({
          url: '/admin/delete_class/' + classId,
          type: 'GET',
          data: {
            "_token": "{{ csrf_token() }}",
          },
          success: function (response) {
            alert(response.message);
            kelasData = kelasData.filter((kelas) => String(kelas.id_kelas) !== String(classId));
            renderTable();
          },
          error: function (xhr) {
            const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText;
            alert('Error deleting class: ' + message);
          }
        });
      });

      $search.on('input', function () {
        currentPage = 1;
        renderTable();
      });

      $pageSizeSelect.on('change', function () {
        pageSize = parseInt($(this).val(), 10) || 10;
        currentPage = 1;
        renderTable();
      });

      $prevBtn.on('click', function () {
        if (currentPage > 1) {
          currentPage -= 1;
          renderTable();
        }
      });

      $nextBtn.on('click', function () {
        currentPage += 1;
        renderTable();
      });

      $semesterSelect.on('change', function () {
        const periodeId = $(this).val();
        loadKelas(periodeId);
      });

      loadKelas($semesterSelect.val());
    });

  </script>

@endsection
