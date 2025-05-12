@extends('layouts.guru_app')

@section('guru_content')
<div class="topbar rounded mt-3">
          <h3>{{ $mata_pelajaran->pelajaran->NAMA_PELAJARAN }}</h3>
          <p class="text-muted">{{ $kelas->detailKelas->NAMA_KELAS }}</p>
          <div class="row">
            <div class="col">Jumlah Murid<br><strong>{{ $jumlah }}</strong></div>
            <div class="col">Ruang Kelas<br><strong>{{ $kelas->ID_DETAIL_KELAS }}</strong></div>
            <div class="col">Hari<br><strong>{{ $mata_pelajaran->HARI_PELAJARAN }}</strong></div>
            <div class="col">Jam<br><strong>{{ $mata_pelajaran->JAM_PELAJARAN }}</strong></div>
            <div class="col">Semester<br><strong>{{ $semester }}</strong></div>
          </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
          <li class="nav-item" role="presentation"><button class="nav-link active" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi-tab-content" type="button">Materi</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="tugas-tab" data-bs-toggle="tab" data-bs-target="#tugas-tab-content" type="button">Tugas</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa-tab-content" type="button">Siswa</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="pertemuan-tab" data-bs-toggle="tab" data-bs-target="#pertemuan-tab-content" type="button">Pertemuan</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi-tab-content" type="button">Absensi</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="laporan-tab" data-bs-toggle="tab" data-bs-target="#laporan-tab-content" type="button">Laporan</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="pengumuman-tab" data-bs-toggle="tab" data-bs-target="#pengumuman-tab-content" type="button">Pengumuman</button></li>
        </ul>

        <!-- Tabs Content -->
         <div class="tab-content" id="myTabContent">
            <!-- Materi Tab -->
            <div class="tab-pane fade show active" id="materi-tab-content" role="tabpanel">
                  <button class="btn btn-primary"><a href="{{ url('/guru/uploadmateri/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Materi</a></button>
                <!-- Grid Materi -->
                <div class="row mt-3">
                  <?php foreach ($materi as $m): ?>
                     <div class="col-md-4 mb-4">
                        <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                           <h5 class="card-title">{{ $m->NAMA_MATERI }}</h5>
                           <p class="card-text flex-grow-1">{{ $m->DESKRIPSI_MATERI }}</p>
                           <div class="mt-auto">
                              <a href="{{ asset('storage/uploads/materi/' . $m->FILE_MATERI) }}" download class="d-block mb-2">Download Materi</a>
                              <div class="d-flex gap-2">
                              <button class="btn btn-sm btn-outline-primary w-50" onclick="window.location.href='/guru/editmateri'">Edit</button>
                              <button class="btn btn-sm btn-outline-danger w-50">Hapus</button>
                              </div>
                           </div>
                        </div>
                        </div>
                     </div>
                  <?php endforeach; ?>
            </div>

            <!-- Tugas Tab -->
            <div class="tab-pane fade" id="tugas-tab-content" role="tabpanel">
               <button class="btn btn-primary"><a href="{{ url('/guru/uploadtugas/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Tugas</a></button>
               <div class="row mt-3">
                  <?php foreach ($tugas as $t): ?>
                     <div class="col-md-4 mb-4">
                        <div class="card h-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column">
                           <h5 class="card-title">{{ $t->NAMA_TUGAS }}</h5>
                           <p class="card-text flex-grow-1">{{ $t->DESKRIPSI_TUGAS }}</p>
                           <div class="mt-auto">
                              <p class="card-text flex-grow-1">{{ $t->DEADLINE_TUGAS }}</p>
                              <div class="d-flex gap-2">
                              <button class="btn btn-sm btn-outline-primary w-50" onclick="window.location.href='/guru/editmateri'">Edit</button>
                              <button class="btn btn-sm btn-outline-danger w-50">Hapus</button>
                              </div>
                           </div>
                        </div>
                        </div>
                     </div>
                  <?php endforeach; ?>
               </div>
             </div>

             <!-- Siswa Tab -->
             <div class="tab-pane fade" id="siswa-tab-content" role="tabpanel">
               <div class="content-box">
                 <h5>Daftar Siswa</h5>
                 <div class="table-responsive mt-3">
                   <table class="table table-bordered table-striped">
                     <thead class="table-secondary">
                       <tr>
                         <th scope="col" class="w-25">ID</th>
                         <th scope="col">Nama</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <td>220/0001</td>
                         <td>Andi Santoso</td>
                       </tr>
                       <tr>
                         <td>220/0002</td>
                         <td>Budi Wijaya</td>
                       </tr>
                       <tr>
                         <td>220/0003</td>
                         <td>Citra Lestari</td>
                       </tr>
                       <tr>
                         <td>220/0004</td>
                         <td>Dewi Kurnia</td>
                       </tr>
                       <tr>
                         <td>220/0005</td>
                         <td>Eko Prasetyo</td>
                       </tr>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
             
             <!-- Pertemuan Tab -->
             <div class="tab-pane fade" id="pertemuan-tab-content" role="tabpanel">
               <div>
                  <button class="btn btn-primary mb-3"><a href="{{ url('/guru/tambahpertemuan/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Pertemuan</a></button>
                  <div class="bg-white shadow-sm border rounded p-3 mb-3">
                    <h6 class="fw-bold">Pertemuan 1</h6>
                    <p class="mb-0 text-muted">Pengenalan tentang materi-materi yang akan diajarkan</p>
                  </div>
                  <div class="bg-white shadow-sm border rounded p-3 mb-3">
                    <h6 class="fw-bold">Pertemuan 2</h6>
                    <p class="mb-0 text-muted">Pembahasan mengenai ...</p>
                  </div>
                  <div class="bg-white shadow-sm border rounded p-3 mb-3">
                    <h6 class="fw-bold">Pertemuan 3</h6>
                    <p class="mb-0 text-muted">Pembahasan mengenai ...</p>
                  </div>
                  <div class="bg-white shadow-sm border rounded p-3 mb-3">
                    <h6 class="fw-bold">Pertemuan 4</h6>
                    <p class="mb-0 text-muted">Pembahasan mengenai ...</p>
                  </div>
               </div>
             </div>

             <!-- Absensi Tab -->
             <div class="tab-pane fade" id="absensi-tab-content" role="tabpanel">
               <div>
                 <h5 class="mb-3">Daftar Absensi Siswa</h5>
                 <div class="table-responsive">
                   <table class="table table-bordered bg-white shadow-sm">
                     <thead class="table-light">
                       <tr>
                         <th style="width: 150px;">ID</th>
                         <th>Nama</th>
                         <th class="text-center">Pertemuan 1</th>
                         <th class="text-center">Pertemuan 2</th>
                         <th class="text-center">Pertemuan 3</th>
                         <th class="text-center">Pertemuan 4</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <td>220/0001</td>
                         <td>Andi Santoso</td>
                         <td class="text-center"><input type="checkbox"></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                         <td class="text-center"><input type="checkbox"></td>
                         <td class="text-center"><input type="checkbox"></td>
                       </tr>
                       <tr>
                         <td>220/0002</td>
                         <td>Budi Wijaya</td>
                         <td class="text-center"><input type="checkbox" checked></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                         <td class="text-center"><input type="checkbox"></td>
                       </tr>
                       <tr>
                         <td>220/0003</td>
                         <td>Citra Lestari</td>
                         <td class="text-center"><input type="checkbox"></td>
                         <td class="text-center"><input type="checkbox"></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                       </tr>
                       <tr>
                         <td>220/0004</td>
                         <td>Dewi Kurnia</td>
                         <td class="text-center"><input type="checkbox"></td>
                         <td class="text-center"><input type="checkbox"></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                       </tr>
                       <tr>
                         <td>220/0005</td>
                         <td>Eko Prasetyo</td>
                         <td class="text-center"><input type="checkbox"></td>
                         <td class="text-center"><input type="checkbox"></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                         <td class="text-center"><input type="checkbox" checked></td>
                       </tr>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>

             <!-- Tugas Tab -->
             <div class="tab-pane fade" id="laporan-tab-content" role="tabpanel">
               <div>
                 <h5 class="mb-3">Laporan Nilai Siswa</h5>
             
                 <!-- Sub-tabs -->
                 <ul class="nav nav-tabs" id="laporanTab" role="tablist">
                   <li class="nav-item" role="presentation">
                     <button class="nav-link active" id="tugas-tab" data-bs-toggle="tab" data-bs-target="#tugas" type="button" role="tab">Tugas</button>
                   </li>
                   <li class="nav-item" role="presentation">
                     <button class="nav-link" id="ujian-tab" data-bs-toggle="tab" data-bs-target="#ujian" type="button" role="tab">Ujian</button>
                   </li>
                 </ul>
             
                 <!-- Sub-tab Content -->
                 <div class="tab-content bg-white shadow-sm p-3" id="laporanTabContent">
                   <!-- Tab Tugas -->
                   <div class="tab-pane fade show active" id="tugas" role="tabpanel" aria-labelledby="tugas-tab">
                     <div class="table-responsive mt-3">
                       <table class="table table-bordered">
                         <thead class="table-light">
                           <tr>
                             <th style="width: 120px;">ID</th>
                             <th>Nama</th>
                             <th style="width: 100px;">Tugas 1</th>
                             <th style="width: 100px;">Tugas 2</th>
                             <th style="width: 100px;">Tugas 3</th>
                             <th style="width: 100px;">Tugas 4</th>
                           </tr>
                         </thead>
                         <tbody>
                           <tr>
                             <td>220/0001</td>
                             <td>Andi Santoso</td>
                             <td>85</td>
                             <td>90</td>
                             <td>88</td>
                             <td>95</td>
                           </tr>
                           <tr>
                             <td>220/0002</td>
                             <td>Budi Wijaya</td>
                             <td>85</td>
                             <td>90</td>
                             <td>88</td>
                             <td>95</td>
                           </tr>
                           <tr>
                             <td>220/0003</td>
                             <td>Citra Lestari</td>
                             <td>85</td>
                             <td>90</td>
                             <td>88</td>
                             <td>95</td>
                           </tr>
                           <tr>
                             <td>220/0004</td>
                             <td>Dewi Kurnia</td>
                             <td>85</td>
                             <td>90</td>
                             <td>88</td>
                             <td>95</td>
                           </tr>
                           <tr>
                             <td>220/0005</td>
                             <td>Eko Prasetyo</td>
                             <td>85</td>
                             <td>90</td>
                             <td>88</td>
                             <td>95</td>
                           </tr>
                         </tbody>
                       </table>
                     </div>
                   </div>
                   <!-- Tab Ujian -->
                   <div class="tab-pane fade" id="ujian" role="tabpanel" aria-labelledby="ujian-tab">
                     <div class="table-responsive mt-3">
                       <table class="table table-bordered">
                         <thead class="table-light">
                           <tr>
                             <th style="width: 120px;">ID Siswa</th>
                             <th>Nama</th>
                             <th style="width: 100px;">UTS</th>
                             <th style="width: 100px;">UAS</th>
                             <th style="width: 120px;">Nilai Akhir</th>
                           </tr>
                         </thead>
                         <tbody>
                           <tr>
                             <td>220/0001</td>
                             <td>Andi Santoso</td>
                             <td>84</td>
                             <td>90</td>
                             <td>88</td>
                           </tr>
                           <tr>
                             <td>220/0002</td>
                             <td>Budi Wijaya</td>
                             <td>75</td>
                             <td>78</td>
                             <td>77</td>
                           </tr>
                           <tr>
                             <td>220/0003</td>
                             <td>Citra Lestari</td>
                             <td>89</td>
                             <td>91</td>
                             <td>90</td>
                           </tr>
                           <tr>
                             <td>220/0004</td>
                             <td>Dewi Kurnia</td>
                             <td>89</td>
                             <td>91</td>
                             <td>90</td>
                           </tr>
                           <tr>
                             <td>220/0005</td>
                             <td>Eko Prasetyo</td>
                             <td>89</td>
                             <td>91</td>
                             <td>90</td>
                           </tr>
                         </tbody>
                       </table>
                     </div>
                   </div>
                 </div>
               </div>
             </div>

             <!-- Pengumuman Tab -->
             <div class="tab-pane fade" id="pengumuman-tab-content" role="tabpanel">
               <div>
                 <button class="btn btn-primary mb-3"><a href="{{ url('/guru/tambahpengumuman/' . urlencode($mata_pelajaran->ID_MATA_PELAJARAN)) }}" style="text-decoration: none; color: white;">Tambah Pengumuman</a></button>
                 <div class="bg-white shadow-sm rounded p-3 mb-3">
                  <h5 class="fw-bold">Bahan UTS dan tugas tambahan</h5>
                  <p>UTS akan diadakan pada tanggal 30 April. Materi yang diujikan sampai Bab 6. Silakan kerjakan tugas tambahan yang telah diupload untuk membantu belajar. Batas pengumpulan hingga Jumat malam.</p>
                  <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-sm btn-outline-primary" style="min-width: 100px;" onclick="window.location.href='/guru/editpengumuman'">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" style="min-width: 100px;">Hapus</button>
                  </div>
                </div>
                 <div class="bg-white shadow-sm rounded p-3 mb-3">
                  <h5 class="fw-bold">Bahan UTS dan tugas tambahan</h5>
                  <p>UTS akan diadakan pada tanggal 30 April. Materi yang diujikan sampai Bab 6. Silakan kerjakan tugas tambahan yang telah diupload untuk membantu belajar. Batas pengumpulan hingga Jumat malam.</p>
                  <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-sm btn-outline-primary" style="min-width: 100px;" onclick="window.location.href='/guru/editpengumuman'">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" style="min-width: 100px;">Hapus</button>
                  </div>
                </div>
                 <div class="bg-white shadow-sm rounded p-3 mb-3">
                  <h5 class="fw-bold">Bahan UTS dan tugas tambahan</h5>
                  <p>UTS akan diadakan pada tanggal 30 April. Materi yang diujikan sampai Bab 6. Silakan kerjakan tugas tambahan yang telah diupload untuk membantu belajar. Batas pengumpulan hingga Jumat malam.</p>
                  <div class="d-flex justify-content-end gap-2">
                    <button class="btn btn-sm btn-outline-primary" style="min-width: 100px;" onclick="window.location.href='/guru/editpengumuman'">Edit</button>
                    <button class="btn btn-sm btn-outline-danger" style="min-width: 100px;">Hapus</button>
                  </div>
                </div>
               </div>
             </div>             

         </div>
@endsection