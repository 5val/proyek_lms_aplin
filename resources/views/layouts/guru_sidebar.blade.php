<nav class="col-md-2 d-none d-md-block sidebar p-3">
    <div class="mb-4">
        <a href="/guru/hlm_about">
            <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
            <div><strong>{{ session('userActive')->NAMA_GURU }}</strong></div>
            <p>{{ session('userActive')->ID_GURU }}</p>
        </a>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
          <!-- jika url saat ini adalah guru maka ubah jadi class nav link active-->
            <a class="nav-link {{ request()->is('guru') ? 'active' : '' }}" href="/guru/">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('guru/hlm_kelas') ? 'active' : '' }}" href="/guru/hlm_kelas">Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('guru/walikelas') ? 'active' : '' }}" href="/guru/walikelas">Wali Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('guru/hlm_laporan_*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#submenuLaporan" role="button" aria-expanded="{{ request()->is('guru/hlm_laporan_*') ? 'true' : 'false' }}" aria-controls="submenuLaporan">
                Laporan Siswa
            </a>
            <div class="collapse submenu {{ request()->is('guru/hlm_laporan_*') ? 'show' : '' }}" id="submenuLaporan">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('guru/hlm_laporan_tugas') ? 'active' : '' }}" href="/guru/hlm_laporan_tugas">Laporan Nilai Tugas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('guru/hlm_laporan_ujian') ? 'active' : '' }}" href="/guru/hlm_laporan_ujian">Laporan Nilai Ujian</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('guru/hlm_jadwal') ? 'active' : '' }}" href="/guru/hlm_jadwal">Jadwal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/">Sign out</a>
        </li>
    </ul>
</nav>
