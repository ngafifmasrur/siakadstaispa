<?php

namespace Modules\Account\Http\Controllers\User;

use App\Models\User;
use App\Repositories\UserProfileRepository;
use Modules\Account\Http\Requests\User\UpdateProfileRequest;

use Illuminate\Http\Request;
use Modules\Account\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Instance the main property.
     */    
    protected $repo;

    /**
     * Create a new controller instance.
     */
    public function __construct(UserProfileRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('account::user.profile.index');
    }

    /**
     * Update data.
     */
    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();

        $data['dob'] = date('Y-m-d', strtotime($data['dob']));

        if ($this->repo->update($data, auth()->user())) {

            return redirect($request->get('next', route('account.home')))
                        ->with(['success' => 'Sukses, profil telah berhasil diperbarui.']);

        }

        return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }
}
