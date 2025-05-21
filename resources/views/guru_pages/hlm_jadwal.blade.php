@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
    <h4 class="mb-3">Jadwal Mengajar</h4>

    @php
        $listHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $listJam = ['07:00-08:30', '08:30-10:00', '10:00-11:30', '12:00-13:30', '13:30-15:00'];
    @endphp

    <div class="table-responsive">
        <table class="table table-bordered timetable-table bg-white">
            <thead class="table-primary">
                <tr>
                    <th>Hari</th>
                    <th>Jam ke-1 (07:00 - 08:30)</th>
                    <th>Jam ke-2 (08:30 - 10:00)</th>
                    <th>Jam ke-3 (10:00 - 11:30)</th>
                    <th>Jam ke-4 (12:00 - 13:30)</th>
                    <th>Jam ke-5 (13:30 - 15:00)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listHari as $hari)
                    <tr>
                        <td>{{ $hari }}</td>
                        @foreach ($listJam as $jam)
                            @if (isset($jadwal[$hari][$jam]))
                                <td>{{ $jadwal[$hari][$jam]->nama_pelajaran }} ({{ $jadwal[$hari][$jam]->nama_kelas}})</td>
                            @else
                                <td>-</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
