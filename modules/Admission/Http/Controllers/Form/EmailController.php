<?php

namespace Modules\Admission\Http\Controllers\Form;

use App\Models\UserEmail;
use Modules\Admission\Http\Requests\Form\Email\UpdateRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class EmailController extends Controller
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

        return view('admission::form.email.index', compact('registrant'));
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
            'address'        => $request->input('email'),
            'verified_at'    => null
        ];

        $registrant->user->email()->updateOrCreate([], $data);
        
        // if($data['address'] != $registrant->user->email->address) {
        //     if($registrant->user->email()->updateOrCreate([], $data)) {

        //         $email = UserEmail::where('user_id', $registrant->user->id)->firstOrFail();

        //         return redirect()->route('account.user.email.reverify', ['uid' => encrypt($email->id), 'next' => $request->get('next', route('admission.home'))]);
        //     }

        //     return redirect()->back()
        //                      ->withInput()
        //                      ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
        // }

        return redirect($request->get('next', route('account.home')))
        ->with(['success' => 'Alamat email berhasil disimpan.']);
    }
}
