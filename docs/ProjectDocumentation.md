# Dokumentasi Proyek LMS Aplin

LMS Aplin adalah sistem pembelajaran dan administrasi sekolah berbasis web yang memusatkan seluruh proses akademik dalam satu platform: pendataan guru dan siswa, pengelolaan kelas dan jadwal, distribusi materi serta tugas, penilaian, absensi, laporan hasil belajar, hingga penagihan biaya pendidikan. Aplikasi ini dirancang agar setiap peran—admin, guru, siswa, dan orang tua—mendapat pengalaman yang sesuai kebutuhan: admin dapat menjaga data master dan operasional, guru fokus pada proses mengajar dan menilai, siswa memperoleh materi dan tugas dengan jelas, sementara orang tua dapat memantau perkembangan anak serta melakukan pembayaran secara mandiri.

Di sisi back-office, LMS Aplin menyediakan alur lengkap untuk menyusun periode akademik, mengatur kelas, ruangan, dan jadwal pelajaran, serta memverifikasi integritas data melalui validasi jadwal dan kapasitas. Modul akademik memungkinkan guru menyiapkan pertemuan, materi, dan tugas, lalu menilai melalui input manual maupun impor Excel. Pelaporan akademik menyajikan ringkasan nilai, rata-rata, dan rangking, serta status kelulusan per periode. Untuk aspek keuangan, sistem mendukung komponen biaya, kategori, penagihan massal, integrasi pembayaran Midtrans dengan webhook, dan pencatatan pembayaran secara otomatis.

Antarmuka pengguna memisahkan portal untuk guru, siswa, dan orang tua, memastikan setiap peran hanya mengakses data relevan dengan keamanan berbasis sesi dan middleware khusus. Integrasi perpustakaan digital memungkinkan distribusi buku PDF ber-watermark per kelas. Dengan dukungan impor data via Excel dan endpoint AI (`/ask-gemini`), LMS Aplin berupaya mempermudah operasional sekolah sekaligus menjaga fleksibilitas pengembangan di masa depan.

## 1. Ringkasan
- Framework: Laravel (stack web + Blade views).
- Modul utama: Administrasi akademik, manajemen kelas & jadwal, materi/tugas, penilaian, perpustakaan digital, kehadiran, keuangan/tagihan, portal guru/siswa/orang tua, integrasi Midtrans, impor data via Excel, dan endpoint AI (/ask-gemini).

## 2. Alur Sistem Tingkat Tinggi
1) **Autentikasi & sesi**: Login lewat `MainController@handleLogin`. Menyetel `session('userActive')` dengan penanda `ID_ADMIN` / `ID_GURU` / `ID_SISWA` atau `ROLE=Parent`. Password lama otomatis di-upgrade ke bcrypt saat login berhasil.
2) **Middleware role**: `admin.auth` (cek `ID_ADMIN`), `guru.auth` (cek `ID_GURU` valid di tabel GURU), `siswa.auth` (cek `ID_SISWA` valid di SISWA). Orang tua memakai guard siswa tetapi `ROLE=Parent` di sesi.
3) **Navigasi per role**:
   - Admin → prefix `/admin/*` (manajemen data & keuangan).
   - Guru → prefix `/guru/*` (pengajaran, tugas, materi, nilai, absensi, wali kelas).
   - Siswa → prefix `/siswa/*` (belajar, submit tugas, lihat nilai/jadwal).
   - Orang Tua → prefix `/orangtua/*` (ringkasan anak & pembayaran).
4) **Data flow akademik** (ringkas): Admin set master data (guru, siswa, kelas, periode, jam, pelajaran, jadwal). Guru mengelola materi/pertemuan/tugas & nilai. Siswa mengumpulkan tugas dan melihat progres. Orang tua memantau dan membayar tagihan. Admin/guru dapat mengekspor/menilai dan melihat laporan.
5) **Pembayaran**: Orang tua memicu transaksi Midtrans (Snap). Webhook ditangani `PaymentController@midtransCallback` untuk memutakhirkan status `STUDENT_FEE` dan membuat record `PAYMENT`.

## 3. Role & Autorisasi
- **Admin**: akses penuh modul /admin. Otorisasi via `AdminAuth` (wajib `ID_ADMIN` di sesi). Login juga bisa dengan kredensial default `admin/admin` (legacy fallback).
- **Guru**: akses modul /guru, dicek `GuruAuth` (harus ada `ID_GURU` valid). Hanya melihat data yang terkait kelas/mata pelajaran yang diajar atau diwalikan.
- **Siswa**: akses modul /siswa, dicek `SiswaAuth` (harus ada `ID_SISWA` valid). Data dibatasi ke kelas/periode terakhir yang diikuti.
- **Orang Tua**: memakai `siswa.auth` tetapi wajib `ROLE=Parent` di sesi. Hanya dapat melihat data anak terkait dan membayar tagihan milik anak tersebut.

## 4. Fitur per Role
### Admin (/admin)
- Dashboard: ringkasan periode terbaru, jumlah siswa/guru/kelas/mapel & 10 pengumuman terakhir.
- Guru: CRUD guru, toggle aktif/nonaktif, unggah via Excel (template `template_guru.xlsx`).
- Siswa: CRUD siswa + email orang tua, toggle aktif/nonaktif, unggah via Excel (template `template_siswa.xlsx`).
- Ruangan/Kelas Detail: CRUD `DETAIL_KELAS` (kode, nama ruang & nama kelas tampilan).
- Pelajaran: CRUD master pelajaran (nama, status, jam wajib, tingkat kelas).
- Master Jam Pelajaran: CRUD slot hari/jam termasuk tipe `Pelajaran/Istirahat`.
- Jadwal Kelas: tetapkan mata pelajaran ke slot harian per kelas (validasi mapel kelas & slot istirahat kosong).
- Periode: tambah otomatis (ganjil/genap), update, hapus (selama belum ada kelas).
- Kelas: CRUD kelas per periode (ruangan, wali, kapasitas, nama); tarik daftar per periode.
- Mata Pelajaran per Kelas: assign guru + pelajaran + hari/jam, validasi bentrok guru/kelas, larangan ubah/hapus jika sudah ada pertemuan atau tugas; detail menampilkan pertemuan, siswa, absen.
- Enrollment Siswa ke Kelas: tambah/hapus siswa dengan cek kapasitas dan jejak absen/tugas; unggah via Excel `template_siswa_ke_kelas.xlsx`.
- Pengumuman: CRUD pengumuman umum.
- Laporan: laporan guru per periode (rata-rata nilai mapel), laporan kelas/mapel, laporan siswa per periode (nilai & rangking), tampilan raport siswa.
- Buku Pelajaran: CRUD PDF + streaming berwatermark, relasi ke kelas.
- Keuangan: kelola komponen & kategori biaya, batch penagihan (scope semua siswa / per kelas / per siswa), update status tagihan; lihat daftar tagihan.
- Impor Excel lain: kelas (`template_kelas.xlsx`), nilai (`template_nilai.xlsx`).

### Guru (/guru)
- Dashboard: jadwal pribadi, mata pelajaran yang diajar pada periode aktif, tugas yang belum jatuh tempo, pengumuman.
- Detail Mata Pelajaran: lihat kelas, siswa, pertemuan, materi, tugas, nilai tugas/ujian, rata-rata, absen.
- Pengumuman Mapel: tambah, edit, hapus pengumuman terkait mapel.
- Pertemuan: CRUD pertemuan (tanggal, detail); hapus/update dengan redirect ke detail mapel.
- Materi: unggah/ubah/hapus file materi per mapel (simpan ke `storage/app/public/uploads/materi`).
- Tugas: buat tugas, edit/hapus, lihat detail pengumpulan, klasifikasi siswa sudah/belum kumpul.
- Penilaian: input nilai tugas per submission, nilai UTS/UAS per siswa; unggah nilai via Excel (`upload_nilai`).
- Absensi: update status hadir/izin/sakit/alpa per pertemuan & siswa.
- Jadwal & Kelas: lihat jadwal mengajar per periode, daftar kelas yang diampu.
- Laporan: rekap nilai tugas dan ujian per kelas/periode; laporan per siswa.
- Wali Kelas: melihat data kelas yang diwalikan (siswa, jumlah, periode).
- Profil: lihat & ubah biodata.

### Siswa (/siswa)
- Dashboard: pengumuman, daftar mapel di kelas terakhir, tugas aktif, jadwal per hari, info kelas/periode.
- Detail Mata Pelajaran: lihat tugas (dengan hitung submission), materi, info guru/kelas/semester.
- Tugas: lihat detail tugas, unggah file jawaban (disimpan `uploads/tugas`), lihat status nilai & deadline.
- Jadwal & Kelas: jadwal kelas terakhir; daftar mapel beserta guru; info kelas & periode.
- Laporan: laporan tugas (sudah/belum dikirim, rata-rata nilai tugas), laporan ujian (UTS/UAS per mapel), raport/nilai lengkap per periode (termasuk wali kelas, rata-rata, rangking & status kelulusan), libur nasional (static view).
- Profil: lihat & ubah biodata, ganti password (bcrypt).

### Orang Tua (/orangtua)
- Dashboard: info anak (kelas terakhir, periode, jadwal, tugas aktif, materi terbaru), statistik kehadiran, pengumuman terbaru.
- Tagihan: daftar tagihan siswa (komponen, periode, status, riwayat pembayaran). Dapat memulai pembayaran Midtrans (Snap token dikembalikan).
- Pembayaran: validasi kepemilikan tagihan & status; integrasi Midtrans Snap; redirect finish ke halaman tagihan.

### Perpustakaan Buku (akses Admin/Guru/Siswa/Orang Tua)
- List buku aktif, filter per kelas, streaming PDF dengan watermark (FPDI). Admin dapat CRUD & atur kelas yang dapat mengakses.

## 5. Integrasi & Ekstensi
- **Midtrans**: Snap transaction (ParentController@payFee) & webhook (PaymentController@midtransCallback). Status fee dipetakan ke Paid/Pending/Overdue/Cancelled. Payment dicatat di tabel `PAYMENT`.
- **Impor Excel**: Guru, Siswa, Kelas, Siswa→Kelas, Nilai (Import classes `Insert*Excel`).
- **AI Endpoint**: `/ask-gemini` handled by `GeminiController@ask` (tidak dibahas detail di routes lainnya).

## 6. Reset Password
- Form `/reset-password`: kirim email baru acak (10 char) ke email siswa atau orang tua; password disimpan bcrypt; selalu balas sukses untuk cegah enumerasi.

## 7. Entitas Utama (ringkas)
- Users/admin (`USERS`), Guru (`GURU`), Siswa (`SISWA` dengan `EMAIL_ORANGTUA` dan kredensial ortu terpisah), Periode (`PERIODE`), Detail kelas (`DETAIL_KELAS`), Kelas (`KELAS` + wali & kapasitas), Enrollment siswa (`ENROLLMENT_KELAS`), Master pelajaran (`PELAJARAN`), Penugasan kelas/mapel (`MATA_PELAJARAN`), Pertemuan, Materi, Tugas, Submission tugas, Nilai kelas (UTS/UAS/Tugas), Absensi, Master jam & Jadwal kelas, Pengumuman, Buku Pelajaran, Keuangan (FeeComponent, FeeCategory, StudentFee, Payment).

## 8. Alur Data Akademik (contoh)
1) Admin buat periode, kelas, ruang, guru, siswa → assign wali kelas & kapasitas.
2) Admin assign mata pelajaran ke kelas + jadwal jam/hari.
3) Guru menambah pertemuan, materi, dan tugas; siswa mengumpulkan; guru menilai (manual atau impor Excel) & absen.
4) Laporan nilai/absen tersedia untuk guru & admin; siswa/orang tua melihat raport versi siswa.

## 9. Alur Pembayaran
1) Admin membuat komponen & tagihan (batch atau per siswa) → status `Unpaid`.
2) Orang tua membuka halaman tagihan, klik bayar → permintaan Snap token ke Midtrans dengan invoice `INVOICE_CODE`.
3) Orang tua menyelesaikan pembayaran di Snap; Midtrans memanggil webhook → sistem mengubah status tagihan dan mencatat payment (nilai, metode, txn id).

## 10. Catatan Implementasi & Batasan
- Autentikasi berbasis session custom (bukan Laravel default guard multi-role). Jaga konsistensi `session('userActive')` saat menambah fitur.
- Banyak operasi CRUD langsung via query builder/raw SQL; perhatikan validasi & sanitasi input bila menambah endpoint.
- Beberapa route menggunakan `base64_encode/ decode` untuk ID di URL.
- File upload disimpan di `storage/app/public/...`; pastikan symlink `public/storage` aktif.
- Template Excel berada di `storage/app/template_excel/` (guru, siswa, kelas, siswa ke kelas, nilai).

## 11. Rute Penting (ringkas)
- Auth & umum: `/`, `/reset-password`, `/register`, `/home`, `/ask-gemini`.
- Admin: prefix `/admin` mencakup guru, siswa, ruangan, pelajaran, master jam, jadwal kelas, periode, kelas, mata pelajaran, enrol siswa, pengumuman, laporan, buku, keuangan.
- Guru: prefix `/guru` mencakup dashboard, jadwal/kelas, detail mapel, pertemuan, materi, tugas, penilaian, pengumuman, wali kelas, upload nilai.
- Siswa: prefix `/siswa` mencakup dashboard, detail pelajaran, tugas, jadwal, kelas, laporan tugas/ujian/raport, profil, libur nasional.
- Orang Tua: prefix `/orangtua` mencakup dashboard & tagihan (bayar).
- Pembayaran: webhook `/midtrans/webhook`.
- Perpustakaan: `/buku` di masing-masing prefix + streaming `/buku/{id}/view`.

## 12. Cara Memulai (ringkas)
1) Pastikan env & DB terisi (migrasi + seeder jika ada). Pastikan konfigurasi Midtrans (`services.midtrans.*`).
2) Jalankan `composer install`, `npm install` (jika perlu build front-end), lalu `php artisan serve`.
3) Pastikan `storage:link` untuk akses file upload.
4) Login: admin default `admin/admin`, atau gunakan akun guru/siswa/orang tua sesuai data DB.

Dokumen ini merangkum fitur dan alur yang ada di repository per 17 Jan 2026.
