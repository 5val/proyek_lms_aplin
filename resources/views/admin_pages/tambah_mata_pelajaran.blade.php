<?php
// Mock data
$mataKuliahList = ['Sistem Digital', 'Algoritma dan Pemrograman', 'Basis Data'];
$pelajaranList = ['Bahasa Indonesia', 'Matematika', 'PPKN'];
$waktuList = ['08.00 - 10.00', '10.30 - 12.30', '13.15 - 15.15', '15.45 - 17.45'];
$asistenList = ['Ovaldo', 'Ovaldo OOO', 'Rafael'];
?>
<div class="container mt-5">
    <h3>Tambah Mata Pelajaran</h3>
    <div class="card mt-3">
        <div class="card-body">
            <form action="submit_praktikum.php" method="post">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="pelajaran" class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="pelajaran" name="pelajaran">
                            <option selected disabled>Pilih Pelajaran</option>
                            <?php foreach ($pelajaranList as $pelajaran): ?>
                            <option value="<?= $pelajaran ?>"><?= $pelajaran ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="hari" class="form-label">Hari</label>
                        <select class="form-select" id="hari" name="hari">
                            <option selected disabled>Pilih Hari</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="waktu" class="form-label">Waktu</label>
                        <select class="form-select" id="waktu" name="waktu">
                            <option selected disabled>Pilih Waktu</option>
                            <?php foreach ($waktuList as $jam): ?>
                            <option value="<?= $jam ?>"><?= $jam ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pengajar" class="form-label fw-bold">Guru Pengajar</label>
                    <select class="form-select" id="pengajar" name="pengajar">
                        <option selected disabled>Pilih Guru Pengajar</option>
                        <?php foreach ($asistenList as $asisten): ?>
                        <option value="<?= $asisten ?>"><?= $asisten ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>