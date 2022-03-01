<?php

namespace Modules\Admission\Http\Middleware;

use Closure;
use Modules\Admission\Models\Admission;

class IsAdmissionCommittee
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->admissionCommittees()->exists()) {
            return $next($request);
        }

        return abort(404);
    }
}
