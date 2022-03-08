<?php

namespace Modules\Account\Http\Controllers\User;

use App\Models\User;
use App\Models\UserPhone;
use App\Repositories\UserPhoneRepository;
use Modules\Account\Http\Requests\User\UpdatePhoneRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class PhoneController extends Controller
{
    /**
     * Instance the main property.
     */    
    protected $repo;

    /**
     * Create a new controller instance.
     */
    public function __construct(UserPhoneRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('account::user.phone.index');
    }

    /**
     * Update data.
     */
    public function update(UpdatePhoneRequest $request)
    {
        $data = [
            'number'        => $request->input('number'),
            'whatsapp'      => (bool) $request->input('whatsapp')
        ];

        if ($this->repo->update($data, auth()->user())) {

            return redirect($request->get('next', route('account.home')))
                        ->with(['success' => 'Sukses, nomor HP telah berhasil diperbarui.']);
        }

        return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }
}
