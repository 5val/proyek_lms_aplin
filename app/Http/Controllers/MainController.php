<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function index()
    {
        session(['userActive' => (object) []]);
        return view('login');
    }
    public function handleLogin()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

        //   Login guru
        $guru = Guru::where([
            ['email_guru', $email],
            // matiin kalo mau hash
            // ['password_guru', $password]
        ])->first();
        if (
            $guru != null
            // nyalain kalo mau hash
            && Hash::check($password, $guru->PASSWORD_GURU)
        ) {
            if ($guru->STATUS_GURU != "Active") {
                return redirect()->route('login')->with('error', 'User Nonactive');
            }
            session(['userActive' => $guru]);
            return redirect('/guru');
        }

        // Login siswa
        $siswa = Siswa::where([
            ['email_siswa', $email],
            // matiin
            // ['password_siswa', $password]
        ])->first();

        if (
            $siswa != null
            // nyalain
            && Hash::check($password, $siswa->PASSWORD_SISWA)
        ) {
            if ($siswa->STATUS_SISWA != "Active") {
                return redirect()->route('login')->with('error', 'User Nonactive');
            }
            session(['userActive' => $siswa]);
            return redirect('/siswa');
        }

        if ($email == "admin" && $password == "admin") {
            session(['userActive' => (object) ["ID_ADMIN" => "admin"]]);
            return redirect('/admin');
        }
        return redirect()->route('login')->with('error', 'Username atau password salah');
    }

}
