<?php

namespace App\Http\Controllers;

use App\Imports\InsertGuruExcel;
use App\Imports\InsertKelasExcel;
use App\Imports\InsertSiswaExcel;
use App\Imports\InsertSiswaKeKelasExcel;
use App\Models\Attendance;
use App\Models\DetailKelas;
use App\Models\EnrollmentKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Pelajaran;
use App\Models\Pengumuman;
use App\Models\Periode;
use App\Models\Pertemuan;
use App\Models\JadwalKelas;
use App\Models\MasterJamPelajaran;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Str;

class AdminController extends Controller
{
    public function index()
    {
        $latestPeriode = Periode::orderByDesc('ID_PERIODE')->first();
        $jumlahSiswa = Siswa::where('STATUS_SISWA', 'Active')->count();
        $jumlahGuru = Guru::where('STATUS_GURU', 'Active')->count();
        $jumlahKelas = Kelas::where('ID_PERIODE', $latestPeriode->ID_PERIODE)->count();
        $jumlahPelajaran = Pelajaran::count();
        $jumlahMataPelajaran = MataPelajaran::whereIn(
            'ID_KELAS',
            function ($query) use ($latestPeriode) {
                $query->select('ID_KELAS')
                    ->from('kelas')
                    ->where('ID_PERIODE', $latestPeriode->ID_PERIODE);
            }
        )->count();
        $listPengumuman = Pengumuman::orderByDesc('ID_PENGUMUMAN')->limit(10)->get();
        return view('admin_pages.home', compact('latestPeriode', 'jumlahSiswa', 'jumlahGuru', 'jumlahKelas', 'jumlahPelajaran', 'jumlahMataPelajaran', 'listPengumuman'));
    }
    // ========================================= Guru ===================================================
    public function geteditguru($id_guru)
    {
        $id_guru = base64_decode($id_guru);
        $guru = DB::select("select * from guru where id_guru = ?", [$id_guru]);
        if (count($guru) <= 0) {
            $allGuru = DB::select("select * from guru");
            return view('admin_pages.listguru', ["allGuru" => $allGuru]);
        } else {
            return view('admin_pages.editguru', ["guru" => $guru[0]]);
        }
    }
    public function editguru(Request $request, $id_guru)
    {
        $id_guru = base64_decode($id_guru);
        $guru = DB::select("select * from guru where id_guru = ?", [$id_guru]);
        if (count($guru) > 0) {
            $id = $request->input("id");
            $nama = $request->input("nama");
            $email = $request->input("email");
            $alamat = $request->input("alamat");
            $telp = $request->input("telp");
            $status = $request->input("status");
            DB::update("update guru set nama_guru = ?, email_guru = ?, alamat_guru = ?, no_telpon_guru = ?, status_guru = ? where id_guru = ?", [$nama, $email, $alamat, $telp, $status, $id]);
        }
        return redirect('/admin/listguru');
    }
    public function listguru()
    {
        $allGuru = DB::select("select * from guru");
        return view('admin_pages.listguru', ["allGuru" => $allGuru]);
    }
    public function hapusguru($id_guru)
    {
        $id_guru = base64_decode($id_guru);
        $guru = DB::select("select * from guru where id_guru = ?", [$id_guru]);
        if (count($guru) > 0) {
            $status = '';
            if ($guru[0]->STATUS_GURU == "Active") {
                $status = "Inactive";
            } else {
                $status = "Active";
            }
            DB::update("update guru set status_guru = ? where id_guru = ?", [$status, $id_guru]);
        }
        return redirect('/admin/listguru');
    }
    public function postguru(Request $request)
    {
        $nama = $request->input("nama");
        $email = $request->input("email");
        $password = $request->input("password");
        $alamat = $request->input("alamat");
        $telp = $request->input("telp");
        $status = $request->input("status");
        // $guru = DB::select("select * from guru where email_guru = ?", [$email]);
        // if (count($guru) <= 0) {
        //     DB::insert("insert into guru (nama_guru, email_guru, password_guru, alamat_guru, no_telpon_guru, status_guru) values(?,?,?,?,?,?)", [$nama, $email, $password, $alamat, $telp, $status]);
        // } else {
        //     return view('admin_pages.tambahguru');
        // }
        $guru = Guru::where('EMAIL_GURU', $email)->get();
        if (!$guru->isEmpty()) {
            return view('admin_pages.tambahguru');
        } else {
            // dd(Hash::make($password));

            $guru = Guru::create([
                'NAMA_GURU' => $nama,
                'EMAIL_GURU' => $email,
                // nyalain
                'PASSWORD_GURU' => Hash::make($password),
                // 'PASSWORD_GURU' => $password,
                'ALAMAT_GURU' => $alamat,
                'NO_TELPON_GURU' => $telp,
                'STATUS_GURU' => $status,
            ]);
            return redirect('/admin/listguru');

        }
    }
    public function displayUploadGuru()
    {
        return view('admin_pages.upload_guru');
    }
    public function uploadGuru(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            // Correct way to call the import() method:
            Excel::import(new InsertGuruExcel, $request->file('file')); // Using the Facade

            // Or, using dependency injection (better approach):
            // $excel = app('excel');
            // $excel->import(new InsertSiswaExcel, $request->file('file'));

            Session::flash('success', 'Data imported successfully!'); // Use session
        } catch (\Exception $e) {
            Session::flash('error', 'Import failed: ' . $e->getMessage());
        }

        return redirect()->back();
    }
    // ========================================= Pengumuman ============================================
    public function geteditpengumuman($id)
    {
        $id = base64_decode($id);
        $pengumuman = Pengumuman::find($id);
        return view('admin_pages.editpengumuman', ["pengumuman" => $pengumuman]);
    }
    public function editpengumuman(Request $request, $id)
    {
        $id = base64_decode($id);
        $pengumuman = Pengumuman::find($id);
        $pengumuman->Judul = $request->input('Judul');
        $pengumuman->Deskripsi = $request->input('Deskripsi');
        $pengumuman->save();
        return redirect('/admin/listpengumuman');
    }
    public function listpengumuman()
    {
        $allpengumuman = Pengumuman::all();
        return view('admin_pages.listpengumuman', ["allpengumuman" => $allpengumuman]);
    }
    public function postpengumuman(Request $request)
    {
        $validatedData = $request->validate([
            'Judul' => 'required|max:255',
            'Deskripsi' => 'required',
        ]);
        $pengumuman = Pengumuman::create($validatedData);
        return redirect('/admin/listpengumuman');
    }
    public function hapuspengumuman($id_pengumuman)
    {
        $id_pengumuman = base64_decode($id_pengumuman);
        $pengumuman = Pengumuman::find($id_pengumuman);
        $pengumuman->delete();
        return redirect('/admin/listpengumuman');
    }
    // ========================================= Siswa =================================================
    public function geteditsiswa($id_siswa)
    {
        $id_siswa = base64_decode($id_siswa);
        $siswa = DB::select("select * from siswa where id_siswa = ?", [$id_siswa]);
        if (count($siswa) <= 0) {
            $allsiswa = DB::select("select * from siswa");
            return view('admin_pages.listsiswa', ["allsiswa" => $allsiswa]);
        } else {
            return view('admin_pages.editsiswa', ["siswa" => $siswa[0]]);
        }
    }
    public function editsiswa(Request $request, $id_siswa)
    {
        $id_siswa = base64_decode($id_siswa);
        $siswa = DB::select("select * from siswa where id_siswa = ?", [$id_siswa]);
        if (count($siswa) > 0) {
            $id = $request->input("id");
            $nama = $request->input("nama");
            $email = $request->input("email");
            $emailOrtu = $request->input("email_orangtua");
            $alamat = $request->input("alamat");
            $telp = $request->input("telp");
            $status = $request->input("status");
            DB::update(
                "update siswa set nama_siswa = ?, email_siswa = ?, email_orangtua = ?, alamat_siswa = ?, no_telpon_siswa = ?, status_siswa = ? where id_siswa = ?",
                [$nama, $email, $emailOrtu, $alamat, $telp, $status, $id]
            );
        }
        return redirect('/admin/listsiswa')->with('success', 'Data siswa diperbarui');
    }
    public function listsiswa()
    {
        $allsiswa = DB::select("select * from siswa");
        return view('admin_pages.listsiswa', ["allsiswa" => $allsiswa]);
    }
    public function hapussiswa($id_siswa)
    {
        $id_siswa = base64_decode($id_siswa);
        $siswa = DB::select("select * from siswa where id_siswa = ?", [$id_siswa]);
        if (count($siswa) > 0) {
            $status = '';
            if ($siswa[0]->STATUS_SISWA == "Active") {
                $status = "Inactive";
            } else {
                $status = "Active";
            }
            DB::update("update siswa set status_siswa = ? where id_siswa = ?", [$status, $id_siswa]);
        }
        return redirect('/admin/listsiswa');
    }
    public function postsiswa(Request $request)
    {
        $nama = $request->input("nama");
        $email = $request->input("email");
        $emailOrtu = $request->input("email_orangtua");
        $password = $request->input("password");
        $alamat = $request->input("alamat");
        $telp = $request->input("telp");
        $status = $request->input("status");
        // $siswa = DB::select("select * from siswa where email_siswa = ?", [$email]);
        // if (count($siswa) <= 0) {
        //     DB::insert("insert into siswa (nama_siswa, email_siswa, password_siswa, alamat_siswa, no_telpon_siswa, status_siswa) values(?,?,?,?,?,?)", [$nama, $email, $password, $alamat, $telp, $status]);
        //     return redirect('/admin/listsiswa');
        // } else {
        //     return view('admin_pages.tambahsiswa');
        // }
        $siswa = Siswa::where('EMAIL_SISWA', $email)->orWhere('EMAIL_ORANGTUA', $emailOrtu)->get();
        if (!$siswa->isEmpty()) {
            return redirect('/admin/tambahsiswa')->with('error', 'Email siswa atau email orang tua sudah terdaftar');
        } else {
            Siswa::create([
                'NAMA_SISWA' => $nama,
                'EMAIL_SISWA' => $email,
                'EMAIL_ORANGTUA' => $emailOrtu,
                // nyalain
                'PASSWORD_SISWA' => Hash::make($password),
                // 'PASSWORD_SISWA' => $password,
                'ALAMAT_SISWA' => $alamat,
                'NO_TELPON_SISWA' => $telp,
                'STATUS_SISWA' => $status,
            ]);
            return redirect('/admin/listsiswa')->with('success', 'Siswa berhasil ditambahkan');
        }
    }
    public function displayUploadSiswa()
    {
        return view('admin_pages.upload_siswa');
    }
    public function uploadSiswa(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            // Correct way to call the import() method:
            Excel::import(new InsertSiswaExcel, $request->file('file')); // Using the Facade

            // Or, using dependency injection (better approach):
            // $excel = app('excel');
            // $excel->import(new InsertSiswaExcel, $request->file('file'));

            Session::flash('success', 'Data imported successfully!'); // Use session
        } catch (\Exception $e) {
            Session::flash('error', 'Import failed: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    // ========================================= Pelajaran ============================================
    public function list_pelajaran()
    {
        // Pastikan status terisi; default Active jika kolom tersedia
        if (Schema::hasColumn('PELAJARAN', 'STATUS')) {
            Pelajaran::whereNull('STATUS')->update(['STATUS' => 'Active']);
        }

        $kelasList = Pelajaran::all();
        return view('admin_pages.list_pelajaran', compact('kelasList'));
    }
    public function tambah_pelajaran()
    {
        return view('admin_pages.tambah_pelajaran');
    }
    public function postpelajaran(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pelajaran,NAMA_PELAJARAN',
            'required_hours' => 'required|integer|min:0|max:40',
            'class_level' => 'required|string|max:50',
        ], [
            'name.unique' => 'Nama Pelajaran sudah digunakan. Silakan pilih nama lain.'
        ]);
        Pelajaran::create([
            'NAMA_PELAJARAN' => $request->input('name'),
            'STATUS' => 'Active',
            'JML_JAM_WAJIB' => $request->input('required_hours'),
            'KELAS_TINGKAT' => $request->input('class_level'),
        ]);
        return redirect()->route('list_pelajaran')->with('success', 'Nama berhasil disimpan!');
    }
    public function hapuspelajaran($id)
    {
        $pelajaran = Pelajaran::find($id);
        $pelajaran->STATUS == "Active" ? $pelajaran->STATUS = "Inactive" : $pelajaran->STATUS = "Active";
        $pelajaran->save();
        return redirect()->route('list_pelajaran')->with('success', 'Berhasil update!');

    }

    public function update_pelajaran(Request $request, $id)
    {
        $pelajaran = Pelajaran::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                Rule::unique('pelajaran', 'NAMA_PELAJARAN')->ignore($pelajaran->ID_PELAJARAN, 'ID_PELAJARAN'),
            ],
            'status' => 'required|in:Active,Inactive',
            'required_hours' => 'required|integer|min:0|max:40',
            'class_level' => 'required|string|max:50',
        ]);

        $pelajaran->NAMA_PELAJARAN = $request->input('name');
        $pelajaran->STATUS = $request->input('status');
        $pelajaran->JML_JAM_WAJIB = $request->input('required_hours');
        $pelajaran->KELAS_TINGKAT = $request->input('class_level');
        $pelajaran->save();

        return redirect()->route('list_pelajaran')->with('success', 'Pelajaran berhasil diperbarui');
    }

    // ========================================= Master Jam Pelajaran ================================
    public function master_jam_pelajaran()
    {
        $jamList = MasterJamPelajaran::orderBy('HARI_PELAJARAN')
            ->orderBy('SLOT_KE')
            ->get();

        return view('admin_pages.master_jam_pelajaran', compact('jamList'));
    }

    public function store_master_jam_pelajaran(Request $request)
    {
        $request->validate([
            'HARI_PELAJARAN' => 'required|string',
            'SLOT_KE' => 'required|integer|min:1|max:20',
            'JAM_MULAI' => 'required|date_format:H:i',
            'JAM_SELESAI' => 'required|date_format:H:i|after:JAM_MULAI',
            'JENIS_SLOT' => 'required|in:Pelajaran,Istirahat',
            'LABEL' => 'nullable|string|max:255',
        ]);

        MasterJamPelajaran::create([
            'HARI_PELAJARAN' => $request->HARI_PELAJARAN,
            'SLOT_KE' => $request->SLOT_KE,
            'JAM_MULAI' => $request->JAM_MULAI,
            'JAM_SELESAI' => $request->JAM_SELESAI,
            'JENIS_SLOT' => $request->JENIS_SLOT,
            'LABEL' => $request->LABEL,
        ]);

        return redirect()->route('master_jam_pelajaran')->with('success', 'Jam pelajaran ditambahkan');
    }

    public function update_master_jam_pelajaran(Request $request, $id)
    {
        $jam = MasterJamPelajaran::findOrFail($id);

        $request->validate([
            'HARI_PELAJARAN' => 'required|string',
            'SLOT_KE' => 'required|integer|min:1|max:20',
            'JAM_MULAI' => 'required|date_format:H:i',
            'JAM_SELESAI' => 'required|date_format:H:i|after:JAM_MULAI',
            'JENIS_SLOT' => 'required|in:Pelajaran,Istirahat',
            'LABEL' => 'nullable|string|max:255',
        ]);

        $jam->update([
            'HARI_PELAJARAN' => $request->HARI_PELAJARAN,
            'SLOT_KE' => $request->SLOT_KE,
            'JAM_MULAI' => $request->JAM_MULAI,
            'JAM_SELESAI' => $request->JAM_SELESAI,
            'JENIS_SLOT' => $request->JENIS_SLOT,
            'LABEL' => $request->LABEL,
        ]);

        return redirect()->route('master_jam_pelajaran')->with('success', 'Jam pelajaran diperbarui');
    }

    public function delete_master_jam_pelajaran($id)
    {
        $jam = MasterJamPelajaran::findOrFail($id);
        $jam->delete();
        return redirect()->route('master_jam_pelajaran')->with('success', 'Jam pelajaran dihapus');
    }

    // ========================================= Jadwal Kelas =======================================
    public function jadwal_kelas()
    {
        $kelasList = Kelas::with('detailKelas')
            ->orderBy('ID_KELAS')
            ->get();

        return view('admin_pages.jadwal_kelas', compact('kelasList'));
    }

    public function jadwal_kelas_detail($id_kelas)
    {
        $kelas = Kelas::with(['detailKelas', 'wali'])->findOrFail($id_kelas);

        $slotList = MasterJamPelajaran::orderBy('HARI_PELAJARAN')
            ->orderBy('SLOT_KE')
            ->get();

        $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $slotByDay = $slotList->groupBy('HARI_PELAJARAN');

        $jadwal = JadwalKelas::where('ID_KELAS', $id_kelas)->get()->keyBy('ID_JAM_PELAJARAN');

        $mataList = MataPelajaran::where('ID_KELAS', $id_kelas)
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->leftJoin('GURU', 'MATA_PELAJARAN.ID_GURU', '=', 'GURU.ID_GURU')
            ->select(
                'MATA_PELAJARAN.ID_MATA_PELAJARAN',
                'PELAJARAN.NAMA_PELAJARAN',
                'GURU.NAMA_GURU'
            )
            ->get();

        return view('admin_pages.jadwal_kelas_detail', [
            'kelas' => $kelas,
            'slotByDay' => $slotByDay,
            'daysOrder' => $daysOrder,
            'jadwal' => $jadwal,
            'mataList' => $mataList,
        ]);
    }

    public function jadwal_kelas_assign(Request $request)
    {
        $request->validate([
            'ID_KELAS' => 'required|string',
            'ID_JAM_PELAJARAN' => 'required|integer',
            'ID_MATA_PELAJARAN' => 'nullable|string',
        ]);

        $idKelas = $request->ID_KELAS;
        $idJam = $request->ID_JAM_PELAJARAN;
        $idMapel = $request->ID_MATA_PELAJARAN ?: null;

        $slot = MasterJamPelajaran::findOrFail($idJam);

        if ($idMapel) {
            $mapelValid = MataPelajaran::where('ID_MATA_PELAJARAN', $idMapel)
                ->where('ID_KELAS', $idKelas)
                ->exists();
            if (!$mapelValid) {
                return redirect()->back()->withErrors('Mata pelajaran tidak sesuai dengan kelas ini.');
            }
        }

        // Untuk slot Istirahat, paksa kosong
        if ($slot->JENIS_SLOT === 'Istirahat') {
            $idMapel = null;
        }

        JadwalKelas::updateOrCreate(
            [
                'ID_KELAS' => $idKelas,
                'ID_JAM_PELAJARAN' => $idJam,
            ],
            [
                'ID_MATA_PELAJARAN' => $idMapel,
            ]
        );

        return redirect()->back()->with('success', 'Jadwal diperbarui');
    }
    // ========================================= Periode ===========================================
    public function list_periode()
    {
        $periodeList = Periode::all();
        return view('admin_pages.list_periode', compact('periodeList'));
    }
    public function add_periode()
    {
        $latestPeriode = Periode::orderBy('ID_PERIODE', 'desc')->first()->PERIODE;
        $detail = "Tahun ";
        $detailTahun = trim(explode(" ", explode("/", $latestPeriode)[0])[1]);
        $tahun = Str::contains($latestPeriode, 'GANJIL') ? (int) $detailTahun : (int) date('Y');
        $tahun2 = $tahun + 1;
        $detailSemester = Str::contains($latestPeriode, 'GANJIL') ? 'GENAP' : 'GANJIL';
        $detail = $detail . $tahun . "/" . $tahun2 . " " . $detailSemester;
        $adaPeriode = Periode::where('PERIODE', $detail)->get();
        if (!$adaPeriode->isEmpty()) {
            return redirect()->route('list_periode')->with('error', 'Periode sudah terbaru');
        }
        Periode::create([
            'PERIODE' => $detail
        ]);
        return redirect()->route('list_periode')->with('success', 'Berhasil tambah periode');
    }
    public function delete_periode($id_periode)
    {
        $adaKelas = Kelas::where('ID_PERIODE', $id_periode)->get();
        if ($adaKelas->isEmpty()) {
            Periode::find($id_periode)->delete();
            return redirect()->route('list_periode')->with('success', 'Berhasil delete periode');
        }
        return redirect()->route('list_periode')->with('error', value: 'Sudah ada kelas dalam periode');
    }

    public function update_periode(Request $request, $id_periode)
    {
        $periode = Periode::findOrFail($id_periode);

        $request->validate([
            'periode' => [
                'required',
                Rule::unique('periode', 'PERIODE')->ignore($periode->ID_PERIODE, 'ID_PERIODE'),
            ],
        ]);

        $periode->PERIODE = $request->input('periode');
        $periode->save();

        return redirect()->route('list_periode')->with('success', 'Periode berhasil diperbarui');
    }

    // ========================================= Ruangan ============================================
    public function list_ruangan()
    {
        $ruanganList = DetailKelas::all();
        return view('admin_pages.list_ruangan', compact('ruanganList'));
    }
    public function add_ruangan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_ruangan' => 'required|string|unique:DETAIL_KELAS,KODE_RUANGAN',
            'nama_ruangan' => 'required|string',
            'nama_kelas' => 'required|string',
        ]);
        $validator->after(function ($validator) use ($request) {
            $nama_ruangan = $request->nama_ruangan;
            $isRuanganExists = DetailKelas::where('RUANGAN_KELAS', $nama_ruangan)->exists();
            if ($isRuanganExists) {
                $validator->error()->add('error', 'Ruangan sudah ada');
            }
        });
        $validator->validate();
        DetailKelas::create(attributes: [
            'KODE_RUANGAN' => $request->kode_ruangan,
            'RUANGAN_KELAS' => $request->nama_ruangan,
            'NAMA_KELAS' => $request->nama_kelas
        ]);
        return redirect()->route('list_ruangan');

    }
    public function edit_ruangan(Request $request)
    {
        $validated = Validator::validate($request->all(), [
            'id_ruangan'   => 'required|integer',
            'kode_ruangan' => 'required|string|unique:DETAIL_KELAS,KODE_RUANGAN,' . $request->id_ruangan . ',ID_DETAIL_KELAS',
            'nama_ruangan' => 'required|string',
            'nama_kelas'   => 'required|string',
        ]);

        $ruanganToEdit = DetailKelas::findOrFail($validated['id_ruangan']);
        $ruanganToEdit->KODE_RUANGAN = $validated['kode_ruangan'];
        $ruanganToEdit->RUANGAN_KELAS = $validated['nama_ruangan'];
        $ruanganToEdit->NAMA_KELAS = $validated['nama_kelas'];
        $ruanganToEdit->save();

        return redirect()->route('list_ruangan')->with('success', 'Ruangan berhasil diperbarui');
    }

    public function delete_ruangan(Request $request)
    {
        $validated = Validator::validate($request->all(), [
            'id_ruangan' => 'required|integer',
        ]);

        $ruangan = DetailKelas::find($validated['id_ruangan']);

        if (!$ruangan) {
            return redirect()->route('list_ruangan')->with('error', 'Ruangan tidak ditemukan');
        }

        $ruangan->delete();

        return redirect()->route('list_ruangan')->with('success', 'Ruangan berhasil dihapus');
    }

    // ========================================= Laporan ============================================
    public function laporanguru(Request $request)
    {
        if ($request->query('periodeSelect')) {
            $periode = Periode::where('ID_PERIODE', $request->query('periodeSelect'))->first();
        } else {
            $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();
        }
        $all_periode = Periode::all();
        $all_guru = Guru::all();
        return view('admin_pages.laporanguru', ["all_guru" => $all_guru, "all_periode" => $all_periode, "periode" => $periode]);
    }
    public function hlm_report_guru(Request $request)
    {
        $id_periode = $request->query('id_periode');
        $id_guru = $request->query('id_guru');

        $guru = Guru::where("ID_GURU", $id_guru)->first();
        $periode = Periode::where("ID_PERIODE", $id_periode)->first();

        $list_report = DB::table("mata_pelajaran as mp")
            ->join("pelajaran as p", 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->join('kelas as k', 'mp.id_kelas', '=', 'k.id_kelas')
            ->join('detail_kelas as dk', 'k.id_detail_kelas', '=', 'dk.id_detail_kelas')
            ->leftJoin('nilai_kelas as nk', 'mp.id_mata_pelajaran', '=', 'nk.id_mata_pelajaran')
            ->where([['mp.id_guru', $id_guru], ['k.id_periode', $id_periode]])
            ->groupBy(
                'mp.id_mata_pelajaran',
                'mp.id_guru',
                'k.id_periode',
                'p.nama_pelajaran',
                'dk.nama_kelas'
            )
            ->select('mp.id_mata_pelajaran', 'mp.id_guru', 'k.id_periode', 'p.nama_pelajaran', 'dk.nama_kelas', DB::raw('AVG(nk.nilai_akhir) as rata2'))
            ->get();

        $jumlahMapel = DB::table("mata_pelajaran as mp")
            ->join('kelas as k', 'mp.id_kelas', '=', 'k.id_kelas')
            ->where([
                ['mp.id_guru', '=', $id_guru],
                ['k.id_periode', '=', $id_periode]
            ])
            ->select(DB::raw('COUNT(mp.id_mata_pelajaran) as jml'))
            ->first();

        $jumlahDinilai = DB::table('mata_pelajaran as mp')
            ->join('pelajaran as p', 'mp.id_pelajaran', '=', 'p.id_pelajaran')
            ->join('kelas as k', 'mp.id_kelas', '=', 'k.id_kelas')
            ->join('detail_kelas as dk', 'k.id_detail_kelas', '=', 'dk.id_detail_kelas')
            ->leftJoin('nilai_kelas as nk', 'mp.id_mata_pelajaran', '=', 'nk.id_mata_pelajaran')
            ->select('mp.id_mata_pelajaran')
            ->where([
                ['mp.id_guru', '=', $id_guru],
                ['k.id_periode', '=', $id_periode]
            ])
            ->groupBy(
                'mp.id_mata_pelajaran'
            )
            ->havingRaw('AVG(nk.nilai_akhir) IS NOT NULL')
            ->get();

        $rata2_all = 0;
        foreach ($list_report as $report) {
            if ($report->rata2 !== null) {
                $rata2_all += $report->rata2;
            }
        }
        if (count($jumlahDinilai) > 0) {
            $rata2_all /= count($jumlahDinilai);
        }

        return view('admin_pages.hlm_report_guru', ["guru" => $guru, "periode" => $periode, "list_report" => $list_report, "jumlahMapel" => $jumlahMapel, "jumlahDinilai" => $jumlahDinilai, "rata2_all" => $rata2_all]);
    }
    public function laporansiswa(Request $request)
    {
        if ($request->query('periodeSelect')) {
            $periode = Periode::where('ID_PERIODE', $request->query('periodeSelect'))->first();
        } else {
            $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();
        }
        $all_periode = Periode::all();
        $all_siswa = Siswa::with(['kelass'])
            ->whereHas('kelass', function ($query) use ($periode) {
                $query->where('ID_PERIODE', $periode->ID_PERIODE);
            })->get();
        return view('admin_pages.laporansiswa', compact('all_siswa', 'all_periode', 'periode'));
    }
    public function getListSiswaLaporan($id_periode)
    {
        $id_periode = base64_decode($id_periode);
        $all_siswa = Siswa::with(['kelass'])
            ->whereHas('kelass', function ($query) use ($id_periode) {
                $query->where('ID_PERIODE', $id_periode);
            })->get();
        return response()->json($all_siswa);
    }
    public function hlm_report_siswa(Request $request)
    {
        $siswa = Siswa::find($request->query('id_siswa'));
        // Ambil daftar periode (semester) untuk dropdown, urut dari terbaru
        $daftarPeriode = DB::table('PERIODE')->orderByDesc('ID_PERIODE')->get();

        // Ambil periode dari query string, default ke periode terbaru jika kosong
        $periodeId = $request->query('periode');
        if (!$periodeId) {
            $periodeId = $daftarPeriode->first()->ID_PERIODE ?? null;
        }

        // Validasi periode yang dipilih ada dalam daftar periode
        $validPeriode = $daftarPeriode->where('ID_PERIODE', $periodeId)->first();
        if (!$validPeriode && $daftarPeriode->count() > 0) {
            $periodeId = $daftarPeriode->first()->ID_PERIODE;
            $validPeriode = $daftarPeriode->first();
        }

        // Ambil data mata pelajaran dan nilai siswa untuk periode terpilih
        $nilaiSiswa = DB::table('MATA_PELAJARAN')
            ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('ENROLLMENT_KELAS', 'KELAS.ID_KELAS', '=', 'ENROLLMENT_KELAS.ID_KELAS')
            ->join('PELAJARAN', 'MATA_PELAJARAN.ID_PELAJARAN', '=', 'PELAJARAN.ID_PELAJARAN')
            ->join('GURU', 'MATA_PELAJARAN.ID_GURU', '=', 'GURU.ID_GURU')
            ->join('DETAIL_KELAS', 'KELAS.ID_DETAIL_KELAS', '=', 'DETAIL_KELAS.ID_DETAIL_KELAS')
            ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
            ->leftJoin('NILAI_KELAS', function ($join) use ($siswa) {
                $join->on('MATA_PELAJARAN.ID_MATA_PELAJARAN', '=', 'NILAI_KELAS.ID_MATA_PELAJARAN')
                    ->where('NILAI_KELAS.ID_SISWA', '=', $siswa->ID_SISWA);
            })
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->where('KELAS.ID_PERIODE', '=', $periodeId)
            ->select(
                'MATA_PELAJARAN.ID_MATA_PELAJARAN',
                'MATA_PELAJARAN.JAM_PELAJARAN',
                'MATA_PELAJARAN.HARI_PELAJARAN',
                'PELAJARAN.NAMA_PELAJARAN',
                'GURU.NAMA_GURU',
                'GURU.ID_GURU',
                'DETAIL_KELAS.NAMA_KELAS',
                'PERIODE.PERIODE',
                'NILAI_KELAS.ID_NILAI',
                'NILAI_KELAS.NILAI_UTS',
                'NILAI_KELAS.NILAI_UAS',
                'NILAI_KELAS.NILAI_TUGAS',
                'NILAI_KELAS.NILAI_AKHIR'
            )
            ->get();

        // Ambil data wali kelas dari kelas yang diikuti siswa pada periode terpilih
        $waliKelas = DB::table('ENROLLMENT_KELAS')
            ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('GURU as WALI_GURU', 'KELAS.ID_GURU', '=', 'WALI_GURU.ID_GURU')
            ->join('DETAIL_KELAS', 'KELAS.ID_DETAIL_KELAS', '=', 'DETAIL_KELAS.ID_DETAIL_KELAS')
            ->join('PERIODE', 'KELAS.ID_PERIODE', '=', 'PERIODE.ID_PERIODE')
            ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
            ->where('KELAS.ID_PERIODE', '=', $periodeId)
            ->select(
                'WALI_GURU.ID_GURU as ID_WALI_KELAS',
                'WALI_GURU.NAMA_GURU as NAMA_WALI_KELAS',
                'WALI_GURU.EMAIL_GURU as EMAIL_WALI_KELAS',
                'DETAIL_KELAS.NAMA_KELAS',
                'DETAIL_KELAS.RUANGAN_KELAS',
                'PERIODE.PERIODE'
            )
            ->first(); // Ambil satu record saja karena biasanya siswa hanya di satu kelas per periode

        // Hitung rata-rata nilai per periode (hanya untuk mata pelajaran yang sudah ada nilai)
        $nilaiYangAda = $nilaiSiswa->whereNotNull('NILAI_AKHIR');
        $rataRataNilai = $nilaiYangAda->count() > 0 ? $nilaiYangAda->avg('NILAI_AKHIR') : 0;

        // Hitung total mata pelajaran yang diambil
        $totalMataPelajaran = $nilaiSiswa->count();

        // Hitung mata pelajaran yang sudah ada nilai
        $mataPelajaranDenganNilai = $nilaiYangAda->count();

        // Status kelulusan berdasarkan nilai rata-rata
        $statusKelulusan = $rataRataNilai >= 70 ? 'LULUS' : 'TIDAK LULUS';
        if ($mataPelajaranDenganNilai - $totalMataPelajaran != 0 || $mataPelajaranDenganNilai == 0) {
            $statusKelulusan = "-";
        }

        // Rangking siswa dalam kelas (opsional)
        $rangkingSiswa = DB::table('NILAI_KELAS')
            ->join('MATA_PELAJARAN', 'NILAI_KELAS.ID_MATA_PELAJARAN', '=', 'MATA_PELAJARAN.ID_MATA_PELAJARAN')
            ->join('KELAS', 'MATA_PELAJARAN.ID_KELAS', '=', 'KELAS.ID_KELAS')
            ->join('ENROLLMENT_KELAS', 'KELAS.ID_KELAS', '=', 'ENROLLMENT_KELAS.ID_KELAS')
            ->join('SISWA', 'NILAI_KELAS.ID_SISWA', '=', 'SISWA.ID_SISWA')
            ->where('KELAS.ID_PERIODE', '=', $periodeId)
            ->whereIn('KELAS.ID_KELAS', function ($query) use ($siswa, $periodeId) {
                $query->select('KELAS.ID_KELAS')
                    ->from('ENROLLMENT_KELAS')
                    ->join('KELAS', 'ENROLLMENT_KELAS.ID_KELAS', '=', 'KELAS.ID_KELAS')
                    ->where('ENROLLMENT_KELAS.ID_SISWA', '=', $siswa->ID_SISWA)
                    ->where('KELAS.ID_PERIODE', '=', $periodeId);
            })
            ->select('SISWA.NAMA_SISWA', DB::raw('AVG(NILAI_KELAS.NILAI_AKHIR) as rata_nilai'))
            ->groupBy('SISWA.ID_SISWA', 'SISWA.NAMA_SISWA')
            ->orderByDesc('rata_nilai')
            ->get();

        // Data tambahan untuk informasi periode yang dipilih
        $selectedPeriodeInfo = $validPeriode;

        return view('siswa_pages.hlm_report_siswa', [
            'nilaiSiswa' => $nilaiSiswa,
            'rataRataNilai' => $rataRataNilai,
            'totalMataPelajaran' => $totalMataPelajaran,
            'mataPelajaranDenganNilai' => $mataPelajaranDenganNilai,
            'statusKelulusan' => $statusKelulusan,
            'rangkingSiswa' => $rangkingSiswa,
            'daftarPeriode' => $daftarPeriode,
            'selectedPeriode' => $periodeId,
            'selectedPeriodeInfo' => $selectedPeriodeInfo,
            'waliKelas' => $waliKelas, // Data wali kelas ditambahkan
            'siswa' => $siswa
        ]);
    }

    // ================================== Tambah Kelas ===============================================

    // ================================== Kelas ======================================================
    public function list_kelas()
    {
        $semesters = Periode::all();
        $latestPeriode = Periode::orderByDesc('ID_PERIODE')->first()->ID_PERIODE;
        $classes = Kelas::where('ID_PERIODE', $latestPeriode)
            ->with(['detailKelas', 'wali'])
            ->get();
        $availableRooms = DetailKelas::whereDoesntHave('kelas', function ($query) use ($latestPeriode) {
            $query->where('ID_PERIODE', $latestPeriode);
        })->get();
        $availableGuru = Guru::whereDoesntHave('waliKelas', function ($query) use ($latestPeriode) {
            $query->where('ID_PERIODE', $latestPeriode);
        })->get();
        $kelasList = $classes->map(function ($item) {
            return [
                'id_kelas' => $item->ID_KELAS ?? '-',
                'ruangan_kelas' => $item->detailKelas->RUANGAN_KELAS ?? '-',
                'nama_kelas' => $item->NAMA_KELAS ?? ($item->detailKelas->NAMA_KELAS ?? '-'),
                'nama_wali' => $item->wali->NAMA_GURU ?? '-',
            ];
        });

        return view('admin_pages.list_kelas', compact('kelasList', 'semesters', 'latestPeriode', 'availableRooms', 'availableGuru'));
    }
    public function delete_kelas($id_kelas)
    {
        $kelas = Kelas::find($id_kelas)->delete();
        return redirect("admin/list_kelas");
    }
    public function get_list_kelas($semesterId)
    {
        $classes = Kelas::where('ID_PERIODE', $semesterId)
            ->with(['detailKelas', 'wali'])
            ->get();
        $kelasList = $classes->map(function ($item) {
            return [
                'id_kelas' => $item->ID_KELAS ?? '-',
                'ruangan_kelas' => $item->detailKelas->RUANGAN_KELAS ?? '-',
                'nama_kelas' => $item->NAMA_KELAS ?? ($item->detailKelas->NAMA_KELAS ?? '-'),
                'nama_wali' => $item->wali->NAMA_GURU ?? '-',
            ];
        });
        return response()->json($kelasList);
    }
    public function tambah_kelas()
    {
        $currPeriode = Periode::orderByDesc('ID_PERIODE')->first()->ID_PERIODE;
        $availableRooms = DetailKelas::whereDoesntHave('kelas', function ($query) use ($currPeriode) {
            $query->where('ID_PERIODE', $currPeriode);
        })->get();
        $availableGuru = Guru::whereDoesntHave('waliKelas', function ($query) use ($currPeriode) {
            $query->where('ID_PERIODE', $currPeriode);
        })->get();

        return view('admin_pages.tambah_kelas', ['availableRooms' => $availableRooms, 'availableGuru' => $availableGuru]);
    }

    public function edit_kelas($id)
    {
        // Find the class by its ID
        $kelas = Kelas::with(['detailKelas', 'wali'])->find($id);

        if (!$kelas) {
            return redirect()->route('list_kelas')->with('error', 'Class not found!');
        }
        $currPeriode = $kelas->ID_PERIODE;
        $availableRooms = DetailKelas::whereDoesntHave('kelas', function ($query) use ($currPeriode) {
            $query->where('ID_PERIODE', $currPeriode);
        })->get();
        $availableGuru = Guru::whereDoesntHave('waliKelas', function ($query) use ($currPeriode) {
            $query->where('ID_PERIODE', $currPeriode);
        })->get();

        // Pass the class data to the edit view
        return view('admin_pages.edit_kelas', compact('kelas', 'availableRooms', 'availableGuru'));
    }
    public function update_kelas(Request $request, $id)
    {
        // Find the class by ID
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return redirect()->route('list_kelas')->with('error', 'Class not found!');
        }

        $request->validate([
            'ruangan' => 'required|exists:detail_kelas,ID_DETAIL_KELAS',
            'wali_kelas' => 'required|exists:guru,ID_GURU',
            'kapasitas' => 'required|integer|min:1',
            'nama_kelas' => 'required|string|max:100',
        ]);

        // Update the class details
        $kelas->ID_DETAIL_KELAS = $request->input('ruangan');
        $kelas->ID_GURU = $request->input('wali_kelas');
        $kelas->KAPASITAS = $request->input('kapasitas', 0);
        $kelas->NAMA_KELAS = $request->input('nama_kelas');

        $kelas->save();

        return redirect()->route('list_kelas')->with('success', 'Class added successfully.');
    }
    public function add_kelas(Request $request)
    {
        $currPeriode = Periode::orderByDesc('ID_PERIODE')->first()->ID_PERIODE;

        // Validate input
        $validated = $request->validate([
            'ruangan' => 'required|exists:detail_kelas,ID_DETAIL_KELAS', // Adjust as needed
            'wali_kelas' => 'required|exists:guru,ID_GURU', // Adjust as needed
            'kapasitas' => 'required|integer|min:1',
            'nama_kelas' => 'required|string|max:100',
        ]);

        // Create new class
        $kelas = Kelas::create([
            'ID_DETAIL_KELAS' => $validated['ruangan'],
            'ID_GURU' => $validated['wali_kelas'],
            'ID_PERIODE' => $currPeriode,
            'KAPASITAS' => $validated['kapasitas'],
            'NAMA_KELAS' => $validated['nama_kelas'],
        ]);

        return redirect()->route('list_kelas')->with('success', 'Class added successfully.');
    }

    public function displayUploadKelas()
    {
        return view('admin_pages.upload_kelas');
    }
    public function uploadKelas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            // Correct way to call the import() method:
            Excel::import(new InsertKelasExcel, $request->file('file')); // Using the Facade

            // Or, using dependency injection (better approach):
            // $excel = app('excel');
            // $excel->import(new InsertSiswaExcel, $request->file('file'));

            Session::flash('success', 'Data imported successfully!'); // Use session
        } catch (\Exception $e) {
            Session::flash('error', 'Import failed: ' . $e->getMessage());
        }

        return redirect()->back();
    }


    // ================================== Mata Pelajaran =================================================
    public function list_mata_pelajaran($id)
    {
        $kelasList = MataPelajaran::where('ID_KELAS', $id)->with(['guru', 'pelajaran'])->get();
        $guruList = Guru::where("STATUS_GURU", "=", "Active")->get();
        $pelajaranList = Pelajaran::where("STATUS", "Active")->get();
        $id_kelas = $id;
        return view('admin_pages.list_mata_pelajaran', compact('id_kelas', 'kelasList', 'guruList', 'pelajaranList'));
    }
    public function add_mata_pelajaran(Request $request, $id_kelas)
    {
        $validator = Validator::make($request->all(), [
            'pengajar' => 'required|exists:guru,ID_GURU',
            'kelas' => 'required|exists:kelas,ID_KELAS',
            'hari' => 'required',
            'waktu' => 'required',
        ]);

        // Custom validation for schedule conflicts
        $validator->after(function ($validator) use ($request) {
            $time = $request->waktu;
            $day = $request->hari;
            $class = Kelas::find($request->kelas);
            if (!$class)
                return;
            $semester = $class->ID_PERIODE;

            $teacherBusy = MataPelajaran::whereHas('kelas', function ($query) use ($semester) {
                $query->where('ID_PERIODE', $semester);
            })
                ->where('ID_GURU', $request->pengajar)
                ->where('HARI_PELAJARAN', $day)
                ->where('JAM_PELAJARAN', $time)
                ->exists();
            if ($teacherBusy) {
                $validator->errors()->add('pengajar', 'Guru sudah memiliki jadwal pada waktu tersebut.');
            }
            // Check class conflict
            $classBusy = MataPelajaran::whereHas('kelas', function ($query) use ($semester) {
                $query->where('ID_PERIODE', $semester);
            })
                ->where('ID_KELAS', $request->kelas)
                ->where('HARI_PELAJARAN', $day)
                ->where('JAM_PELAJARAN', $time)
                ->exists();

            if ($classBusy) {
                $validator->errors()->add('waktu', 'Kelas sudah memiliki pelajaran pada waktu tersebut.');
            }
        });

        $validator->validate();

        MataPelajaran::create([
            'ID_GURU' => $request->pengajar,
            'ID_KELAS' => $request->kelas,
            'ID_PELAJARAN' => $request->pelajaran,
            'HARI_PELAJARAN' => $request->hari,
            'JAM_PELAJARAN' => $request->waktu
        ]);
        return redirect()->route('list_mata_pelajaran', ['id_kelas' => $request->kelas])->with('success', 'Jadwal berhasil ditambahkan.');
    }
    public function update_mata_pelajaran(Request $request, $id_mata_pelajaran)
    {
        // Temukan record MataPelajaran yang sudah ada berdasarkan ID
        // Jika tidak ditemukan, akan otomatis melempar 404
        $mataPelajaran = MataPelajaran::findOrFail($id_mata_pelajaran);

        // Validasi data yang masuk dari request
        $validator = Validator::make($request->all(), [
            'pengajar' => 'required|exists:guru,ID_GURU',
            'kelas' => 'required|exists:kelas,ID_KELAS',
            'pelajaran' => 'required|exists:pelajaran,ID_PELAJARAN', // Tambahkan validasi untuk ID Pelajaran
            'hari' => 'required',
            'waktu' => 'required',
        ]);

        // Validasi kustom untuk konflik jadwal
        $validator->after(function ($validator) use ($request, $mataPelajaran) {
            $time = $request->waktu;
            $day = $request->hari;
            $class = Kelas::find($request->kelas);

            // Jika kelas tidak ditemukan, segera kembali untuk menghindari error lebih lanjut
            if (!$class) {
                return;
            }

            $semester = $class->ID_PERIODE; // Ambil ID_PERIODE (semester) dari kelas

            // Cek konflik jadwal guru, kecualikan record mata pelajaran yang sedang diperbarui
            $teacherBusy = MataPelajaran::whereHas('kelas', function ($query) use ($semester) {
                $query->where('ID_PERIODE', $semester);
            })
                ->where('ID_GURU', $request->pengajar)
                ->where('HARI_PELAJARAN', $day)
                ->where('ID_MATA_PELAJARAN', '!=', $mataPelajaran->ID_MATA_PELAJARAN)
                ->where('JAM_PELAJARAN', $time)
                ->exists();

            if ($teacherBusy) {
                $validator->errors()->add('pengajar', 'Guru sudah memiliki jadwal pada waktu tersebut.');
            }

            // Cek konflik jadwal kelas, kecualikan record mata pelajaran yang sedang diperbarui
            $classBusy = MataPelajaran::whereHas('kelas', function ($query) use ($semester) {
                $query->where('ID_PERIODE', $semester);
            })
                ->where('ID_KELAS', $request->kelas)
                ->where('HARI_PELAJARAN', $day)
                ->where('ID_MATA_PELAJARAN', '!=', $mataPelajaran->ID_MATA_PELAJARAN)
                ->where('JAM_PELAJARAN', $time)
                ->exists();

            if ($classBusy) {
                $validator->errors()->add('waktu', 'Kelas sudah memiliki pelajaran pada waktu tersebut.');
            }
            $runningClass = Pertemuan::where('ID_MATA_PELAJARAN', $mataPelajaran->ID_MATA_PELAJARAN)->exists();
            $runningTugas = Tugas::where('ID_MATA_PELAJARAN', $mataPelajaran->ID_MATA_PELAJARAN)->exists();
            if ($runningClass || $runningTugas) {
                $validator->errors()->add('pelajaran', 'Mata Pelajaran sedang berjalan.');
            }

        });

        // Jalankan validasi
        $validator->validate();

        // Perbarui record MataPelajaran tanpa menghapus data terkait
        $mataPelajaran->ID_PELAJARAN = $request->pelajaran;
        $mataPelajaran->ID_GURU = $request->pengajar;
        $mataPelajaran->ID_KELAS = $request->kelas;
        $mataPelajaran->HARI_PELAJARAN = $request->hari;
        $mataPelajaran->JAM_PELAJARAN = $request->waktu;
        $mataPelajaran->save();

        // Redirect kembali ke daftar mata pelajaran untuk kelas yang diperbarui
        return redirect()->route('list_mata_pelajaran', ['id_kelas' => $request->kelas])->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function delete_mata_pelajaran(Request $request, $id_mata_pelajaran)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id_mata_pelajaran);
        $runningClass = Pertemuan::where('ID_MATA_PELAJARAN', $mataPelajaran->ID_MATA_PELAJARAN)->exists();
        $runningTugas = Tugas::where('ID_MATA_PELAJARAN', $mataPelajaran->ID_MATA_PELAJARAN)->exists();
        if ($runningClass || $runningTugas) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Delete'
            ]);
        }
        $mataPelajaran->delete();
        return response()->json([
            'success' => true,
            'message' => 'Mata Pelajaran berhasil delete'
        ]);
    }
    public function detail_mata_pelajaran($id_mata_pelajaran)
    {
        $pertemuan = Pertemuan::where('ID_MATA_PELAJARAN', '=', $id_mata_pelajaran)->orderBy('TANGGAL_PERTEMUAN', 'asc')->get();
        $mataPelajaran = MataPelajaran::with('pelajaran')->where('ID_MATA_PELAJARAN', $id_mata_pelajaran)->first();
        $kelas = Kelas::with('detailKelas')->where('ID_KELAS', '=', $mataPelajaran->ID_KELAS)->first();
        $siswa = EnrollmentKelas::with(['siswa', 'kelas'])->where('id_kelas', '=', $kelas->ID_KELAS)->get();
        $absen = DB::table('attendance as a')
            ->join('pertemuan as p', 'a.id_pertemuan', '=', 'p.id_pertemuan')
            ->join('siswa as s', 's.id_siswa', '=', 'a.id_siswa')
            ->where('p.id_mata_pelajaran', '=', $id_mata_pelajaran)
            ->select('a.id_attendance', 'p.id_pertemuan', 's.id_siswa', 's.nama_siswa')
            ->get();
        $arrAbsen = [];
        foreach ($absen as $a) {
            $arrAbsen[$a->id_siswa][$a->id_pertemuan] = $a;
        }
        $absen = $arrAbsen;
        return view('admin_pages.detail_mata_pelajaran', compact('absen', 'pertemuan', 'siswa'));
    }


    // ================================== Tambah Siswa =================================================
    public function list_tambah_siswa_ke_kelas($id_kelas)
    {
        $kelasDetail = Kelas::with('periode')->findOrFail($id_kelas);
        $currPeriode = $kelasDetail->ID_PERIODE;
        $kelasList = EnrollmentKelas::where('ID_KELAS', $id_kelas)->with(['siswa', 'kelas'])->get();
        $enrolledCount = $kelasList->count();
        $siswaList = Siswa::whereDoesntHave('kelass', function ($query) use ($currPeriode) {
            $query->where('ID_PERIODE', $currPeriode);
        })->where('STATUS_SISWA', 'Active')->get();
        // $siswaList = EnrollmentKelas::whereNotIn('ID_KELAS', [$id_kelas])->with(['siswa'])->get();
        return view('admin_pages.list_tambah_siswa_ke_kelas', compact('siswaList', 'kelasList', 'id_kelas', 'kelasDetail', 'enrolledCount'));
    }
    public function get_list_siswa_di_kelas($id_kelas)
    {
        $kelasList = EnrollmentKelas::where('ID_KELAS', $id_kelas)->with(['siswa', 'kelas'])->get();
        return response()->json($kelasList);
    }
    public function get_list_siswa_available($id_kelas)
    {
        $currPeriode = Kelas::find($id_kelas)->ID_PERIODE;
        $siswaList = Siswa::whereDoesntHave('kelass', function ($query) use ($currPeriode) {
            $query->where('ID_PERIODE', $currPeriode);
        })->where('STATUS_SISWA', 'Active')->get();
        return response()->json($siswaList);
    }
    public function tambah_siswa_ke_kelas(Request $request)
    {
        $siswaId = $request->input('idSiswa');
        $kelasId = $request->input('idKelas');
        $kelas = Kelas::findOrFail($kelasId);
        $kapasitas = (int)($kelas->KAPASITAS ?? 0);
        $enrolledCount = EnrollmentKelas::where('ID_KELAS', $kelasId)->count();
        if ($kapasitas > 0 && $enrolledCount >= $kapasitas) {
            return response()->json([
                'success' => false,
                'message' => 'Kapasitas kelas sudah penuh'
            ], 422);
        }
        EnrollmentKelas::create([
            'ID_KELAS' => $kelasId,
            'ID_SISWA' => $siswaId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil ditambahkan ke kelas'
        ]);
    }
    public function remove_siswa_dari_kelas(Request $request)
    {
        $siswaId = $request->input('idSiswa');
        $kelasId = $request->input('idKelas');
        $hasAttendance = Siswa::where('ID_SISWA', $siswaId)
            ->whereHas('attendances.pertemuan.mataPelajaran.kelas', function ($query) use ($kelasId) {
                $query->where('ID_KELAS', $kelasId);
            })
            ->get();
        $hasSubmission = Siswa::where('ID_SISWA', $siswaId)
            ->whereHas('submissionTugas.tugas.mataPelajaran.kelas', function ($query) use ($kelasId) {
                $query->where('ID_KELAS', $kelasId);
            })
            ->get();
        if (!$hasAttendance->isEmpty() || !$hasSubmission->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa sudah memiliki absen/submitTugas'
            ]);
        } else {
            $enroll = DB::delete('DELETE FROM ENROLLMENT_KELAS WHERE ID_SISWA = ? AND ID_KELAS = ?', [$siswaId, $kelasId]);
            if ($enroll > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil remove Siswa dari Kelas'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $siswaId . " - " . $kelasId
                ], 404);
            }
        }
    }
    public function displayUploadSiswaKeKelas()
    {
        return view('admin_pages.upload_siswa_ke_kelas');
    }
    public function uploadSiswaKeKelas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        try {
            // Correct way to call the import() method:
            Excel::import(new InsertSiswaKeKelasExcel, $request->file('file')); // Using the Facade

            // Or, using dependency injection (better approach):
            // $excel = app('excel');
            // $excel->import(new InsertSiswaExcel, $request->file('file'));

            Session::flash('success', 'Data imported successfully!'); // Use session
        } catch (\Exception $e) {
            Session::flash('error', 'Import failed: ' . $e->getMessage());
        }

        return redirect()->back();
    }
    public function tambahguru()
    {
        return view('admin_pages.tambahguru');
    }
    public function tambahpengumuman()
    {
        return view('admin_pages.tambahpengumuman');
    }
    public function tambahsiswa()
    {
        return view('admin_pages.tambahsiswa');
    }
    public function upload_kelas()
    {
        return view('admin_pages.upload_kelas');
    }
}
