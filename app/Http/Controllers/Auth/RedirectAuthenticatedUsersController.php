<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class RedirectAuthenticatedUsersController extends Controller
{
    public function home()
    {
        if(Auth::check()) {
            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            elseif(auth()->user()->hasRole('dosen')){
                return redirect()->route('dosen.dashboard');
            }
            elseif(auth()->user()->hasRole('mahasiswa')){
                return redirect()->route('mahasiswa.dashboard');
            }
            elseif(auth()->user()->hasRole('admin_prodi')){
                return redirect()->route('admin_prodi.dashboard');
            }
            else{
                return auth()->logout();
            }
        } else {
            return redirect('/home');
        }

    }
}
