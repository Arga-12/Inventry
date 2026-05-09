<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {   
        //Middleware apakah user sudah login / memiliki session
        if (!Auth::check()) {
            return redirect('/login');
        }

        //Middleware kalau role user ingin mengakses laman role milik lain
        if (Auth::user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses untuk laman ini. Silahkan kembali!');
        }

        return $next($request);
    }
}
