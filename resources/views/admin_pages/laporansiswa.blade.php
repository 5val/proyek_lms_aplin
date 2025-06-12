@extends('layouts.admin_app')

@section('admin_content')
  <div class="p-3">
    <div class="row g-4 mb-4">
    </div>
    <div>
    <br>
    <h4 style="text-align: center;">Laporan Siswa</h4><br>
    <select name="" id="select_periode">
      <?php foreach($all_periode as $item):?>
        <option value="<?=$item->ID_PERIODE?>"{{ $item == $periode? 'selected':'' }}><?=$item->PERIODE?></option>
      <?php endforeach;?>
    </select>
    <table class="table table-bordered align-middle" id="siswaTable">
      <thead>
      <tr class="thead" style="font-weight: bold; background-color: #608BC1;">
        <td>ID Siswa</td>
        <td>Nama Siswa</td>
        <td>Action</td>
      </tr>
      </thead>
      <tbody>
        <?php foreach($all_siswa as $siswa): ?>
          <tr>
            <td><?= $siswa->ID_SISWA?></td>
            <td><?= $siswa->NAMA_SISWA?></td>
            <td>
              <a href="{{ route('admin.report.siswa', ['id_periode' => $periode->ID_PERIODE, "id_siswa" => $siswa->ID_SISWA]) }}" class="btn btn-primary">
                Report
              </a>
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
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