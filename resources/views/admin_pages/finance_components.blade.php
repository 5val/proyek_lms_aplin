@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="average-card-title mb-0">Komponen Biaya</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#componentModal" onclick="resetComponentForm()">Tambah Komponen</button>
            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="resetCategoryForm()">Tambah Kategori</button>
            <a href="{{ route('admin.finance.fees') }}" class="btn btn-outline-secondary btn-sm">Lihat Tagihan</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="average-card-custom mb-3">
        <div class="card-body p-3">
            <h6 class="average-card-title">Kategori Komponen</h6>
            <div class="table-responsive-custom mt-2">
                <table class="average-table table-bordered table-lg align-middle mb-0 no-data-table">
                    <thead class="table-header-custom">
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td>{{ $cat->NAME }}</td>
                                <td>{{ $cat->STATUS }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="fillCategory({{ $cat->ID_CATEGORY }}, '{{ $cat->NAME }}', '{{ $cat->STATUS }}')">Edit</button>
                                        <form method="POST" action="{{ route('admin.finance.category.delete', $cat->ID_CATEGORY) }}" onsubmit="return confirm('Hapus kategori?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada kategori</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="average-card-custom">
        <div class="table-responsive-custom">
            <table class="average-table table-bordered table-lg align-middle mb-0 no-data-table">
                <thead class="table-header-custom">
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah Default</th>
                        <th>Sifat</th>
                        <th>Kategori</th>
                        <th>Auto</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($components as $c)
                    <tr>
                        <td>{{ $c->NAME }}</td>
                        <td>Rp {{ number_format($c->AMOUNT_DEFAULT, 0, ',', '.') }}</td>
                        <td>{{ $c->TYPE }}</td>
                        <td>{{ $c->category->NAME ?? '-' }}</td>
                        <td>{{ $c->AUTO_BILL ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $c->STATUS }}</td>
                        <td>{{ $c->DESCRIPTION }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#componentModal" onclick="fillComponent({{ $c->ID_COMPONENT }}, '{{ $c->NAME }}', '{{ $c->AMOUNT_DEFAULT }}', '{{ $c->TYPE }}', '{{ $c->ID_CATEGORY }}', '{{ $c->STATUS }}', '{{ $c->DESCRIPTION }}', {{ $c->AUTO_BILL ? 'true' : 'false' }})">Edit</button>
                                <form method="POST" action="{{ route('admin.finance.component.delete', $c->ID_COMPONENT) }}" onsubmit="return confirm('Hapus komponen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
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

<script>
    function fillCategory(id, name, status) {
        document.getElementById('id_category').value = id;
        const form = document.getElementById('categoryForm');
        form.querySelector('input[name="name"]').value = name;
        form.querySelector('select[name="status"]').value = status;
    }

    function fillComponent(id, name, amount, type, categoryId, status, description, autoBill = false) {
        document.getElementById('id_component').value = id;
        const form = document.getElementById('componentForm');
        form.querySelector('input[name="name"]').value = name;
        form.querySelector('input[name="amount_default"]').value = amount;
        form.querySelector('select[name="type"]').value = type;
        form.querySelector('select[name="category_id"]').value = categoryId || '';
        form.querySelector('select[name="status"]').value = status;
        form.querySelector('textarea[name="description"]').value = description || '';
        form.querySelector('input[name="auto_bill"]').checked = !!autoBill;
    }

        function resetComponentForm() {
                fillComponent('', '', '', 'Wajib', '', 'Active', '');
        }

        function resetCategoryForm() {
                document.getElementById('id_category').value = '';
                const form = document.getElementById('categoryForm');
                form.querySelector('input[name="name"]').value = '';
                form.querySelector('select[name="status"]').value = 'Active';
                form.querySelector('textarea[name="description"]').value = '';
                form.querySelector('input[name="auto_bill"]').checked = false;
        }
</script>

<!-- Component Modal -->
<div class="modal fade" id="componentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Simpan Komponen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.finance.component.store') }}" id="componentForm">
                        @csrf
                        <input type="hidden" name="id_component" id="id_component">
                        <div class="col-md-6">
                                <label class="form-label">Nama Komponen</label>
                                <input name="name" class="form-control" placeholder="Nama komponen" required>
                        </div>
                        <div class="col-md-6">
                                <label class="form-label">Jumlah Default</label>
                                <input name="amount_default" type="number" step="0.01" class="form-control" placeholder="Jumlah" required>
                        </div>
                        <div class="col-md-4">
                                <label class="form-label">Sifat</label>
                                <select name="type" class="form-select">
                                        <option value="Wajib">Wajib</option>
                                        <option value="Tambahan">Tambahan</option>
                                </select>
                        </div>
                        <div class="col-md-4">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select">
                                        <option value="">-- Kategori --</option>
                                        @foreach($categories as $cat)
                                                <option value="{{ $cat->ID_CATEGORY }}">{{ $cat->NAME }}</option>
                                        @endforeach
                                </select>
                        </div>
                        <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" value="1" name="auto_bill" id="auto_bill">
                                <label class="form-check-label" for="auto_bill">Auto tagih default</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi"></textarea>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="componentForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Simpan Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.finance.category.store') }}" id="categoryForm">
                        @csrf
                        <input type="hidden" name="id_category" id="id_category">
                        <div class="col-12">
                                <label class="form-label">Nama Kategori</label>
                                <input name="name" class="form-control" placeholder="Nama kategori" required>
                        </div>
                        <div class="col-12">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                </select>
                        </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="categoryForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection
