<?php

namespace Modules\Admission\Http\Controllers\Form;

use App\Models\UserOrganization;
use Modules\Admission\Http\Requests\Form\Organizations\StoreRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class OrganizationController extends Controller
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

        $organizations = $registrant->user->organizations;

        return $organizations->count()
            ? view('admission::form.organizations.index', compact('registrant', 'organizations'))
            : redirect()->route('admission.form.organizations.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        return view('admission::form.organizations.create', compact('registrant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        $data = [
            'name'              => $request->input('name'),
            'type_id'           => $request->input('type'),
            'year'              => $request->input('year'),
            'duration'          => $request->input('duration'),
            'position_id'       => $request->input('position'),
            'description'       => $request->input('description'),
        ];

        if ($request->has('file')){
            $file = $request->file('file');
            $data['file'] = $file->store('user_files/'.$registrant->user->id);
        }

        if ($registrant->user->organizations()->create($data)) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, data riwayat organisasi telah berhasil ditambahkan.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserOrganization $organization)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        \Storage::delete($organization->file);

        if ($registrant->user->organizations()->find($organization->id)->delete()) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, data riwayat organisasi telah berhasil dihapus.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penghapusan.']);
                    
    }
}
