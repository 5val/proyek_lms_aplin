@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-4">
        <div class="average-card-custom">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h3 class="average-card-title mb-0">Laporan Guru</h3>
                <form method="GET" action="/admin/laporanguru" class="d-flex align-items-center gap-2 flex-wrap mb-0">
                    <label for="periodeSelect" class="text-muted small mb-0">Periode:</label>
                    <select name="periodeSelect" id="periodeSelect" class="form-select form-select-sm bg-dark text-light border-secondary" onchange="this.form.submit()" style="width: 220px;">
                        @foreach($all_periode as $p)
                            <option value="{{ $p->ID_PERIODE }}" {{ $periode->ID_PERIODE == $p->ID_PERIODE ? 'selected' : '' }}>
                                {{ $p->PERIODE }}
                            </option>
                        @endforeach
                    </select>
                </form>
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
                    <input type="text" class="form-control form-control-sm bg-dark text-light border-secondary" id="tableSearch" placeholder="Cari guru..." style="width: 240px;">
                </div>
            </div>

            <div class="table-responsive-custom">
                <table class="average-table table-bordered table-lg align-middle mb-0 no-data-table" id="guruTable">
                    <thead class="table-header-custom">
                        <tr>
                            <th>ID Guru</th>
                            <th>Nama Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Memuat data...</td>
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
            const data = @json($all_guru);
            const periodeId = @json($periode->ID_PERIODE);

            const $tableBody = $('#guruTable tbody');
            const $summary = $('#tableSummary');
            const $search = $('#tableSearch');
            const $pageSizeSelect = $('#pageSizeSelect');
            const $prevBtn = $('#prevPage');
            const $nextBtn = $('#nextPage');

            let guruData = Array.isArray(data) ? data : [];
            let currentPage = 1;
            let pageSize = parseInt($pageSizeSelect.val(), 10) || 10;

            function escapeHtml(str) {
                return $('<div>').text(str ?? '').html();
            }

            function renderTable() {
                const term = $search.val().toLowerCase();
                const filtered = term
                    ? guruData.filter((item) => `${item.ID_GURU} ${item.NAMA_GURU}`.toLowerCase().includes(term))
                    : [...guruData];

                const total = filtered.length;
                const totalPages = Math.max(1, Math.ceil(total / pageSize));
                currentPage = Math.min(currentPage, totalPages);

                const startIndex = total === 0 ? 0 : (currentPage - 1) * pageSize;
                const pageItems = filtered.slice(startIndex, startIndex + pageSize);

                if (pageItems.length === 0) {
                    $tableBody.html('<tr><td colspan="3" class="text-center text-muted py-4">Tidak ada guru.</td></tr>');
                } else {
                    const rows = pageItems.map((item) => {
                        const id = escapeHtml(item.ID_GURU);
                        const nama = escapeHtml(item.NAMA_GURU);
                        const url = `/admin/report/guru/${periodeId}/${id}`;
                        return `
                            <tr>
                                <td>${id}</td>
                                <td>${nama}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                        <a href="${url}" class="btn btn-primary btn-sm">Report</a>
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
            }

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

            renderTable();
        });
    </script>
@endsection