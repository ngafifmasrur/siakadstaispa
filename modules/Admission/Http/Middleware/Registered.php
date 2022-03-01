<?php

namespace Modules\Admission\Http\Middleware;

use Closure;
use Modules\Admission\Models\Admission;

class Registered
{
    /**
    * Handle an incoming request.
    */
    public function handle($request, Closure $next)
    {
        if (!Admission::opened()->currentUser()->count()) {
            return redirect()->route('admission.index')
                             ->with(['danger' => 'Maaf, Anda belum terdaftar!']);
        }

        return $next($request);
    }
}