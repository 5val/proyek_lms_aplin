<?php

namespace App\Http\Middleware;

use App\Models\Siswa;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (isset(session('userActive')->ID_SISWA)) {
            $isSiswa = Siswa::where('ID_SISWA', session('userActive')->ID_SISWA)->exists();
            if(!$isSiswa){
                abort(403);
            }
        } else{
            abort(403);
        }
        return $next($request);
    }
}
