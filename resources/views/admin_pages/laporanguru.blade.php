@extends('layouts.admin_app')

@section('admin_content')
  <div>
   <h5 class="mt-4">Laporan Guru</h5>
   <form method="GET" action="/admin/laporanguru" class="mb-4">
        <label for="periodeSelect" class="form-label">Pilih Periode:</label>
        <select name="periodeSelect" id="periodeSelect" class="form-select" onchange="this.form.submit()">
            @foreach($all_periode as $p)
                <option value="{{ $p->ID_PERIODE }}" {{ $periode->ID_PERIODE == $p->ID_PERIODE ? 'selected' : '' }}>
                    {{ $p->PERIODE }}
                </option>
            @endforeach
        </select>
    </form>
   <div class="table-responsive">
   <table class="table table-bordered bg-white">
         <thead class="table-secondary">
         <tr>
            <th>ID Guru</th>
            <th>Nama Guru</th>
            <th>Aksi</th>
         </tr>
         </thead>
         <tbody>
         <?php foreach ($all_guru as $guru): ?>
            <tr>
                  <td>{{ $guru->ID_GURU }}</td>
                  <td>{{ $guru->NAMA_GURU }}</td>
                  <td><a href="{{ route('admin.report.guru', ['id_periode' => $periode->ID_PERIODE, "id_guru" => $guru->ID_GURU]) }}" class="btn btn-primary mb-3">Report</a></td>
                  
               </tr>
            <?php endforeach; ?>
            </tbody>
      </table>
      </div>
  </div>
@endsection