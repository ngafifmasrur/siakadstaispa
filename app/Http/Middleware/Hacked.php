<?php

namespace App\Http\Middleware;

use Closure;
use View;
use Illuminate\Http\Request;

class Hacked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return response()->view('hacked');;
    }
}
