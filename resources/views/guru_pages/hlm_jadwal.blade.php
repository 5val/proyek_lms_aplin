@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
          <h4 class="mb-3">Jadwal Mengajar</h4>
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
                  <td>Matematika (X IPA 1)</td>
                  <td>Matematika (X IPA 2)</td>
                  <td>-</td>
                  <td>Fisika (XI IPA 1)</td>
                </tr>
                <tr>
                  <th>Selasa</th>
                  <td>Fisika (XI IPA 2)</td>
                  <td>Matematika (XII IPA 1)</td>
                  <td>-</td>
                  <td>Waktu Luang</td>
                </tr>
                <tr>
                  <th>Rabu</th>
                  <td>Matematika (X IPA 1)</td>
                  <td>Fisika (XII IPA 2)</td>
                  <td>Fisika (X IPA 2)</td>
                  <td>-</td>
                </tr>
                <tr>
                  <th>Kamis</th>
                  <td>Matematika (XI IPA 1)</td>
                  <td>Matematika (XI IPA 2)</td>
                  <td>-</td>
                  <td>Fisika (X IPA 1)</td>
                </tr>
                <tr>
                  <th>Jumat</th>
                  <td>Pembinaan Guru</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
@endsection