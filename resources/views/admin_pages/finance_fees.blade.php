@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="average-card-title mb-0">Tagihan Siswa</h3>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.finance.components') }}">Komponen</a>
            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#feeModal" onclick="resetFeeForm()">Buat Tagihan</button>
        </div>
    </div>

    <form method="GET" class="average-card-custom p-3 mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-light">Filter Periode</label>
                <select name="periode" class="form-select">
                    <option value="all">Semua Periode</option>
                    @foreach($periodes as $p)
                        <option value="{{ $p->ID_PERIODE }}" {{ ($selectedPeriode ?? 'all') == $p->ID_PERIODE ? 'selected' : '' }}>{{ $p->PERIODE }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">Terapkan</button>
                <a class="btn btn-outline-secondary w-100" href="{{ route('admin.finance.fees') }}">Reset</a>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $paidCount = $fees->where('STATUS', 'Paid')->count();
        $unpaidCount = $fees->where('STATUS', 'Unpaid')->count();
        $overdueCount = $fees->where('STATUS', 'Overdue')->count();
    @endphp

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="average-card-custom p-3 d-flex justify-content-between align-items-center">
                <span class="text-light">Sudah bayar</span>
                <span class="fw-bold text-success">{{ $paidCount }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="average-card-custom p-3 d-flex justify-content-between align-items-center">
                <span class="text-light">Belum bayar</span>
                <span class="fw-bold text-danger">{{ $unpaidCount }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="average-card-custom p-3 d-flex justify-content-between align-items-center">
                <span class="text-light">Terlambat</span>
                <span class="fw-bold text-warning">{{ $overdueCount }}</span>
            </div>
        </div>
    </div>

    @php
        $feesByCategory = $fees->groupBy(fn($f) => $f->component->category->NAME ?? 'Tanpa Kategori');
        $feesByStatus = $fees->groupBy('STATUS');
    @endphp

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="average-card-custom p-3">
                <h5 class="text-light mb-3">Ringkasan per Kategori</h5>
                <div class="table-responsive-custom">
                    <table class="average-table table-bordered align-middle mb-0 text-light no-data-table">
                        <thead class="table-header-custom">
                            <tr>
                                <th>Kategori</th>
                                <th>Jumlah Tagihan</th>
                                <th>Total Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="text-light">
                            @forelse($feesByCategory as $cat => $items)
                                @php($totalCat = $items->sum('AMOUNT'))
                                <tr>
                                    <td>{{ $cat }}</td>
                                    <td>{{ $items->count() }}</td>
                                    <td>Rp {{ number_format($totalCat, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-light">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="average-card-custom p-3">
                <h5 class="text-light mb-3">Ringkasan per Status</h5>
                <div class="table-responsive-custom">
                    <table class="average-table table-bordered align-middle mb-0 text-light no-data-table">
                        <thead class="table-header-custom">
                            <tr>
                                <th>Status</th>
                                <th>Jumlah Tagihan</th>
                                <th>Total Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="text-light">
                            @forelse($feesByStatus as $status => $items)
                                @php($totalStatus = $items->sum('AMOUNT'))
                                <tr>
                                    <td>{{ $status }}</td>
                                    <td>{{ $items->count() }}</td>
                                    <td>Rp {{ number_format($totalStatus, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-light">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="average-card-custom">
        <div class="table-responsive-custom">
            <table class="average-table table-bordered table-lg align-middle mb-0 no-data-table text-light">
                <thead class="table-header-custom">
                    <tr>
                        <th>Invoice</th>
                        <th>Siswa</th>
                        <th>Periode</th>
                        <th>Komponen</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody class="text-light">
                    @forelse($fees as $f)
                        <tr>
                            <td>{{ $f->INVOICE_CODE }}</td>
                            <td>{{ $f->siswa->NAMA_SISWA ?? '-' }}</td>
                            <td>{{ $f->periode->PERIODE ?? '-' }}</td>
                            <td>{{ $f->component->NAME ?? '-' }}</td>
                            <td>Rp {{ number_format($f->AMOUNT, 0, ',', '.') }}</td>
                            <td>{{ $f->DUE_DATE }}</td>
                            <td>
                                <span class="badge {{ $f->STATUS === 'Paid' ? 'bg-success' : ($f->STATUS === 'Unpaid' ? 'bg-danger' : ($f->STATUS === 'Overdue' ? 'bg-warning text-dark' : 'bg-secondary')) }}">{{ $f->STATUS }}</span>
                            </td>
                            <td class="d-flex gap-1">
                                <form method="POST" action="{{ route('admin.finance.fees.status', $f->ID_STUDENT_FEE) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="Paid">
                                    <button class="btn btn-sm btn-success" type="submit">Tandai Lunas</button>
                                </form>
                                <form method="POST" action="{{ route('admin.finance.fees.status', $f->ID_STUDENT_FEE) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="Unpaid">
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">Belum</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-light">Belum ada tagihan pada periode ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Buat Tagihan -->
<div class="modal fade" id="feeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat Tagihan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="POST" action="{{ route('admin.finance.fees.store') }}" id="feeForm">
            @csrf
            <div class="col-md-6">
                <label class="form-label">Komponen</label>
                <select name="ID_COMPONENT" class="form-select" required id="feeComponentSelect">
                    <option value="">-- pilih komponen --</option>
                    @foreach($components as $c)
                        <option value="{{ $c->ID_COMPONENT }}" data-amount="{{ $c->AMOUNT_DEFAULT }}">{{ $c->NAME }} @if($c->category) ({{ $c->category->NAME }}) @endif</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Periode</label>
                <select name="ID_PERIODE" class="form-select" required>
                    <option value="">-- pilih periode --</option>
                    @foreach($periodes as $p)
                        <option value="{{ $p->ID_PERIODE }}">{{ $p->PERIODE }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Scope Tagihan</label>
                <select name="scope" id="scopeSelect" class="form-select" required>
                    <option value="all_siswa">Semua siswa aktif</option>
                    <option value="kelas">Per kelas</option>
                    <option value="siswa">Pilih siswa</option>
                </select>
            </div>
            <div class="col-md-4 scope-field scope-kelas d-none">
                <label class="form-label">Kelas</label>
                <select name="kelas_ids[]" class="form-select" multiple>
                    @foreach($kelass as $k)
                        <option value="{{ $k->ID_KELAS }}">{{ $k->detailKelas->NAMA_KELAS ?? $k->ID_KELAS }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Tahan Ctrl/Shift untuk pilih banyak.</small>
            </div>
            <div class="col-md-4 scope-field scope-siswa d-none">
                <label class="form-label">Siswa</label>
                <select name="siswa_ids[]" class="form-select" multiple>
                    @foreach($siswas as $s)
                        <option value="{{ $s->ID_SISWA }}">{{ $s->NAMA_SISWA }} ({{ $s->EMAIL_SISWA }})</option>
                    @endforeach
                </select>
                <small class="text-muted">Tahan Ctrl/Shift untuk pilih banyak.</small>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jumlah</label>
                <input name="AMOUNT" id="amount" type="number" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jatuh Tempo</label>
                <input name="DUE_DATE" type="date" class="form-control">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" form="feeForm" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
    const componentSelect = document.getElementById('feeComponentSelect');
    const amountInput = document.getElementById('amount');
    const scopeSelect = document.getElementById('scopeSelect');

    function resetFeeForm() {
        document.getElementById('feeForm').reset();
        toggleScopeFields();
    }

    function toggleScopeFields() {
        const scope = scopeSelect.value;
        document.querySelectorAll('.scope-field').forEach(el => el.classList.add('d-none'));
        if (scope === 'kelas') {
            document.querySelectorAll('.scope-kelas').forEach(el => el.classList.remove('d-none'));
        } else if (scope === 'siswa') {
            document.querySelectorAll('.scope-siswa').forEach(el => el.classList.remove('d-none'));
        }
    }

    scopeSelect?.addEventListener('change', toggleScopeFields);

    componentSelect?.addEventListener('change', (e) => {
        const amt = e.target.selectedOptions[0]?.getAttribute('data-amount');
        if (amt) amountInput.value = amt;
    });

    document.addEventListener('DOMContentLoaded', () => {
        toggleScopeFields();
    });
</script>
@endsection
