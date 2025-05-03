<nav class="col-md-2 d-none d-md-block sidebar p-3">
        <div class="mb-4">
         <a href="hlm_about.php">
         <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
         <div><strong>Darren Susanto</strong></div>
         <p>G/001</p>
         </a>
       </div>
        <ul class="nav flex-column">
         <li class="nav-item"><a class="nav-link active" href="hlm_home.php">Home</a></li>
         <li class="nav-item"><a class="nav-link" href="hlm_kelas.php">Kelas</a></li>
         <li class="nav-item"><a class="nav-link" href="walikelas.php">Wali Kelas</a></li>
         <li class="nav-item"><a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button" aria-expanded="false" aria-controls="submenuLaporan">
           Laporan Siswa
         </a>
         <div class="collapse submenu" id="submenuLaporan">
           <ul class="nav flex-column ms-3">
             <li class="nav-item"><a class="nav-link" href="hlm_laporan_tugas.php">Laporan Nilai Tugas</a></li>
             <li class="nav-item"><a class="nav-link" href="hlm_laporan_ujian.php">Laporan Nilai Ujian</a></li>
           </ul>
         </div>
       </li>
         <li class="nav-item"><a class="nav-link" href="hlm_jadwal.php">Jadwal</a></li>
         <li class="nav-item"><a class="nav-link" href="../main/login.php">Sign out</a></li>
        </ul>
      </nav>