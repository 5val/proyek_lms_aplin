<nav id="sidebarGuru" class="col-3 sidebar p-3">
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
            <a class="nav-link {{ request()->is('guru') ? 'active' : '' }}" href="/guru/"><i class="bi bi-house-door me-2"></i>Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('guru/hlm_kelas') ? 'active' : '' }}" href="/guru/hlm_kelas"><i class="bi bi-collection me-2"></i>Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('guru/walikelas') ? 'active' : '' }}" href="/guru/walikelas"><i class="bi bi-person-badge me-2"></i>Wali
                Kelas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#submenuLaporan" role="button"
                aria-expanded="{{ request()->is('guru/hlm_laporan_*') ? 'true' : 'false' }}"
                aria-controls="submenuLaporan">
                <!-- {{ request()->is('guru/hlm_laporan_*') ? 'active' : '' }} -->
                <i class="bi bi-bar-chart-line me-2"></i>Laporan Siswa
            </a>
            <div class="collapse submenu {{ request()->is('guru/hlm_laporan_*') ? 'show' : '' }}" id="submenuLaporan">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('guru/hlm_laporan_tugas') ? 'active' : '' }}"
                            href="/guru/hlm_laporan_tugas"><i class="bi bi-clipboard-check me-2"></i>Laporan Nilai Tugas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('guru/hlm_laporan_ujian') ? 'active' : '' }}"
                            href="/guru/hlm_laporan_ujian"><i class="bi bi-clipboard-data me-2"></i>Laporan Nilai Ujian</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('guru/hlm_jadwal') ? 'active' : '' }}"
                href="/guru/hlm_jadwal"><i class="bi bi-calendar-event me-2"></i>Jadwal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/" style="background-color: red; color: white;"><i class="bi bi-box-arrow-right me-2"></i>Sign out</a>
        </li>
    </ul>
</nav>
