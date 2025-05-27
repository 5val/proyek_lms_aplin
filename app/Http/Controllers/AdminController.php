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
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
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
        $listPengumuman = Pengumuman::orderByDesc('ID')->limit(10)->get();
        return view('admin_pages.home', compact('latestPeriode', 'jumlahSiswa', 'jumlahGuru', 'jumlahKelas', 'jumlahPelajaran', 'jumlahMataPelajaran', 'listPengumuman'));
    }
    // ========================================= Guru ===================================================
    public function geteditguru($id_guru)
    {
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
                // 'PASSWORD_GURU' => Hash::make($password),
                'PASSWORD_GURU' => $password,
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
        $pengumuman = Pengumuman::find($id);
        return view('admin_pages.editpengumuman', ["pengumuman" => $pengumuman]);
    }
    public function editpengumuman(Request $request, $id)
    {
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
        $pengumuman = Pengumuman::find($id_pengumuman);
        $pengumuman->delete();
        return redirect('/admin/listpengumuman');
    }
    // ========================================= Siswa =================================================
    public function geteditsiswa($id_siswa)
    {
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
        $siswa = DB::select("select * from siswa where id_siswa = ?", [$id_siswa]);
        if (count($siswa) > 0) {
            $id = $request->input("id");
            $nama = $request->input("nama");
            $email = $request->input("email");
            $alamat = $request->input("alamat");
            $telp = $request->input("telp");
            $status = $request->input("status");
            DB::update("update siswa set nama_siswa = ?, email_siswa = ?, alamat_siswa = ?, no_telpon_siswa = ?, status_siswa = ? where id_siswa = ?", [$nama, $email, $alamat, $telp, $status, $id]);
        }
        return redirect('/admin/listsiswa');
    }
    public function listsiswa()
    {
        $allsiswa = DB::select("select * from siswa");
        return view('admin_pages.listsiswa', ["allsiswa" => $allsiswa]);
    }
    public function hapussiswa($id_siswa)
    {
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
        $siswa = Siswa::where('EMAIL_SISWA', $email)->get();
        if (!$siswa->isEmpty()) {
            return view('admin_pages.tambahsiswa');
        } else {
            Siswa::create([
                'NAMA_SISWA' => $nama,
                'EMAIL_SISWA' => $email,
                // nyalain
                // 'PASSWORD_SISWA' => Hash::make($password),
                'PASSWORD_SISWA' => $password,
                'ALAMAT_SISWA' => $alamat,
                'NO_TELPON_SISWA' => $telp,
                'STATUS_SISWA' => $status,
            ]);
            return redirect('/admin/listsiswa');
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
        ], [
            'name.unique' => 'Nama Pelajaran sudah digunakan. Silakan pilih nama lain.'
        ]);
        Pelajaran::create([
            'NAMA_PELAJARAN' => $request->input('name'),
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

    // ========================================= Laporan ============================================
    public function laporanguru(Request $request)
    {
      if($request->query('periodeSelect')){
         $periode = Periode::where('ID_PERIODE', $request->query('periodeSelect'))->first();
      } else {
         $periode = Periode::orderBy('ID_PERIODE', 'desc')->first();
      }
      $all_periode = Periode::all();
      $all_guru = Guru::all();
      return view('admin_pages.laporanguru', ["all_guru" => $all_guru, "all_periode" => $all_periode, "periode" => $periode]);
    }
    public function hlm_report_guru(Request $request){
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
         if($report->rata2 !== null) {
            $rata2_all += $report->rata2;
         }
      }
      $rata2_all /= count($jumlahDinilai);

    return view('admin_pages.hlm_report_guru', ["guru" => $guru, "periode" => $periode, "list_report" => $list_report, "jumlahMapel" => $jumlahMapel, "jumlahDinilai" => $jumlahDinilai, "rata2_all" => $rata2_all]);
}
    public function laporankelas()
    {
        return view('admin_pages.laporankelas');
    }
    public function laporanmapel()
    {
        return view('admin_pages.laporanmapel');
    }
    public function laporansiswa()
    {
        return view('admin_pages.laporansiswa');
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
        $kelasList = $classes->map(function ($item) {
            return [
                'id_kelas' => $item->ID_KELAS ?? '-',
                'ruangan_kelas' => $item->detailKelas->RUANGAN_KELAS,
                'nama_kelas' => $item->detailKelas->NAMA_KELAS,
                'nama_wali' => $item->wali->NAMA_GURU,
            ];
        });

        return view('admin_pages.list_kelas', compact('kelasList', 'semesters', 'latestPeriode'));
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
                'ruangan_kelas' => $item->detailKelas->RUANGAN_KELAS,
                'nama_kelas' => $item->detailKelas->NAMA_KELAS,
                'nama_wali' => $item->wali->NAMA_GURU,
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

        // Update the class details
        $kelas->ID_DETAIL_KELAS = $request->input('ruangan');
        $kelas->ID_GURU = $request->input('wali_kelas');

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
        ]);

        // Create new class
        $kelas = Kelas::create([
            'ID_DETAIL_KELAS' => $validated['ruangan'],
            'ID_GURU' => $validated['wali_kelas'],
            'ID_PERIODE' => $currPeriode,
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
        $guruList = Guru::all();
        $pelajaranList = Pelajaran::all();
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
                ->where(function ($query) use ($time) {
                    $query->where('JAM_PELAJARAN', [$time]);
                })->exists();
            if ($teacherBusy) {
                $validator->errors()->add('pengajar', 'Guru sudah memiliki jadwal pada waktu tersebut.');
            }
            // Check class conflict
            $classBusy = MataPelajaran::whereHas('kelas', function ($query) use ($semester) {
                $query->where('ID_PERIODE', $semester);
            })
                ->where('ID_KELAS', $request->kelas)
                ->where('HARI_PELAJARAN', $day)
                ->where(function ($query) use ($time) {
                    $query->where('JAM_PELAJARAN', [$time]);
                })->exists();

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
                ->where('ID_MATA_PELAJARAN', '!=', $mataPelajaran->ID_MATA_PELAJARAN) // Kecualikan record saat ini
                ->where('JAM_PELAJARAN', $time) // Asumsikan JAM_PELAJARAN menyimpan nilai waktu tunggal
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
                ->where('ID_MATA_PELAJARAN', '!=', $mataPelajaran->ID_MATA_PELAJARAN) // Kecualikan record saat ini
                ->where('JAM_PELAJARAN', $time) // Asumsikan JAM_PELAJARAN menyimpan nilai waktu tunggal
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

        // Perbarui record MataPelajaran
        $mataPelajaran->delete();
        MataPelajaran::create([
            'ID_GURU' => $request->pengajar,
            'ID_KELAS' => $request->kelas,
            'ID_PELAJARAN' => $request->pelajaran,
            'HARI_PELAJARAN' => $request->hari,
            'JAM_PELAJARAN' => $request->waktu
        ]);

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


    // ================================== Tambah Siswa =================================================
    public function list_tambah_siswa_ke_kelas($id_kelas)
    {
        $currPeriode = Kelas::find($id_kelas)->ID_PERIODE;
        $kelasList = EnrollmentKelas::where('ID_KELAS', $id_kelas)->with('siswa')->get();
        $siswaList = Siswa::whereDoesntHave('kelass', function ($query) use ($currPeriode) {
            $query->where('ID_PERIODE', $currPeriode);
        })->where('STATUS_SISWA', 'Active')->get();
        // $siswaList = EnrollmentKelas::whereNotIn('ID_KELAS', [$id_kelas])->with(['siswa'])->get();
        return view('admin_pages.list_tambah_siswa_ke_kelas', compact('siswaList', 'kelasList', 'id_kelas'));
    }
    public function get_list_siswa_di_kelas($id_kelas)
    {
        $kelasList = EnrollmentKelas::where('ID_KELAS', $id_kelas)->with(['siswa'])->get();
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
