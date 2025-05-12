@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
          <h4 class="mb-3">Jadwal Mengajar</h4>
           <?php $listHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
            $listJam = ['07:00', '08:30', '10:30', '12:30'];
            ?>
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
               <?php foreach ($listHari as $hari): ?>
                     <tr>
                        <td>{{ $hari }}</td>
                        <?php foreach ($listJam as $jam): ?>
                           <?php if(isset($jadwal[$hari][$jam])): ?>
                              <td>{{ $jadwal[$hari][$jam]->pelajaran->NAMA_PELAJARAN }} ({{ $jadwal[$hari][$jam]->kelas->detailKelas->NAMA_KELAS }})</td>
                           <?php else: ?>
                              <td>-</td>
                           <?php endif; ?>
                        <?php endforeach; ?>
                     </tr>
                  <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
@endsection