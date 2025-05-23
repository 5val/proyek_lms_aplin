@extends('layouts.guru_app')

@section('guru_content')
<div class="container mt-4">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <br>
            <h4 class="text-center mb-4">Edit Nilai Ujian</h4><br>

            <form method="POST" action="/guru/edit_nilai_ujian">
                  @csrf
                  @method("PUT") 
                  <input type="hidden" name="ID_NILAI" value="{{ $nilai->ID_NILAI }}">
                  <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
                <div class="row mb-3">
                    <label for="id" class="col-sm-3 col-form-label">ID Siswa :</label>
                    <div class="col-sm-9">
                        {{ $nilai->siswa->ID_SISWA }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nama" class="col-sm-3 col-form-label">Nama :</label>
                    <div class="col-sm-9">
                        {{ $nilai->siswa->NAMA_SISWA }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="namatugas" class="col-sm-3 col-form-label">Mata Pelajaran :</label>
                    <div class="col-sm-9">
                        {{ $mata_pelajaran->pelajaran->NAMA_PELAJARAN }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nilaiuts" class="col-sm-3 col-form-label">Nilai UTS :</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="nilaiuts" name="nilai_uts" value="{{ $nilai->NILAI_UTS }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nilaiuas" class="col-sm-3 col-form-label">Nilai UAS :</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="nilaiuas" name="nilai_uas" value="{{ $nilai->NILAI_UAS }}">
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
