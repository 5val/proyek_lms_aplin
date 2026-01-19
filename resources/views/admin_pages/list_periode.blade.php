@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="average-card-custom">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h3 class="average-card-title mb-0">List Periode</h3>
                <a href="/admin/add_periode" class="btn btn-primary btn-sm">Tambah</a>
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
                    <input type="text" class="form-control form-control-sm bg-dark text-light border-secondary" id="tableSearch" placeholder="Cari periode..." style="width: 240px;">
                </div>
            </div>

            <div class="table-responsive-custom">
                <table class="average-table table-bordered table-lg align-middle mb-0 no-data-table" id="periodeTable">
                    <thead class="table-header-custom">
                        <tr>
                            <th>Nama Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">Memuat data...</td>
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

    <!-- Modal Edit Periode -->
    <div class="modal fade" id="editPeriodeModal" tabindex="-1" aria-labelledby="editPeriodeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editPeriodeForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPeriodeLabel">Edit Periode</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editPeriodeName" class="form-label">Nama Periode</label>
                            <input type="text" class="form-control" id="editPeriodeName" name="periode" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById('editPeriodeModal');
            const modal = modalElement ? new bootstrap.Modal(modalElement) : null;
            const form = document.getElementById('editPeriodeForm');
            const nameInput = document.getElementById('editPeriodeName');

            const data = @json($periodeList);
            const $tableBody = $('#periodeTable tbody');
            const $summary = $('#tableSummary');
            const $search = $('#tableSearch');
            const $pageSizeSelect = $('#pageSizeSelect');
            const $prevBtn = $('#prevPage');
            const $nextBtn = $('#nextPage');

            let periodeData = Array.isArray(data) ? data : [];
            let currentPage = 1;
            let pageSize = parseInt($pageSizeSelect.val(), 10) || 10;

            function escapeHtml(str) {
                return $('<div>').text(str ?? '').html();
            }

            function renderTable() {
                const term = $search.val().toLowerCase();
                const filtered = term
                    ? periodeData.filter((item) => `${item.PERIODE}`.toLowerCase().includes(term))
                    : [...periodeData];

                const total = filtered.length;
                const totalPages = Math.max(1, Math.ceil(total / pageSize));
                currentPage = Math.min(currentPage, totalPages);

                const startIndex = total === 0 ? 0 : (currentPage - 1) * pageSize;
                const pageItems = filtered.slice(startIndex, startIndex + pageSize);

                if (pageItems.length === 0) {
                    $tableBody.html('<tr><td colspan="2" class="text-center text-muted py-4">Tidak ada periode.</td></tr>');
                } else {
                    const rows = pageItems.map((item) => {
                        const id = escapeHtml(item.ID_PERIODE);
                        const nama = escapeHtml(item.PERIODE);
                        return `
                            <tr>
                                <td>${nama}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                        <button type="button" class="btn btn-primary btn-sm edit-periode" data-id="${id}" data-name="${nama}" title="Edit">
                                            <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                        </button>
                                        <a class="btn btn-primary btn-sm" href="/admin/delete_periode/${id}" title="Hapus">
                                            <i class="bi bi-trash" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }).join('');

                    $tableBody.html(rows);
                }

                const start = total === 0 ? 0 : startIndex + 1;
                const end = total === 0 ? 0 : Math.min(startIndex + pageSize, total);
                $summary.text(`Showing ${start} to ${end} of ${total} entries`);

                $prevBtn.prop('disabled', currentPage <= 1 || total === 0);
                $nextBtn.prop('disabled', currentPage >= totalPages || total === 0);

                attachEditHandlers();
            }

            function attachEditHandlers() {
                if (!modal) return;
                document.querySelectorAll('.edit-periode').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        const id = this.dataset.id;
                        const name = this.dataset.name;

                        form.action = `/admin/update_periode/${id}`;
                        nameInput.value = name;

                        modal.show();
                    });
                });
            }

            $search.add($pageSizeSelect).on('input change', function () {
                currentPage = 1;
                pageSize = parseInt($pageSizeSelect.val(), 10) || 10;
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

            renderTable();
        });
    </script>
@endsection
