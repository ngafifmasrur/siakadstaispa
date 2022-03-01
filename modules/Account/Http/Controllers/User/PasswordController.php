<?php

namespace Modules\Account\Http\Controllers\User;

use App\Models\User;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Http\Requests\User\UpdatePasswordRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class PasswordController extends Controller
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
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('account::user.password');
    }

    /**
     * Update the user password.
     */
    public function update(UpdatePasswordRequest $request)
    {
        $data = [
            'password' => bcrypt($request->input('password'))
        ];

        $this->repo->update($data, auth()->user());

        return redirect($request->get('next', url()->previous()))
                    ->with(['success' => 'Sukses, sandi telah berhasil diperbarui.']);
    }
}
