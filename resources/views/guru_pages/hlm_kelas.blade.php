@extends('layouts.guru_app')

@section('guru_content')
<div class="p-3">
          <h4 class="mb-3">Kelas</h4>
          <p><strong>Periode:</strong></p>
         <select name="" id="selector_periode">
            <?php foreach($all_periode as $item):?>
               <option value="<?=$item->ID_PERIODE?>" {{ $item->ID_PERIODE == $periode->ID_PERIODE ? 'selected':"" }}><?= $item->PERIODE?></option>
            <?php endforeach;?>
          </select>
          <h5 class="mt-4">Kelas yang Anda Ajar:</h5>
        <div class="grid-container" id="container_kelas">
         <?php foreach ($all_kelas as $k) : ?>
            <a href="{{ url('/guru/detail_pelajaran/' . urlencode($k->id_mata_pelajaran)) }}" class="text-decoration-none text-dark">
               <div class="grid-item">
               <i class="fas fa-calculator"></i>
               <h5>{{ $k->nama_pelajaran }}</h5>
               <p>Kelas: {{ $k->nama_kelas }}</p>
               </div>
            </a>
         <?php endforeach; ?>
        </div>
        </div>
        <script>
            $(document).ready(function(){
               function getItemData(periodeId){
                  $.ajax({
                     url: "/guru/get_all_kelas?id_periode="+periodeId,
                     type: "GET",
                     success: function(data){
                        let row = "";                        
                        data.forEach(function(kelas){
                           row+= `
                           <a href="/guru/detail_pelajaran/${encodeURIComponent(kelas.id_mata_pelajaran)}" class="text-decoration-none text-dark">
                               <div class="grid-item">
                               <i class="fas fa-calculator"></i>
                               <h5>${ kelas.nama_pelajaran }</h5>
                               <p>Kelas: ${ kelas.nama_kelas }</p>
                               </div>
                           </a>
                           `
                        });
                        $("#container_kelas").html(row)
                     },
                     error: function(err){
                        console.log(err.message);
                     }
                  })
               }
               $("#selector_periode").change(function(){
                  const periodeId = $(this).val();
                  getItemData(periodeId);
               })
            })
        </script>
@endsection