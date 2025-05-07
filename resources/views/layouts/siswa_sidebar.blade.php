<nav class="col-md-2 d-none d-md-block sidebar p-3">
        <div class="mb-4">
         <a href="/siswa/hlm_about">
         <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
         <div><strong>Jessica Natalie</strong></div>
         <p>220/0001</p>
         </a>
       </div>
        <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link active" href="/siswa/">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/siswa/hlm_kelas">Kelas</a></li>
          <li class="nav-item"><a class="nav-link" href="/siswa/hlm_jadwal">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button" aria-expanded="false" aria-controls="submenuLaporan">
            Laporan
          </a>
          <div class="collapse submenu" id="submenuLaporan">
            <ul class="nav flex-column ms-3">
            <li class="nav-item"><a class="nav-link" href="/siswa/hlm_laporan_tugas">Laporan Nilai Tugas</a></li>
            <li class="nav-item"><a class="nav-link" href="/siswa/hlm_laporan_ujian">Laporan Nilai Ujian</a></li>
            </ul>
          </div>
        </li>
          <li class="nav-item"><a class="nav-link" href="/">Sign out</a></li>
        </ul>
      </nav>