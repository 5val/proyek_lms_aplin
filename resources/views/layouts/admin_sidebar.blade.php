<nav class="col-md-2 d-none d-md-block sidebar p-3" style="height: 100vh; overflow-y: auto; position: fixed;">
  <div class="mb-4">
    <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
    <div><strong>Ovaldo Oentoro</strong></div>
    <p>Admin</p>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href="/admin/">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/listguru">Guru</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/listsiswa">Siswa</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/list_pelajaran">Pelajaran</a></li>
    <li class="nav-item"><a class="nav-link active" href="/admin/list_kelas">Kelas</a></li>
    <li class="nav-item"><a class="nav-link" href="/admin/listpengumuman">Pengumuman</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button"
        aria-expanded="false" aria-controls="submenuLaporan">
        Laporan
      </a>
      <div class="collapse submenu" id="submenuLaporan">
        <ul class="nav flex-column ms-3">
          <li class="nav-item"><a class="nav-link" href="/admin/laporansiswa">Laporan Siswa</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/laporanmapel">Laporan Mata Pelajaran</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/laporankelas">Laporan Kelas</a></li>
          <li class="nav-item"><a class="nav-link" href="/admin/laporanguru">Laporan Guru</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item"><a class="nav-link" href="/">Sign out</a></li>
  </ul>
</nav>