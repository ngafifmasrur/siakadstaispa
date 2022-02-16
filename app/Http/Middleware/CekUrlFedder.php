<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\m_konfigurasi;

class CekUrlFedder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    { 
        $endpoint_fromdb = m_konfigurasi::where('variable','url_feeder_pd_dikti')->count();
        if(($endpoint_fromdb==0)){
            return redirect()->route('admin.konfigurasi.index');
        }else{
            return $next($request);
        }
        
    }
}
