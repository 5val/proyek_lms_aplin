@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
          <h4 class="mb-3">Jadwal Pelajaran</h4>
          <div class="timetable table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Hari</th>
                  <th>07.00 - 08.30</th>
                  <th>08.30 - 10.00</th>
                  <th>10.30 - 12.00</th>
                  <th>13.00 - 14.30</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>Senin</th>
                  <td>Matematika</td>
                  <td>Bahasa Indonesia</td>
                  <td>Fisika</td>
                  <td>Sejarah</td>
                </tr>
                <tr>
                  <th>Selasa</th>
                  <td>Kimia</td>
                  <td>Bahasa Inggris</td>
                  <td>Biologi</td>
                  <td>Olahraga</td>
                </tr>
                <tr>
                  <th>Rabu</th>
                  <td>Matematika</td>
                  <td>Bahasa Indonesia</td>
                  <td>Fisika</td>
                  <td>Ekonomi</td>
                </tr>
                <tr>
                  <th>Kamis</th>
                  <td>Kimia</td>
                  <td>Bahasa Inggris</td>
                  <td>Seni Budaya</td>
                  <td>Agama</td>
                </tr>
                <tr>
                  <th>Jumat</th>
                  <td>Biologi</td>
                  <td>PKN</td>
                  <td>Prakarya</td>
                  <td>-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
@endsection