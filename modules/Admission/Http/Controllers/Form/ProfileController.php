<?php

namespace Modules\Admission\Http\Controllers\Form;

use Modules\Admission\Http\Requests\Form\Profile\UpdateRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class ProfileController extends Controller
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

        return view('admission::form.profile.index', compact('registrant'));
    }

    /**
     * Update current data.
     */
    public function update(UpdateRequest $request)
    {
        $this->authorize('registration', Admission::class);
        
        $registrant = $this->repo->getCurrentUser();
        
        if($registrant->user->profile->sex != $request->input('sex')) {
        if(in_array($request->input('sex'), config('admission.closed'))) {
                return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Mohon maaf, terjadi kegagalan!']);
            }
        }

        if ($request->has('avatar')){
            $file = $request->file('avatar');
            \Storage::delete($registrant->avatar);
            $path = $file->store('user_files/'.$registrant->user->id.'/admissions');
        }

        $data = [
            'name' => $request->input('name'),
            'prefix' => $request->input('prefix'),
            'suffix' => $request->input('suffix'),
            'pob' => $request->input('pob'),
            'dob' => date('Y-m-d', strtotime($request->input('dob'))),
            'sex' => $request->input('sex'),
            'blood' => $request->input('blood'),
            'nik' => $request->input('nik'),
            'nokk' => $request->input('nokk'),
            'country_id' => $request->input('country'),
            'avatar' => $path ?? $registrant->avatar ?? null,
            'child_order' => $request->input('child_order'),
            'siblings' => $request->input('siblings'),
            'biological' => (bool) $request->input('biological'),
            'illness' => $request->input('illness'),
            'nisn' => $request->input('nisn'),
        ];
        
        $registrant->update([
            'avatar' => $path ?? $registrant->avatar ?? null
        ]);

        $registrant->user->profile()->update($data);

        return redirect($request->get('next', route('admission.home')))
                    ->with(['success' => 'Sukses, data diri berhasil diperbarui.']);
    }
}
