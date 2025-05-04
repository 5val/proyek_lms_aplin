@extends('layouts.admin_app')

@section('admin_content')
  <div class="row g-4 mb-4">

  </div>

  <div>
    <div class="material-box">
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">ID Mata Pelajaran</label>
      <input class="form-control" type="text" placeholder="MTKWG0012231" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Nama Mata Pelajaran</label>
      <input class="form-control" type="text" placeholder="Matematika Wajin" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Kelas</label>
      <input class="form-control" type="text" placeholder="X IPA 1" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Periode</label>
      <input class="form-control" type="text" placeholder="2023/Ganjil" aria-label="default input example">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Pengajar</label>
      <input class="form-control" type="text" placeholder="Daniel" aria-label="default input example">
    </div>
    <div class="d-grid gap-2">
      <button class="btn btn-success" type="button">Search</button>
    </div>
    </div>

    <br>
    <h4 style="text-align: center;">Laporan Mata Pelajaran</h4><br>
    <table class="table table-bordered align-middle">
    <thead>
      <tr class="thead" style="font-weight: bold; background-color: #608BC1;">
      <td>ID Siswa</td>
      <td>Nama</td>
      <td>Kelas</td>
      <td>T1</td>
      <td>T2</td>
      <td>T3</td>
      <td>T4</td>
      <td>T5</td>
      <td>T6</td>
      <td>T7</td>
      <td>UH1</td>
      <td>UH2</td>
      <td>UH3</td>
      <td>UH4</td>
      <td>UH5</td>
      <td>UTS</td>
      <td>UAS</td>
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
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      </tr>
      <tr>
      <td>2200002</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      </tr>
      <tr>
      <td>2200003</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      </tr>
      <tr>
      <td>2200004</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      </tr>
      <tr>
      <td>2200005</td>
      <td>Daniel</td>
      <td>X IPA 1</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      <td>80</td>
      <td>78</td>
      </tr>


    </tbody>
    </table>
  </div>
@endsection