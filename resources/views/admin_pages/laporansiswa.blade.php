@extends('layouts.admin_app')

@section('admin_content')
  <div class="p-3">
    <div class="row g-4 mb-4">
    </div>
    <div>
    <br>
    <div class="average-card-custom">
      <h4 class="average-card-title text-center">Laporan Siswa</h4>
      <div class="mb-3">
        <label for="select_periode" class="form-label">Pilih Periode:</label>
        <select name="" id="select_periode" class="form-select" style="max-width: 260px;">
          <?php foreach($all_periode as $item):?>
            <option value="<?=$item->ID_PERIODE?>"{{ $item == $periode? 'selected':'' }}><?=$item->PERIODE?></option>
          <?php endforeach;?>
        </select>
      </div>

      <div class="table-responsive-custom mt-3">
        <table class="average-table table-bordered table-lg" id="siswaTable">
          <thead class="table-header-custom">
          <tr>
            <th>ID Siswa</th>
            <th>Nama Siswa</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            <?php foreach($all_siswa as $siswa): ?>
              <tr>
                <td><?= $siswa->ID_SISWA?></td>
                <td><?= $siswa->NAMA_SISWA?></td>
                <td>
                  <a href="{{ route('admin.report.siswa', ['id_periode' => $periode->ID_PERIODE, "id_siswa" => $siswa->ID_SISWA]) }}" class="btn btn-outline-primary btn-sm" title="Report">
                    <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                    <span class="visually-hidden">Report</span>
                  </a>
                </td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      $('#select_periode').change(function(){
        const periodeId = $(this).val();
        $.ajax({
          url: 'laporansiswa/'+ periodeId,
          type: 'GET',
          success: function(data){
            let rows = "";
            data.forEach(function (siswa){
              rows+=`
                <tr>
                  <td>${siswa.ID_SISWA}</td>
                  <td>${siswa.NAMA_SISWA}</td>
                  <td>
                    <a href="hlm_report_siswa?id_periode=${periodeId}&id_siswa=${btoa(siswa.ID_SISWA)}"
                    class="btn btn-primary">
                      Report
                    </a>
                  </td>
                </tr>
              `
            });
            $('#siswaTable tbody').html(rows);
          },
          error: function(err){
            console.log(err.responseText);
          }
        })
      })

    })

  </script>
@endsection
