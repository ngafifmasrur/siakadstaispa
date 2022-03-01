<?php

namespace Modules\Admission\Http\Controllers\Form;

use App\Models\UserAddress;
use App\Repositories\UserRepository;
use Modules\Admission\Http\Requests\Form\Address\UpdateRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class AddressController extends Controller
{
	/**
     * Instance the main property.
     */    
    protected $repo;
    protected $user;

    /**
     * Create a new controller instance.
     */
    public function __construct(AdmissionRegistrantRepository $repo, UserRepository $user)
    {
        $this->repo = $repo;
        $this->user = $user;
    }

    /**
     * Display view.
     */
    public function index()
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        return view('admission::form.address.index', compact('registrant'));
    }

    /**
     * Update current data.
     */
    public function update(UpdateRequest $request)
    {
        $this->authorize('registration', Admission::class);
        
        $registrant = $this->repo->getCurrentUser();

        $data = [
            'address'       => $request->input('address'),
            'rt'            => $request->input('rt'),
            'rw'            => $request->input('rw'),
            'village'       => $request->input('village'),
            'district_id'   => $request->input('district'),
            'postal'        => $request->input('postal')
        ];

        if ($registrant->user->address()->updateOrCreate([], $data)) {

            return redirect($request->get('next', route('admission.home')))
                        ->with(['success' => 'Sukses, data alamat telah berhasil diperbarui.']);
        }

        return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }
}
