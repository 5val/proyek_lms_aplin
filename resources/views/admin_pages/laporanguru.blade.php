@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <div>
    <div class="material-box">
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">ID Guru</label>
      <input class="form-control" type="text" placeholder="G0012" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Nama Guru</label>
      <input class="form-control" type="text" placeholder="Greyson" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Kelas</label>
      <input class="form-control" type="text" placeholder="X IPA 1" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Mata Pelajaran</label>
      <input class="form-control" type="text" placeholder="Kimia" aria-label="default input example">
    </div>
    <div class="d-grid gap-2">
      <button class="btn btn-success" type="button">Search</button>
    </div>
    </div>

    <br>
    <h4 style="text-align: center;">Laporan Guru</h4><br>
    <table class="table table-bordered align-middle">
    <thead>

      <tr class="thead" style="font-weight: bold; background-color: #608BC1;">
      <td>ID Siswa</td>
      <td>Nama</td>
      <td>Kelas</td>
      <td>Nilai Tugas</td>
      <td>Nilai Ujian</td>
      </tr>
    </thead>
    <tbody>
    <tbody>
      <tr>
      <td>2200001</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      </tr>
      <tr>
      <td>2200002</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      </tr>
      <tr>
      <td>2200003</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      </tr>
      <tr>
      <td>2200004</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      </tr>
      <tr>
      <td>2200005</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      </tr>

    </tbody>
    </table>
  </div>
@endsection