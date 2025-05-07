<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function handleLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        if ($username == "admin" && $password == "admin") {
            return redirect('/admin');
        } else if ($username == "guru" && $password == "guru") {
            return redirect('/guru');
        } else if ($username == "siswa" && $password == "siswa") {
            return redirect('/siswa');
        }
        return view('login')->with('error', 'Username atau password salah');
    }
}
