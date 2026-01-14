<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function index()
    {
        session(['userActive' => (object) []]);
        return view('login');
    }
    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);

        $email = $credentials['email'];
        $password = $credentials['password'];

        $guru = Guru::where('email_guru', $email)->first();
        if ($guru) {
            if (! str_starts_with($guru->PASSWORD_GURU, '$2y$')) {
                return redirect()->route('login')->with('error', 'Silakan reset password Anda.');
            }
            if (Hash::check($password, $guru->PASSWORD_GURU)) {
                if ($guru->STATUS_GURU !== 'Active') {
                    return redirect()->route('login')->with('error', 'User Nonactive');
                }
                session(['userActive' => $guru]);
                return redirect('/guru');
            }
        }

        $siswa = Siswa::where('email_siswa', $email)->first();
        if ($siswa) {
            if (! str_starts_with($siswa->PASSWORD_SISWA, '$2y$')) {
                return redirect()->route('login')->with('error', 'Silakan reset password Anda.');
            }
            if (Hash::check($password, $siswa->PASSWORD_SISWA)) {
                if ($siswa->STATUS_SISWA !== 'Active') {
                    return redirect()->route('login')->with('error', 'Akun Anda tidak aktif');
                }
                session(['userActive' => $siswa]);
                return redirect('/siswa');
            }
        }

        if ($email === 'admin' && $password === 'admin') {
            session(['userActive' => (object) ["ID_ADMIN" => "admin"]]);
            return redirect('/admin');
        }

        return redirect()->route('login')->with('error', 'Username atau password salah');
    }

    public function showResetForm()
    {
        return view('reset_password');
    }

    public function handleReset(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $data['email'];

        // Reset hanya untuk siswa
        $siswa = Siswa::where('email_siswa', $email)->first();

        if ($siswa) {
            $plainPassword = Str::random(10);
            $siswa->PASSWORD_SISWA = Hash::make($plainPassword);
            $siswa->save();

            Mail::raw(
                "Password baru Anda: {$plainPassword}\nSilakan login lalu ganti password di menu Profil.",
                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Reset Password LMS');
                }
            );
        }

        // Tetap balas sukses agar tidak bisa enumerasi akun
        return redirect()->route('login')->with('success', 'Jika email terdaftar, kami telah mengirimkan password baru.');
    }

}
