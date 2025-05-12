<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function handleLogin()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

      //   Login guru
        $guru = Guru::where([
         ['email_guru', '=', $email],
         ['password_guru', '=', $password]
        ])->first();
        if($guru != null) {
         session(['userActive' => $guru]);
         return redirect('/guru');
        }

        // Login siswa
        $siswa = Siswa::where([
            ['email_siswa', '=', $email],
            ['password_siswa', '=', $password]
        ])->first();

        if ($siswa != null) {
            session(['userActive' => $siswa]);
            return redirect('/siswa');
        }

        if ($email == "admin" && $password == "admin") {
            return redirect('/admin');
        }
        return view('login')->with('error', 'Username atau password salah');
    }
}
