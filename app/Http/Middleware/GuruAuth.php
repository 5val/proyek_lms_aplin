<?php

namespace App\Http\Middleware;

use App\Models\Guru;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuruAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (isset(session('userActive')->ID_GURU)) {
            $isGuru = Guru::where('ID_GURU', session('userActive')->ID_GURU)->exists();
            if(!$isGuru){
                abort(403);
            }
        } else{
            abort(403);
        }
        return $next($request);
    }
}
