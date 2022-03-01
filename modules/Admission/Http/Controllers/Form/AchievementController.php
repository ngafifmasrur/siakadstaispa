<?php

namespace Modules\Admission\Http\Controllers\Form;

use App\Models\UserAchievement;
use Modules\Admission\Http\Requests\Form\Achievements\StoreRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class AchievementController extends Controller
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

        $achievements = $registrant->user->achievements;

        return $achievements->count()
            ? view('admission::form.achievements.index', compact('registrant', 'achievements'))
            : redirect()->route('admission.form.achievements.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        return view('admission::form.achievements.create', compact('registrant'));
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
            'territory_id'         => $request->input('territory'),
            'type_id'              => $request->input('type'),
            'num_id'               => $request->input('num'),
            'year'              => $request->input('year'),
            'description'       => $request->input('description'),
        ];

        if ($request->has('file')){
            $file = $request->file('file');
            $data['file'] = $file->store('user_files/'.$registrant->user->id);
        }

        if ($registrant->user->achievements()->create($data)) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, data prestasi telah berhasil ditambahkan.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAchievement $achievement)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        \Storage::delete($achievement->file);

        if ($registrant->user->achievements()->find($achievement->id)->delete()) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, data prestasi telah berhasil dihapus.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penghapusan.']);
                    
    }
}
