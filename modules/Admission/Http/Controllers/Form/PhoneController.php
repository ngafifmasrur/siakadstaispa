<?php

namespace Modules\Admission\Http\Controllers\Form;

use App\Models\UserPhone;
use Modules\Admission\Http\Requests\Form\Phone\UpdateRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class PhoneController extends Controller
{
	/**
     * Instance the main property.
     */    
    protected $repo;

    /**
     * Create a new controller instance.
     */
    public function __construct(AdmissionRegistrantRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display view.
     */
    public function index()
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        return view('admission::form.phone.index', compact('registrant'));
    }

    /**
     * Update current data.
     */
    public function update(UpdateRequest $request)
    {
        $this->authorize('registration', Admission::class);
        
        $registrant = $this->repo->getCurrentUser();
        $form = $request->validated();

        $data = [
            'number'        => $request->input('number'),
            'whatsapp'      => (bool) $request->input('whatsapp')
        ];

        if ($registrant->user->phone()->updateOrCreate([], $data)) {

            return redirect($request->get('next', route('admission.home')))
                        ->with(['success' => 'Sukses, nomor HP telah berhasil diperbarui.']);

        }

        return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }
}
