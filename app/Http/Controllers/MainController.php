<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
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
        $email = $request->input('email');
        $password = $request->input('password');

        // Allow legacy admin/admin login even though the username is not an email
        if ($email === 'admin' && $password === 'admin') {
            session(['userActive' => (object) ["ID_ADMIN" => "admin"]]);
            return redirect('/admin');
        }

        // Validate normal email/password logins
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);

        $email = $credentials['email'];
        $password = $credentials['password'];

        $guru = Guru::where('email_guru', $email)->first();
        if ($guru) {
            if (! str_starts_with($guru->PASSWORD_GURU, '$2y$')) {
                // Auto-upgrade legacy plaintext passwords to bcrypt on first successful login
                if ($guru->PASSWORD_GURU === $password) {
                    $guru->PASSWORD_GURU = Hash::make($password);
                    $guru->save();
                } else {
                    return redirect()->route('login')->with('error', 'Silakan reset password Anda.');
                }
            }
            if (Hash::check($password, $guru->PASSWORD_GURU)) {
                if ($guru->STATUS_GURU !== 'Active') {
                    return redirect()->route('login')->with('error', 'User Nonactive');
                }
                session(['userActive' => $guru]);
                return redirect('/guru');
            }
        }

        // Orang tua login memakai email orang tua yang terkait siswa
        $parent = Siswa::where('EMAIL_ORANGTUA', $email)->first();
        if ($parent) {
            $parentPass = $parent->PASSWORD_ORANGTUA;
            if ($parentPass) {
                if (! str_starts_with($parentPass, '$2y$')) {
                    // Auto-upgrade legacy plaintext passwords to bcrypt on first successful login
                    if ($parentPass === $password) {
                        $parent->PASSWORD_ORANGTUA = Hash::make($password);
                        $parent->save();
                        $parentPass = $parent->PASSWORD_ORANGTUA;
                    } else {
                        return redirect()->route('login')->with('error', 'Silakan reset password Anda.');
                    }
                }
                if (Hash::check($password, $parentPass)) {
                    if ($parent->STATUS_SISWA !== 'Active') {
                        return redirect()->route('login')->with('error', 'Akun siswa tidak aktif');
                    }
                    // Tandai role agar halaman tahu ini akses orang tua
                    $payload = (object) array_merge($parent->toArray(), ['ROLE' => 'Parent']);
                    session(['userActive' => $payload]);
                    return redirect('/orangtua');
                }
            }
        }

        $siswa = Siswa::where('email_siswa', $email)->first();
        if ($siswa) {
            if (! str_starts_with($siswa->PASSWORD_SISWA, '$2y$')) {
                // Auto-upgrade legacy plaintext passwords to bcrypt on first successful login
                if ($siswa->PASSWORD_SISWA === $password) {
                    $siswa->PASSWORD_SISWA = Hash::make($password);
                    $siswa->save();
                } else {
                    return redirect()->route('login')->with('error', 'Silakan reset password Anda.');
                }
            }
            if (Hash::check($password, $siswa->PASSWORD_SISWA)) {
                if ($siswa->STATUS_SISWA !== 'Active') {
                    return redirect()->route('login')->with('error', 'Akun Anda tidak aktif');
                }
                session(['userActive' => $siswa]);
                return redirect('/siswa');
            }
        }

        $admin = User::where('email', $email)->first();
        if ($admin) {
            if (! str_starts_with($admin->password, '$2y$')) {
                // Auto-upgrade legacy plaintext admin passwords
                if ($admin->password === $password) {
                    $admin->password = Hash::make($password);
                    $admin->save();
                } else {
                    return redirect()->route('login')->with('error', 'Silakan reset password Anda.');
                }
            }
            if (Hash::check($password, $admin->password)) {
                session(['userActive' => (object) [
                    'ID_ADMIN' => $admin->id,
                    'NAME' => $admin->name,
                    'EMAIL' => $admin->email,
                ]]);
                return redirect('/admin');
            }
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

        // Reset untuk siswa atau orang tua (EMAIL_SISWA atau EMAIL_ORANGTUA)
        $siswa = Siswa::where('email_siswa', $email)->orWhere('email_orangtua', $email)->first();

        if ($siswa) {
            $plainPassword = Str::random(10);

            $isParent = strtolower($email) === strtolower($siswa->EMAIL_ORANGTUA);
            if ($isParent) {
                $siswa->PASSWORD_ORANGTUA = Hash::make($plainPassword);
            } else {
                $siswa->PASSWORD_SISWA = Hash::make($plainPassword);
            }
            $siswa->save();

            $label = $isParent ? 'orang tua' : 'siswa';
            Mail::raw(
                "Password baru akun {$label}: {$plainPassword}\nSilakan login lalu ganti password di menu Profil.",
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
