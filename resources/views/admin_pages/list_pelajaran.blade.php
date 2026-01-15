<?php
// Mock data

?>

@extends('layouts.admin_app')

@section('admin_content')
    <div class="container mt-5">
        <div class="average-card-custom">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="average-card-title mb-0">List Pelajaran</h3>
                <a href="/admin/tambah_pelajaran" class="btn btn-primary btn-sm me-1">Tambah</a>
            </div>

            <div class="table-responsive-custom mt-2">
                <table class="average-table table-bordered table-lg align-middle">
                    <thead class="table-header-custom">
                        <tr>
                            <th>ID Pelajaran</th>
                            <th>Nama Pelajaran</th>
                            <th>Tingkat/Kelas</th>
                            <th>Jam Wajib</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kelasList as $pelajaran): ?>
                        <tr class="{{ $pelajaran->STATUS == "Active" ? "" : "inactive" }}">
                            <td><?= $pelajaran->ID_PELAJARAN ?></td>
                            <td><?= $pelajaran->NAMA_PELAJARAN ?></td>
                            <td>{{ $pelajaran->KELAS_TINGKAT ?? '-' }}</td>
                            <td>{{ $pelajaran->JML_JAM_WAJIB ?? 0 }} jam</td>
                            <td>{{ $pelajaran->STATUS == "Active" ? "Aktif" : "Inaktif" }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <button type="button" class="btn btn-warning btn-sm edit-pelajaran"
                                        data-id="{{ $pelajaran->ID_PELAJARAN }}"
                                        data-name="{{ $pelajaran->NAMA_PELAJARAN }}"
                                        data-status="{{ $pelajaran->STATUS }}"
                                        data-hours="{{ $pelajaran->JML_JAM_WAJIB ?? 0 }}"
                                        data-level="{{ $pelajaran->KELAS_TINGKAT ?? '' }}">
                                        <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                        <span class="visually-hidden">Edit</span>
                                    </button>
                                    <a href="{{ url('/admin/list_pelajaran/' . $pelajaran->ID_PELAJARAN) }}"
                                        class="btn btn-{{ $pelajaran->STATUS == "Active" ? "danger text-white" : "primary" }} btn-sm">
                                        @if ($pelajaran->STATUS == "Active")
                                            <i class="bi bi-trash" aria-hidden="true"></i>
                                            <span class="visually-hidden">Hapus</span>
                                        @else
                                            Buat Aktif
                                        @endif
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pelajaran -->
    <div class="modal fade" id="editPelajaranModal" tabindex="-1" aria-labelledby="editPelajaranLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editPelajaranForm">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPelajaranLabel">Edit Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama Pelajaran</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editClassLevel" class="form-label">Tingkat/Kelas</label>
                            <input type="text" class="form-control" id="editClassLevel" name="class_level" maxlength="50" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRequiredHours" class="form-label">Jumlah Jam Wajib per Minggu</label>
                            <input type="number" class="form-control" id="editRequiredHours" name="required_hours" min="0" max="40" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="Active">Aktif</option>
                                <option value="Inactive">Inaktif</option>
                            </select>
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
            const modal = new bootstrap.Modal(document.getElementById('editPelajaranModal'));
            const form = document.getElementById('editPelajaranForm');
            const nameInput = document.getElementById('editName');
            const levelInput = document.getElementById('editClassLevel');
            const hoursInput = document.getElementById('editRequiredHours');
            const statusSelect = document.getElementById('editStatus');

            document.querySelectorAll('.edit-pelajaran').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const level = this.dataset.level;
                    const hours = this.dataset.hours;
                    const status = this.dataset.status;

                    form.action = `/admin/update_pelajaran/${id}`;
                    nameInput.value = name;
                    levelInput.value = level;
                    hoursInput.value = hours;
                    statusSelect.value = status;

                    modal.show();
                });
            });
        });
    </script>
@endsection
