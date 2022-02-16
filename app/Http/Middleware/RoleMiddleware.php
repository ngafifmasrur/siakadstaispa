<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\m_konfigurasi;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check()){
            if (Auth::user()->hasRole($role)) {
                return $next($request);
            }
            abort(403);
        } else {
            return redirect('/login');
        }
    }
}
