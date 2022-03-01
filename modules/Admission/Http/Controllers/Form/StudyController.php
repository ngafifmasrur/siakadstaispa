<?php

namespace Modules\Admission\Http\Controllers\Form;

use App\Models\UserStudy;
use Modules\Admission\Http\Requests\Form\Studies\StoreRequest;
use Modules\Admission\Http\Requests\Form\Studies\UpdateRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class StudyController extends Controller
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

        $studies = $registrant->user->studies;

        return $studies->count()
            ? view('admission::form.studies.index', compact('registrant', 'studies'))
            : redirect()->route('admission.form.studies.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        return view('admission::form.studies.create', compact('registrant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        $data = [
            'grade_id'      => $request->input('grade'),
            'name'          => $request->input('name'),
            'npsn'          => $request->input('npsn'),
            'nss'           => $request->input('nss'),
            'from'          => $request->input('from'),
            'to'            => $request->input('to'),
            'district_id'   => $request->input('district'),
        ];

        if ($registrant->user->studies()->create($data)) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, data riwayat pendidikan telah berhasil ditambahkan.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserStudy $study)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();
        
        return view('admission::form.studies.edit', compact('registrant', 'study'));
    }

    /**
     * Update current data.
     */
    public function update(UserStudy $study, UpdateRequest $request)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        $data = [
            'grade_id'      => $request->input('grade'),
            'name'          => $request->input('name'),
            'npsn'          => $request->input('npsn'),
            'nss'           => $request->input('nss'),
            'from'          => $request->input('from'),
            'to'            => $request->input('to'),
            'district_id'   => $request->input('district'),
        ];

        if ($registrant->user->studies()->find($study->id)->update($data)) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, data riwayat pendidikan telah berhasil diperbarui.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserStudy $study)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        if ($registrant->user->studies()->find($study->id)->delete()) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, data riwayat pendidikan telah berhasil dihapus.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penghapusan.']);
                    
    }
}
