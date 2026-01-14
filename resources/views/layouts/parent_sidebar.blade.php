<nav id="sidebarAdmin" class="col-3 sidebar p-3">
  @php
    $parentUser = session('userActive');
    $studentName = $parentUser->NAMA_SISWA ?? '-';
    $studentId = $parentUser->ID_SISWA ?? '';
  @endphp
  <div class="mb-4">
    <img src="{{ asset('images/default_img.png') }}" class="rounded-circle mb-2" alt="User" width="60px">
    <div><strong>Orang Tua</strong></div>
    <p class="mb-0">Anak: {{ $studentName }}{{ $studentId ? " ({$studentId})" : '' }}</p>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link {{ Request::is('orangtua') || Request::is('orangtua/') ? 'active' : '' }}" href="/orangtua"><i class="bi bi-house-door me-2"></i>Beranda</a></li>
    <li class="nav-item"><a class="nav-link" href="/orangtua#absensi"><i class="bi bi-clipboard-check me-2"></i>Absensi</a></li>
    <li class="nav-item"><a class="nav-link" href="/orangtua#jadwal"><i class="bi bi-calendar-week me-2"></i>Jadwal</a></li>
    <li class="nav-item"><a class="nav-link" href="/orangtua#tugas"><i class="bi bi-check2-square me-2"></i>Tugas</a></li>
    <li class="nav-item"><a class="nav-link" href="/orangtua#materi"><i class="bi bi-journal-text me-2"></i>Materi</a></li>
    <li class="nav-item"><a class="nav-link" href="/orangtua#info"><i class="bi bi-megaphone me-2"></i>Info Sekolah</a></li>
    <li class="nav-item"><a class="nav-link" href="/" style="background-color: red; color: white;"><i class="bi bi-box-arrow-right me-2"></i>Sign out</a></li>
  </ul>
</nav>
