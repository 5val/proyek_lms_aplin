<nav class="col-md-2 d-none d-md-block sidebar p-3">
      <div class="mb-4">
        <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
        <div><strong>Ovaldo Oentoro</strong></div>
        <p>Admin</p>
      </div>
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="hlm_home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="listguru.php">Guru</a></li>
        <li class="nav-item"><a class="nav-link" href="listsiswa.php">Siswa</a></li>
        <li class="nav-item"><a class="nav-link" href="list_pelajaran.php">Pelajaran</a></li>
        <li class="nav-item"><a class="nav-link active" href="list_kelas.php">Kelas</a></li>
        <li class="nav-item"><a class="nav-link" href="listpengumuman.php">Pengumuman</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button"
            aria-expanded="false" aria-controls="submenuLaporan">
            Laporan
          </a>
          <div class="collapse submenu" id="submenuLaporan">
            <ul class="nav flex-column ms-3">
              <li class="nav-item"><a class="nav-link" href="laporansiswa.php">Laporan Siswa</a></li>
              <li class="nav-item"><a class="nav-link" href="laporanmapel.php">Laporan Mata Pelajaran</a></li>
              <li class="nav-item"><a class="nav-link" href="laporankelas.php">Laporan Kelas</a></li>
              <li class="nav-item"><a class="nav-link" href="laporanguru.php">Laporan Guru</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item"><a class="nav-link" href="../main/login.php">Sign out</a></li>
      </ul>
    </nav>