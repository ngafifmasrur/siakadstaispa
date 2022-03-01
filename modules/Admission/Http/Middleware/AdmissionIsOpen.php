<?php

namespace Modules\Admission\Http\Middleware;

use Closure;
use Modules\Admission\Models\Admission;

class AdmissionIsOpen
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (!($admission = Admission::opened()->count())) {
            return response()->view('admission::admin.closed');
        }

        return $next($request);
    }
}
