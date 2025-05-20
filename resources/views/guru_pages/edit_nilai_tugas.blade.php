@extends('layouts.guru_app')

@section('guru_content')
<div class="container mt-4">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <br>
            <h4 class="text-center mb-4">Edit Nilai Tugas</h4><br>

            <form method="POST" action="/guru/edit_nilai_tugas">
                  @csrf
                  @method("PUT") 
                  <input type="hidden" name="ID_SUBMISSION" value="{{ $submission->ID_SUBMISSION }}">
                  <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
                <div class="row mb-3">
                    <label for="id" class="col-sm-3 col-form-label">ID Siswa :</label>
                    <div class="col-sm-9">
                        {{ $submission->siswa->ID_SISWA }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nama" class="col-sm-3 col-form-label">Nama :</label>
                    <div class="col-sm-9">
                        {{ $submission->siswa->NAMA_SISWA }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="namatugas" class="col-sm-3 col-form-label">Nama Tugas :</label>
                    <div class="col-sm-9">
                        {{ $submission->tugas->NAMA_TUGAS }}
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nilaitugas" class="col-sm-3 col-form-label">Nilai Tugas :</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="nilai" id="nilaitugas" name="nilaitugas" value="{{ $submission->NILAI_TUGAS }}">
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
