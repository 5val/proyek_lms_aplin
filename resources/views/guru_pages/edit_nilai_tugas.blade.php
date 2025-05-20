@extends('layouts.guru_app')

@section('guru_content')
<div class="container mt-4">
    <div class="mb-3">
        <a class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <br>
            <h4 class="text-center mb-4">Edit Nilai Tugas</h4><br>

            <form>
                <div class="row mb-3">
                    <label for="id" class="col-sm-3 col-form-label">ID Siswa :</label>
                    <div class="col-sm-9">
                        2200001
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nama" class="col-sm-3 col-form-label">Nama :</label>
                    <div class="col-sm-9">
                        Daniel
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="kelas" class="col-sm-3 col-form-label">Kelas :</label>
                    <div class="col-sm-9">
                        X IPA 1
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="namatugas" class="col-sm-3 col-form-label">Nama Tugas :</label>
                    <div class="col-sm-9">
                        Persamaan dasar kuadrat
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nilaitugas" class="col-sm-3 col-form-label">Nilai Tugas :</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="nilaitugas" name="nilaitugas" placeholder="80">
                    </div>
                </div>


                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
