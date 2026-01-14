@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-2">
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

        @include('admin_pages.tambah_ruangan')

        <div class="average-card-custom mt-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h3 class="average-card-title mb-0">List Ruangan</h3>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Show</span>
                    <select id="pageSizeSelect" class="form-select form-select-sm bg-dark text-light border-secondary" style="width: 80px;">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-muted small">entries</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label for="tableSearch" class="text-muted small mb-0">Search:</label>
                    <input type="text" class="form-control form-control-sm bg-dark text-light border-secondary" id="tableSearch" placeholder="Cari ruangan..." style="width: 240px;">
                </div>
            </div>

            <div class="table-responsive-custom">
                <table class="average-table table-bordered table-lg align-middle mb-0 no-data-table" id="ruanganTable">
                    <thead class="table-header-custom">
                        <tr>
                            <th>ID Ruangan</th>
                            <th>Nama Ruangan</th>
                            <th>Nama Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                <small class="text-muted" id="tableSummary">Showing 0 to 0 of 0 entries</small>
                <div class="d-flex gap-2">
                    <button class="btn btn-secondary btn-sm" id="prevPage">Previous</button>
                    <button class="btn btn-secondary btn-sm" id="nextPage">Next</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            const data = @json($ruanganList);
            const $tableBody = $('#ruanganTable tbody');
            const $summary = $('#tableSummary');
            const $search = $('#tableSearch');
            const $pageSizeSelect = $('#pageSizeSelect');
            const $prevBtn = $('#prevPage');
            const $nextBtn = $('#nextPage');

            $('#formMapel').attr('action', '/admin/list_ruangan');

            let ruanganData = Array.isArray(data) ? data : [];
            let currentPage = 1;
            let pageSize = parseInt($pageSizeSelect.val(), 10) || 10;

            function escapeHtml(str) {
                return $('<div>').text(str ?? '').html();
            }

            function renderTable() {
                const term = $search.val().toLowerCase();
                const filtered = term
                    ? ruanganData.filter((item) => `${item.ID_DETAIL_KELAS} ${item.RUANGAN_KELAS} ${item.NAMA_KELAS}`.toLowerCase().includes(term))
                    : [...ruanganData];

                const total = filtered.length;
                const totalPages = Math.max(1, Math.ceil(total / pageSize));
                currentPage = Math.min(currentPage, totalPages);

                const startIndex = total === 0 ? 0 : (currentPage - 1) * pageSize;
                const pageItems = filtered.slice(startIndex, startIndex + pageSize);

                if (pageItems.length === 0) {
                    $tableBody.html('<tr><td colspan="4" class="text-center text-muted py-4">Tidak ada ruangan.</td></tr>');
                } else {
                    const rows = pageItems.map((item) => {
                        const id = escapeHtml(item.ID_DETAIL_KELAS);
                        const ruangan = escapeHtml(item.RUANGAN_KELAS);
                        const namaKelas = escapeHtml(item.NAMA_KELAS);
                        return `
                            <tr>
                                <td class="id_ruangan">${id}</td>
                                <td class="ruangan_kelas">${ruangan}</td>
                                <td class="nama_kelas">${namaKelas}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                        <button type="button" class="btn btn-primary btn-sm edit_btn" data-id="${id}" title="Edit">
                                            <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                        </button>
                                        <a class="btn btn-primary btn-sm text-white" href="/admin/delete_ruangan/${id}" title="Delete">
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
                $('body').off('click', '.edit_btn');
                $('body').on('click', '.edit_btn', function () {
                    const $currentRow = $(this).closest('tr');
                    const idRuangan = $currentRow.find('.id_ruangan').text().trim();
                    const ruanganKelas = $currentRow.find('.ruangan_kelas').text().trim();
                    const namaKelas = $currentRow.find('.nama_kelas').text().trim();

                    $('#formMapel').attr('action', '/admin/edit_ruangan');
                    if (idRuangan) {
                        $('#id_ruangan').val(idRuangan);
                    }
                    if (ruanganKelas) {
                        $('#nama_ruangan').prop('readonly', true);
                        $('#nama_ruangan').val(ruanganKelas);
                    }
                    if (namaKelas) {
                        $('#nama_kelas').val(namaKelas);
                    }
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
