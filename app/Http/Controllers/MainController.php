<?php

namespace App\Http\Controllers;

use App\Models\Guru;
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

        if ($email == "admin" && $password == "admin") {
            return redirect('/admin');
        } else if ($email == "guru" && $password == "guru") {
            return redirect('/guru');
        } else if ($email == "siswa" && $password == "siswa") {
            return redirect('/siswa');
        }
        return view('login')->with('error', 'Username atau password salah');
    }
}
