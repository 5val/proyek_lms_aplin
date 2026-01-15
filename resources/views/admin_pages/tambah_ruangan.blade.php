<div class="modal fade" id="ruanganModal" tabindex="-1" aria-labelledby="ruanganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="ruanganModalLabel">Tambah Ruangan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/tambah_ruangan" method="POST" id="formMapel">
                    @csrf
                    <input type="hidden" name="id_ruangan" id="id_ruangan">
                    <div class="mb-3">
                        <label for="kode_ruangan" class="form-label">Kode Ruangan</label>
                        <input class="form-control bg-dark text-light border-secondary" type="text" name="kode_ruangan" id="kode_ruangan" aria-label="Kode Ruangan">
                    </div>
                    <div class="mb-3">
                        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                        <input class="form-control bg-dark text-light border-secondary" type="text" name="nama_ruangan" id="nama_ruangan" aria-label="Nama Ruangan">
                    </div>
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas</label>
                        <input class="form-control bg-dark text-light border-secondary" type="text" name="nama_kelas" id="nama_kelas" aria-label="Nama Kelas">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-success" type="submit" id="ruanganSubmitBtn">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
