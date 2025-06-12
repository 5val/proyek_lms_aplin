@extends('layouts.siswa_app')

@section('siswa_content')
<h4 class="mb-3">Home Siswa</h4>
          <p><strong>Kelas:</strong> {{ $kelas->NAMA_KELAS }} &nbsp; | &nbsp; <strong>Periode:</strong> {{ $kelas->PERIODE }}</p>

          <!-- Pelajaran Siswa -->
          <h5 class="mt-4">Pelajaran</h5>
          <button class="toggle-btn" id="toggleBtn">Tampilkan Semua Pelajaran</button>
          
          <div class="scroll-box mb-4">
              <?php $counter = 0; // Inisialisasi counter untuk menghitung jumlah mata pelajaran ?>
              <?php foreach($matapelajaran as $m): ?>
                  <?php if($counter < 3): // Menampilkan 3 pertama ?>
                      <a href="{{ url('/siswa/detail_pelajaran/' . base64_encode($m->ID_MATA_PELAJARAN)) }}" class="text-decoration-none text-dark">
                          <div class="card p-3">
                              <div class="card-body">
                                  <i class="fas fa-book-open"></i>
                                  <h5><?= $m->NAMA_PELAJARAN ?></h5> <!-- Ganti dengan nama pelajaran dari database -->
                              </div>
                          </div>
                      </a>
                  <?php else: // Menyembunyikan mata pelajaran selanjutnya ?>
                    <a href="{{ url('/siswa/detail_pelajaran/' . base64_encode($m->ID_MATA_PELAJARAN)) }}" class="text-decoration-none text-dark">
                      <div class="card p-3 hidden-card" style="display:none;">
                          <div class="card-body">
                              <i class="fas fa-book-open"></i>
                              <h5><?= $m->NAMA_PELAJARAN ?></h5> <!-- Ganti dengan nama pelajaran dari database -->
                          </div>
                      </div>
                  </a>
                  <?php endif; ?>
                  <?php $counter++; // Increment counter ?>
              <?php endforeach; ?>

              <!-- <a href="/siswa/detail_pelajaran">
                  <div class="card p-3">
                      <div class="card-body">
                          <i class="fas fa-calculator"></i>
                          <h5>Matematika</h5>
                      </div>
                  </div>
              </a>
              <div class="card p-3">
                  <div class="card-body">
                      <i class="fas fa-leaf"></i>
                      <h5>Biologi</h5>
                  </div>
              </div>
              <div class="card p-3">
                  <div class="card-body">
                      <i class="fas fa-book-open"></i>
                      <h5>Bahasa Inggris</h5>
                  </div>
              </div>

              <div class="card p-3 hidden-card" style="display:none;">
                  <div class="card-body">
                      <i class="fas fa-flask"></i>
                      <h5>Fisika</h5>
                  </div>
              </div>
              <div class="card p-3 hidden-card" style="display:none;">
                  <div class="card-body">
                      <i class="fas fa-vial"></i>
                      <h5>Kimia</h5>
                  </div>
              </div>
              <div class="card p-3 hidden-card" style="display:none;">
                  <div class="card-body">
                      <i class="fas fa-pencil-alt"></i>
                      <h5>Bahasa Indonesia</h5>
                  </div>
              </div>
              <div class="card p-3 hidden-card" style="display:none;">
                  <div class="card-body">
                      <i class="fas fa-history"></i>
                      <h5>Sejarah</h5>
                  </div>
              </div> -->

          </div>

          <!-- Tugas yang Sedang Berlangsung -->
          <h5 class="mt-4">Tugas yang Sedang Berlangsung</h5>
          <div class="scroll-box mb-4">

          @foreach($tugas as $t)
              <a href="{{ url('/siswa/hlm_detail_tugas/' . base64_encode($t->ID_TUGAS)) }}" class="text-decoration-none text-dark">
              <!-- <a href="/siswa/hlm_detail_tugas/{{ $t->ID_TUGAS }}"> -->
                  <div class="card p-3">
                      <strong>{{ $t->NAMA_PELAJARAN }}</strong>
                      <p>{{ $t->NAMA_TUGAS }}</p>
                      <small>Tenggat: {{ \Carbon\Carbon::parse($t->DEADLINE_TUGAS)->format('d M Y') }}</small>
                  </div>
              </a>
          @endforeach

          </div>

          <!-- Pengumuman -->
          <h5>Pengumuman</h5>
          <?php foreach ($pengumuman as $p): ?>
          <div class="bg-white shadow-sm rounded p-3 mb-3">
            <h6 class="fw-bold">{{ $p->Judul }}</h6>
            <p>{{ $p->Deskripsi }}</p>
          </div>
          <?php endforeach; ?>

          <!-- Timetable -->
          <h5>Jadwal Pelajaran (Senin - Jumat)</h5>
          <div class="table-responsive">
            <table class="table table-bordered timetable-table bg-white no-data-table">
              <thead class="table-secondary">
                <tr>
                  <th>Hari</th>
                  <th>Jam ke-1 (07:00 - 08:30)</th>
                  <th>Jam ke-2 (08:30 - 10:00)</th>
                  <th>Jam ke-3 (10:00 - 11:30)</th>
                  <th>Jam ke-4 (12:00 - 13:30)</th>
                  <th>Jam ke-4 (13:30 - 15:00)</th>
                </tr>
              </thead>
              <tbody>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                    <tr>
                        <td>{{ $hari }}</td>
                        @foreach (['07:00-08:30', '08:30-10:00', '10:00-11:30', '12:00-13:30', '13:30-15:00'] as $jam)
                            <td>
                                @if(isset($jadwal[$hari][$jam]))
                                    {{ $jadwal[$hari][$jam] }}
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <!-- <tr>
                  <td>Senin</td>
                  <td>Matematika</td>
                  <td>Biologi</td>
                  <td>Fisika</td>
                  <td>Sejarah</td>
                </tr>
                <tr>
                  <td>Selasa</td>
                  <td>Bahasa Indonesia</td>
                  <td>Kimia</td>
                  <td>Biologi</td>
                  <td>Matematika</td>
                </tr>
                <tr>
                  <td>Rabu</td>
                  <td>Bahasa Inggris</td>
                  <td>Kimia</td>
                  <td>Fisika</td>
                  <td>Matematika</td>
                </tr>
                <tr>
                  <td>Kamis</td>
                  <td>Biologi</td>
                  <td>Bahasa Indonesia</td>
                  <td>Sejarah</td>
                  <td>Matematika</td>
                </tr>
                <tr>
                  <td>Jumat</td>
                  <td>Bahasa Inggris</td>
                  <td>Fisika</td>
                  <td>Kimia</td>
                  <td>Bahasa Indonesia</td>
                </tr> -->
              </tbody>
            </table>
            
@endsection

@section('custom-scripts')
<script>
   document.getElementById('toggleBtn').addEventListener('click', function() {
      const hiddenCards = document.querySelectorAll('.hidden-card');
      const btn = document.getElementById('toggleBtn');
      
      hiddenCards.forEach(card => {
          if (card.style.display === 'none') {
              card.style.display = 'block'; // Mengubah display menjadi block
              btn.textContent = 'Sembunyikan Pelajaran Tambahan';
          } else {
              card.style.display = 'none';
              btn.textContent = 'Tampilkan Semua Pelajaran';
          }
      });
  });
</script>
@endsection