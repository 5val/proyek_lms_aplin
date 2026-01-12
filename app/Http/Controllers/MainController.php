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

        $guru = Guru::where('email_guru', $email)->first();

        if ($guru) {
            $isAuthenticated = false;
            $dbPassword = $guru->PASSWORD_GURU;

            // 1. Cek apakah password di DB adalah Bcrypt Hash yang valid
            // Hash Bcrypt selalu dimulai dengan '$2y$' (atau '$2a$' / '$2x$')
            if (str_starts_with($dbPassword, '$2y$')) {
                // Jika formatnya hash, gunakan Hash::check
                if (Hash::check($password, $dbPassword)) {
                    $isAuthenticated = true;
                }
            } else {
                // 2. Jika bukan format hash (berarti masih plain text dari seeder)
                if ($dbPassword === $password) {
                    // Login berhasil, lalu otomatis ubah ke hash agar aman
                    $guru->PASSWORD_GURU = Hash::make($password);
                    $guru->save();
                    
                    $isAuthenticated = true;
                }
            }

            // 3. Eksekusi Login
            if ($isAuthenticated) {
                if ($guru->STATUS_GURU != "Active") {
                    return redirect()->route('login')->with('error', 'User Nonactive');
                }

                session(['userActive' => $guru]);
                return redirect('/guru');
            }
        }


        //   Login guru
        // $guru = Guru::where([
        //     ['email_guru', $email],
        //     // matiin kalo mau hash
        //     ['password_guru', $password]
        // ])->first();
        // if (
        //     $guru != null
        //     // nyalain kalo mau hash
        //     // && Hash::check($password, $guru->PASSWORD_GURU)
        // ) {
        //     if ($guru->STATUS_GURU != "Active") {
        //         return redirect()->route('login')->with('error', 'User Nonactive');
        //     }
        //     session(['userActive' => $guru]);
        //     return redirect('/guru');
        // }

        // Login siswa
        // $siswa = Siswa::where([
        //     ['email_siswa', $email],
        //     // matiin
        //     ['password_siswa', $password]
        // ])->first();

        // if (
        //     $siswa != null
        //     // nyalain
        //     // && Hash::check($password, $siswa->PASSWORD_SISWA)
        // ) {
        //     if ($siswa->STATUS_SISWA != "Active") {
        //         return redirect()->route('login')->with('error', 'User Nonactive');
        //     }
        //     session(['userActive' => $siswa]);
        //     return redirect('/siswa');
        // } else {
        //     $siswa = Siswa::where([
        //     ['email_siswa', $email]
        //     ])->first();
        //     if ($siswa != null && Hash::check($password, $siswa->PASSWORD_SISWA)) {
        //         if ($siswa->STATUS_SISWA != "Active") {
        //             return redirect()->route('login')->with('error', 'User Nonactive');
        //         }
        //         session(['userActive' => $siswa]);
        //         return redirect('/siswa');
        //     }
        // }
        // 1. Cari siswa hanya berdasarkan email.
        $siswa = Siswa::where('email_siswa', $email)->first();

        // 2. Jika siswa dengan email tersebut ada, lanjutkan pengecekan.
        if ($siswa) {
            $password_is_valid = false;
            $stored_password = $siswa->PASSWORD_SISWA;
            $input_password = $password;

            // --- LOGIKA UTAMA: DETEKSI FORMAT PASSWORD ---

            // A. Cek apakah ini HASH BCRYPT (standar Laravel)?
            // Hash Bcrypt selalu diawali dengan '$2y$' dan panjangnya 60 karakter.
            if (str_starts_with($stored_password, '$2y$')) {
                if (Hash::check($input_password, $stored_password)) {
                    $password_is_valid = true;
                }
            }
            // B. Cek apakah ini HASH MD5? (Contoh algoritma lama)
            // Hash MD5 panjangnya selalu 32 karakter hexadecimal.
            elseif (strlen($stored_password) === 32 && ctype_xdigit($stored_password)) {
                if (md5($input_password) === $stored_password) {
                    $password_is_valid = true;
                }
            }
            // C. Jika bukan format di atas, anggap ini PLAIN TEXT.
            else {
                if ($input_password === $stored_password) {
                    $password_is_valid = true;
                }
            }

            // --- AKHIR LOGIKA DETEKSI ---


            // 3. Jika dari salah satu metode di atas password terbukti valid.
            if ($password_is_valid) {
                
                // SANGAT PENTING: Jika password belum Bcrypt, update sekarang juga!
                // Ini akan mengamankan akun siswa secara otomatis saat mereka login.
                if (!str_starts_with($stored_password, '$2y$')) {
                    $siswa->PASSWORD_SISWA = Hash::make($input_password);
                    $siswa->save();
                }

                // 4. Cek status aktif siswa.
                if ($siswa->STATUS_SISWA != "Active") {
                    return redirect()->route('login')->with('error', 'Akun Anda tidak aktif');
                }

                // 5. Login berhasil, buat session.
                session(['userActive' => $siswa]);
                return redirect('/siswa');
            }
        }

        if ($email == "admin" && $password == "admin") {
            session(['userActive' => (object) ["ID_ADMIN" => "admin"]]);
            return redirect('/admin');
        }
        return redirect()->route('login')->with('error', 'Username atau password salah');
    }

}
