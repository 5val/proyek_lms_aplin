<nav id="sidebarAdmin" class="col-3 sidebar p-3">
  <div class="mb-4">
    <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
    <div><strong>Admin</strong></div>
    <p>Admin</p>
  </div>
    <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="/admin/"><i class="bi bi-house-door me-2"></i>Home</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/listguru') ? 'active' : '' }}"
      href="/admin/listguru"><i class="bi bi-person-badge me-2"></i>Guru</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/listsiswa') ? 'active' : '' }}"
      href="/admin/listsiswa"><i class="bi bi-people me-2"></i>Siswa</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/list_pelajaran') ? 'active' : '' }}"
      href="/admin/list_pelajaran"><i class="bi bi-book me-2"></i>Pelajaran</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/list_kelas') ? 'active' : '' }}"
      href="/admin/list_kelas"><i class="bi bi-grid-3x3-gap me-2"></i>Kelas</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/listpengumuman') ? 'active' : '' }}"
      href="/admin/listpengumuman"><i class="bi bi-megaphone me-2"></i>Pengumuman</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/list_periode') ? 'active' : '' }}"
      href="/admin/list_periode"><i class="bi bi-calendar-event me-2"></i>Periode</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/list_ruangan') ? 'active' : '' }}"
      href="/admin/list_ruangan"><i class="bi bi-building me-2"></i>Ruangan</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button"
      aria-expanded="false" aria-controls="submenuLaporan">
      <i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan
      </a>
      <div
        class="{{ Request::is('admin/laporansiswa') || Request::is('admin/laporanmapel') || Request::is('admin/laporankelas') || Request::is('admin/laporanguru') ? '' : 'collapse' }} submenu"
        id="submenuLaporan">
        <ul class="nav flex-column ms-3">
          <li class="nav-item"><a class="nav-link {{ Request::is('admin/laporansiswa') ? 'active' : '' }}"
              href="/admin/laporansiswa"><i class="bi bi-person-lines-fill me-2"></i>Laporan Siswa</a></li>
          <!-- <li class="nav-item"><a class="nav-link {{ Request::is('admin/laporanmapel') ? 'active' : '' }}"
              href="/admin/laporanmapel">Laporan Mata Pelajaran</a></li> -->
          <!-- <li class="nav-item"><a class="nav-link {{ Request::is('admin/laporankelas') ? 'active' : '' }}"
              href="/admin/laporankelas">Laporan Kelas</a></li> -->
          <li class="nav-item"><a class="nav-link {{ Request::is('admin/laporanguru') ? 'active' : '' }}"
              href="/admin/laporanguru"><i class="bi bi-file-person me-2"></i>Laporan Guru</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item"><a class="nav-link" href="/" style="background-color: red; color: white;"><i class="bi bi-box-arrow-right me-2"></i>Sign out</a></li>
  </ul>
</nav>
