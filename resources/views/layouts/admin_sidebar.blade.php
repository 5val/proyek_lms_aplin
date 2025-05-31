<nav class="col-md-2 d-none d-md-block sidebar p-3" style="height: 100vh; overflow-y: auto; position: fixed; -ms-overflow-style: none;scrollbar-width: none;">
  <div class="mb-4">
    <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
    <div><strong>Admin</strong></div>
    <p>Admin</p>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="/admin/">Home</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/listguru') ? 'active' : '' }}"
        href="/admin/listguru">Guru</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/listsiswa') ? 'active' : '' }}"
        href="/admin/listsiswa">Siswa</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/list_pelajaran') ? 'active' : '' }}"
        href="/admin/list_pelajaran">Pelajaran</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/list_kelas') ? 'active' : '' }}"
        href="/admin/list_kelas">Kelas</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/listpengumuman') ? 'active' : '' }}"
        href="/admin/listpengumuman">Pengumuman</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/list_periode') ? 'active' : '' }}"
        href="/admin/list_periode">Periode</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('admin/list_ruangan') ? 'active' : '' }}"
        href="/admin/list_ruangan">Ruangan</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button"
        aria-expanded="false" aria-controls="submenuLaporan">
        Laporan
      </a>
      <div
        class="{{ Request::is('admin/laporansiswa') || Request::is('admin/laporanmapel') || Request::is('admin/laporankelas') || Request::is('admin/laporanguru') ? '' : 'collapse' }} submenu"
        id="submenuLaporan">
        <ul class="nav flex-column ms-3">
          <li class="nav-item"><a class="nav-link {{ Request::is('admin/laporansiswa') ? 'active' : '' }}"
              href="/admin/laporansiswa">Laporan Siswa</a></li>
          <!-- <li class="nav-item"><a class="nav-link {{ Request::is('admin/laporanmapel') ? 'active' : '' }}"
              href="/admin/laporanmapel">Laporan Mata Pelajaran</a></li> -->
          <!-- <li class="nav-item"><a class="nav-link {{ Request::is('admin/laporankelas') ? 'active' : '' }}"
              href="/admin/laporankelas">Laporan Kelas</a></li> -->
          <li class="nav-item"><a class="nav-link {{ Request::is('admin/laporanguru') ? 'active' : '' }}"
              href="/admin/laporanguru">Laporan Guru</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item"><a class="nav-link" href="/" style="background-color: red; color: white;">Sign out</a></li>
  </ul>
</nav>