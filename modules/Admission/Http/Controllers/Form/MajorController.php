<?php

namespace Modules\Admission\Http\Controllers\Form;

use Modules\Admission\Http\Requests\Form\Major\UpdateRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Models\AdmissionRegistrant;

use Modules\Admission\Http\Controllers\Controller;

class MajorController extends Controller
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
        
        $majors = AdmissionRegistrant::$major_long;

        return view('admission::form.major.index', compact('registrant', 'majors'));
    }

    /**
     * Update current data.
     */
    public function update(UpdateRequest $request)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        $data = [
            'major1' => $request->input('major1'),
            'major2' => $request->input('major2')
        ];

        if ($this->repo->update($data, $registrant)) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, program studi telah berhasil dipilih.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }
}
