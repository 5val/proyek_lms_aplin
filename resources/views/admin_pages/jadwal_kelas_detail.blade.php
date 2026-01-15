@extends('layouts.admin_app')

@section('admin_content')
<div class="container mt-4">
  <a href="{{ route('jadwal_kelas') }}" class="btn btn-danger mb-3">Back</a>
  <div class="average-card-custom mb-3">
    <h4 class="average-card-title mb-2">Jadwal Kelas {{ $kelas->detailKelas->NAMA_KELAS ?? $kelas->ID_KELAS }}</h4>
    <p class="mb-0 text-white">Wali kelas: {{ $kelas->wali->NAMA_GURU ?? 'Belum ditentukan' }}</p>
  </div>

  <div class="row g-3">
    @foreach($daysOrder as $day)
      <div class="col-lg-4">
        <div class="average-card-custom h-100">
          <h6 class="average-card-title mb-2">{{ $day }}</h6>
          <div class="table-responsive">
            <table class="average-table table-bordered align-middle mb-0 no-data-table">
              <thead class="table-header-custom">
                <tr>
                  <th style="width:60px;">Slot</th>
                  <th>Waktu</th>
                  <th>Jenis</th>
                  <th>Mapel</th>
                </tr>
              </thead>
              <tbody>
                @forelse(($slotByDay[$day] ?? collect()) as $slot)
                  <?php $current = $jadwal[$slot->ID_JAM_PELAJARAN] ?? null; ?>
                  <tr>
                    <td class="text-center fw-semibold">{{ $slot->SLOT_KE }}</td>
                    <td>{{ substr($slot->JAM_MULAI,0,5) }} - {{ substr($slot->JAM_SELESAI,0,5) }}</td>
                    <td>
                      <span class="badge {{ $slot->JENIS_SLOT === 'Istirahat' ? 'bg-warning text-dark' : 'bg-success' }}">{{ $slot->JENIS_SLOT }}</span>
                    </td>
                    <td>
                      @if($slot->JENIS_SLOT === 'Istirahat')
                        <span class="text-muted">Istirahat</span>
                      @else
                        <form action="{{ route('jadwal_kelas.assign') }}" method="POST" class="d-flex gap-2">
                          @csrf
                          <input type="hidden" name="ID_KELAS" value="{{ $kelas->ID_KELAS }}">
                          <input type="hidden" name="ID_JAM_PELAJARAN" value="{{ $slot->ID_JAM_PELAJARAN }}">
                          <select name="ID_MATA_PELAJARAN" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Kosongkan --</option>
                            @foreach($mataList as $m)
                              <option value="{{ $m->ID_MATA_PELAJARAN }}" {{ $current && $current->ID_MATA_PELAJARAN === $m->ID_MATA_PELAJARAN ? 'selected' : '' }}>
                                {{ $m->NAMA_PELAJARAN }} @if($m->NAMA_GURU) ({{ $m->NAMA_GURU }}) @endif
                              </option>
                            @endforeach
                          </select>
                        </form>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="4" class="text-center text-muted">Belum ada slot untuk hari ini</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
