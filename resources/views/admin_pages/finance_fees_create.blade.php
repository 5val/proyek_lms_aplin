@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="average-card-title mb-0">Buat Tagihan Siswa</h3>
        <a href="{{ route('admin.finance.fees') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="average-card-custom">
        <div class="card-body">
            <form class="row g-3" method="POST" action="{{ route('admin.finance.fees.store') }}">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Siswa</label>
                    <select name="ID_SISWA" class="form-select" required>
                        <option value="">-- pilih siswa --</option>
                        @foreach($siswas as $s)
                            <option value="{{ $s->ID_SISWA }}">{{ $s->NAMA_SISWA }} ({{ $s->EMAIL_SISWA }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Periode</label>
                    <select name="ID_PERIODE" class="form-select" required>
                        <option value="">-- pilih periode --</option>
                        @foreach($periodes as $p)
                            <option value="{{ $p->ID_PERIODE }}">{{ $p->PERIODE }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Komponen</label>
                    <select name="ID_COMPONENT" class="form-select" required>
                        <option value="">-- pilih komponen --</option>
                        @foreach($components as $c)
                            <option value="{{ $c->ID_COMPONENT }}" data-amount="{{ $c->AMOUNT_DEFAULT }}">{{ $c->NAME }} @if($c->category) ({{ $c->category->NAME }}) @endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah</label>
                    <input name="AMOUNT" id="amount" type="number" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jatuh Tempo</label>
                    <input name="DUE_DATE" type="date" class="form-control">
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('admin.finance.fees') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const selectComponent = document.querySelector('select[name="ID_COMPONENT"]');
    const amountInput = document.getElementById('amount');
    selectComponent?.addEventListener('change', (e) => {
        const opt = e.target.selectedOptions[0];
        const amt = opt ? opt.getAttribute('data-amount') : '';
        if (amt) amountInput.value = amt;
    });
</script>
@endsection
