<div class="material-box">
    <br>
    <h4 style="text-align: center;">Tambah Ruangan</h4><br>
    <div class="mb-3">
        <form action="/admin/tambah_ruangan" method="POST" id="formMapel">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">ID Ruangan</label>
                <input class="form-control" type="text" name="id_ruangan" id="id_ruangan"
                    aria-label="default input example" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nama Ruangan</label>
                <input class="form-control" type="text" name="nama_ruangan" id="nama_ruangan"
                    aria-label="default input example">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Nama Kelas</label>
                <input class="form-control" type="text" name="nama_kelas" id="nama_kelas"
                    aria-label="default input example">
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-success" type="submit">Tambah</button>
            </div>
        </form>
    </div>
</div>