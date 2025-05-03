<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/admin_home', function () {
   return view('admin_pages/home');
});
Route::get('/guru_home', function () {
   return view('guru_pages/home');
});
Route::get('/siswa_home', function () {
   return view('siswa_pages/home');
});
