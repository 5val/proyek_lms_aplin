<nav class="col-md-2 d-none d-md-block sidebar p-3">
        <div class="mb-4">
         <a href="/guru/hlm_about">
         <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
         <div><strong>Darren Susanto</strong></div>
         <p>G/001</p>
         </a>
       </div>
        <ul class="nav flex-column">
         <li class="nav-item"><a class="nav-link active" href="/guru/">Home</a></li>
         <li class="nav-item"><a class="nav-link" href="/guru/hlm_kelas">Kelas</a></li>
         <li class="nav-item"><a class="nav-link" href="/guru/walikelas">Wali Kelas</a></li>
         <li class="nav-item"><a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button" aria-expanded="false" aria-controls="submenuLaporan">
           Laporan Siswa
         </a>
         <div class="collapse submenu" id="submenuLaporan">
           <ul class="nav flex-column ms-3">
             <li class="nav-item"><a class="nav-link" href="/guru/hlm_laporan_tugas">Laporan Nilai Tugas</a></li>
             <li class="nav-item"><a class="nav-link" href="/guru/hlm_laporan_ujian">Laporan Nilai Ujian</a></li>
           </ul>
         </div>
       </li>
         <li class="nav-item"><a class="nav-link" href="/guru/hlm_jadwal">Jadwal</a></li>
         <li class="nav-item"><a class="nav-link" href="/">Sign out</a></li>
        </ul>
      </nav>