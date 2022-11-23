<?php

namespace Modules\Account\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Http\Requests\Auth\RegisterRequest;

use Modules\Account\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Instance the main property.
     */    
    protected $repo;

    /**
     * Create a new controller instance.
     */
    public function __construct(UserRepository $repo)
    {
        $this->middleware('guest');
        $this->repo = $repo;
    }

    /**
     * Show the application's login form.
     */
    public function showRegisterForm()
    {
        return view('account::auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        $data = [
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'name' => $request->input('name'),
            'nomor_hp' => $request->input('nomor_hp'),
        ];

        if ($user = $this->repo->store($data)) {

            Auth::login($user);

            return redirect()->intended($request->get('next'))
                             ->with(['success' => 'Selamat datang <strong>'.$data['name'].'</strong>, Anda berhasil membuat akun '.env('APP_NAME')]);
        }
        
        return redirect()->route('account.register', ['next' => $request->get('next')])
                         ->withInput($request->only(['name', 'username']))
                         ->with(['danger' => 'Terjadi kesalahan, silahkan ulangi kembali!']);
    }
}
