<?php
// Mock data
$hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
$waktuList = ['07:00-08:30', '08:30-10:00', '10:00-11:30', '12:00-13:30', '13:30-15:00'];
?>
<div class="container mt-5">
    <h3>Tambah Mata Pelajaran</h3>
    <div class="card mt-3">
        <div class="card-body">
            <form action="/admin/list_mata_pelajaran/<?=$id_kelas?>" method="post">
                @csrf
                <input type="text" hidden name="kelas" value="<?=$id_kelas?>">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="pelajaran" class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="pelajaran" name="pelajaran">
                            <option selected disabled>Pilih Pelajaran</option>
                            <?php foreach ($pelajaranList as $pelajaran): ?>
                            <option value="<?= $pelajaran->ID_PELAJARAN ?>"><?= $pelajaran->NAMA_PELAJARAN ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="hari" class="form-label">Hari</label>
                        <select class="form-select" id="hari" name="hari">
                            <option selected disabled>Pilih Hari</option>
                            <?php foreach ($hariList as $hari):?>
                            <option value="<?=$hari?>"><?=$hari?></option>
                            <?php endforeach; ?>
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
                        @error('waktu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pengajar" class="form-label fw-bold">Guru Pengajar</label>
                    <select class="form-select" id="pengajar" name="pengajar">
                        <option selected disabled>Pilih Guru Pengajar</option>
                        <?php foreach ($guruList as $guru): ?>
                        <option value="<?= $guru->ID_GURU ?>"><?= $guru->NAMA_GURU ?></option>
                        <?php endforeach; ?>
                    </select>
                    @error('pengajar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>