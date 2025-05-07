@extends('layouts.siswa_app')

@section('siswa_content')
<div class="topbar rounded mt-3">
          <h3>Fisika</h3>
          <p class="text-muted">XII IPA 1 2025</p>
          <div class="row">
            <div class="col">Jumlah Murid<br><strong>26</strong></div>
            <div class="col">Ruang Kelas<br><strong>F3/01</strong></div>
            <div class="col">Hari<br><strong>Selasa</strong></div>
            <div class="col">Jam<br><strong>08.00</strong></div>
            <div class="col">Semester<br><strong>Ganjil</strong></div>
          </div>
        </div>
        <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
          <li class="nav-item" role="presentation"><button class="nav-link active" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi-tab-content" type="button">Materi</button></li>
          <li class="nav-item" role="presentation"><button class="nav-link" id="tugas-tab" data-bs-toggle="tab" data-bs-target="#tugas-tab-content" type="button">Tugas</button></li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Materi Tab -->
            <div class="tab-pane fade show active" id="materi-tab-content" role="tabpanel">
            <div class="row g-4">
               <div class="col-md-4">
                  <div class="card h-100 p-3 d-flex flex-column">
                    <h5 class="card-title">Materi 1</h5>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </p>
                    <a href="#" class="mt-auto align-self-start">Download Materi</a>
                  </div>
                </div>
               <div class="col-md-4">
                  <div class="card h-100 p-3 d-flex flex-column">
                    <h5 class="card-title">Materi 2</h5>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit dolorem veritatis molestiae totam cumque mollitia repellendus doloribus
                    </p>
                    <a href="#" class="mt-auto align-self-start">Download Materi</a>
                  </div>
                </div>
               <div class="col-md-4">
                  <div class="card h-100 p-3 d-flex flex-column">
                    <h5 class="card-title">Materi 3</h5>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </p>
                    <a href="#" class="mt-auto align-self-start">Download Materi</a>
                  </div>
                </div>
               <div class="col-md-4">
                  <div class="card h-100 p-3 d-flex flex-column">
                    <h5 class="card-title">Materi 4</h5>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </p>
                    <a href="#" class="mt-auto align-self-start">Download Materi</a>
                  </div>
                </div>
               <div class="col-md-4">
                  <div class="card h-100 p-3 d-flex flex-column">
                    <h5 class="card-title">Materi 5</h5>
                    <p class="card-text">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </p>
                    <a href="#" class="mt-auto align-self-start">Download Materi</a>
                  </div>
                </div>
            </div>
            </div>

            <!-- Tugas Tab -->
            <div class="tab-pane fade" id="tugas-tab-content" role="tabpanel">
               <div class="row g-4">
                  <a href="hlm_detail_tugas.php">
                  <div class="col-md-4">
                     <a href="#" class="card h-100 p-3 d-flex flex-column">
                       <h5 class="card-title">Tugas 1</h5>
                       <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                       <p class="card-deadline mt-auto text-end">Deadline: 21 April 2025</p>
                     </a>
                   </div>
                   </a>
                  <div class="col-md-4">
                     <a href="#" class="card h-100 p-3 d-flex flex-column">
                       <h5 class="card-title">Tugas 2</h5>
                       <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Amet quam quidem nulla explicabo mollitia nam qui, quas, quod iure consectetur quia et optio assumenda aperiam inventore aspernatur saepe cupiditate dignissimos.</p>
                       <p class="card-deadline mt-auto text-end">Deadline: 21 April 2025</p>
                     </a>
                   </div>
                  <div class="col-md-4">
                     <a href="#" class="card h-100 p-3 d-flex flex-column">
                       <h5 class="card-title">Tugas 3</h5>
                       <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                       <p class="card-deadline mt-auto text-end">Deadline: 21 April 2025</p>
                     </a>
                   </div>
                  <div class="col-md-4">
                     <a href="#" class="card h-100 p-3 d-flex flex-column">
                       <h5 class="card-title">Tugas 4</h5>
                       <p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                       <p class="card-deadline mt-auto text-end">Deadline: 21 April 2025</p>
                     </a>
                   </div>
               </div>
             </div>
         </div>
@endsection