<nav id="sidebarSiswa" class="col-3 sidebar p-3">
  <div class="mb-4">
    <a href="/siswa/hlm_about">
      <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
      <div><strong>{{ session('userActive')->NAMA_SISWA }}</strong></div>
      <p>{{ session('userActive')->ID_SISWA }}</p>
    </a>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link {{ Request::is('siswa') ? 'active' : '' }}" href="/siswa/">
        <i class='bx  bx-home'></i>
        Home
      </a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('siswa/hlm_kelas') ? 'active' : '' }}"
        href="/siswa/hlm_kelas">
        <i class='bx  bx-book-bookmark'></i>
        Kelas</a></li>
    <li class="nav-item"><a class="nav-link {{ Request::is('siswa/hlm_jadwal') ? 'active' : '' }}"
        href="/siswa/hlm_jadwal">
        <i class='bx  bx-calendar-alt'></i>
        Jadwal</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button"
        aria-expanded="false" aria-controls="submenuLaporan">
        Laporan
      </a>
      <div
        class="{{ Request::is('siswa/hlm_laporan_ujian') || Request::is('siswa/hlm_laporan_tugas') ? '' : 'collapse' }} submenu"
        id="submenuLaporan">
        <ul class="nav flex-column ms-3">
          <li class="nav-item"><a class="nav-link {{ Request::is('siswa/hlm_laporan_tugas') ? 'active' : '' }}"
              href="/siswa/hlm_laporan_tugas">Laporan Nilai Tugas</a></li>
          <li class="nav-item"><a class="nav-link {{ Request::is('siswa/hlm_laporan_ujian') ? 'active' : '' }}"
              href="/siswa/hlm_laporan_ujian">Laporan Nilai Ujian</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item"><a class="nav-link {{ Request::is('siswa/libur_nasional') ? 'active' : '' }}"
        href="/siswa/libur_nasional">
        <i class='bx  bx-calendar-heart'></i>
        Libur Nasional</a></li>
    <li class="nav-item"><a class="nav-link" href="/" style="background-color: red; color: white;">
        <i class='bx  bx-log-out'></i>
        Sign out</a></li>
  </ul>
</nav>