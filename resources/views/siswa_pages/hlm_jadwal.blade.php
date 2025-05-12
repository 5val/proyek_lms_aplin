@extends('layouts.siswa_app')

@section('siswa_content')
<div class="p-3">
          <h4 class="mb-3">Jadwal Pelajaran</h4>
          <div class="timetable table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Hari</th>
                  <th>Jam ke-1 (07:00 - 08:30)</th>
                  <th>Jam ke-2 (08:30 - 10:00)</th>
                  <th>Jam ke-3 (10:00 - 11:30)</th>
                  <th>Jam ke-4 (12:00 - 13:30)</th>
                  <th>Jam ke-4 (13:30 - 15:00)</th>
                </tr>
              </thead>
              <tbody>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                    <tr>
                        <th>{{ $hari }}</th>
                        @foreach (['07:00-08:30', '08:30-10:00', '10:00-11:30', '12:00-13:30', '13:30-15:00'] as $jam)
                            <td>
                                @if(isset($jadwal[$hari][$jam]))
                                    {{ $jadwal[$hari][$jam] }}
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <!-- <tr>
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
                </tr> -->
              </tbody>
            </table>
          </div>
        </div>
@endsection