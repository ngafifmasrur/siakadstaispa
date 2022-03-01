<?php

namespace Modules\Admission\Http\Controllers\Form;

use App\Models\UserFather;
use App\Models\UserMother;
use App\Models\UserFoster;
use App\Models\UserAddress;
use Modules\Admission\Http\Requests\Form\Parent\UpdateRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class ParentController extends Controller
{
	/**
     * Instance the main property.
     */    
    protected $repo;

    public $models = [
        'father' => UserFather::class,
        'mother' => UserMother::class,
        'foster' => UserFoster::class
    ];

    public $trans = [
        'father' => 'ayah',
        'mother' => 'ibu',
        'foster' => 'wali'
    ];

    private $type;

    /**
     * Create a new controller instance.
     */
    public function __construct(AdmissionRegistrantRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($type = false)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        $address = $registrant->user->address ?? new UserAddress();
        $parent = $registrant->user->{$type} ?? new $this->models[$type]();
        $trans = $this->trans[$type];

        return view('admission::form.parent.index', compact('registrant', 'address', 'trans', 'parent', 'type'));
    }

    /**
     * Update current data.
     */
    public function update(UpdateRequest $request, $type = false)
    {
        $this->authorize('registration', Admission::class);
        $this->validateParentType($type);
        
        $registrant = $this->repo->getCurrentUser();

        $data = [
            'nik'           => $request->input('nik'),
            'name'          => $request->input('name'),
            'pob'           => $request->input('pob'),
            'dob'           => date('Y-m-d', strtotime($request->input('dob'))),
            'is_dead'       => (bool) $request->input('is_dead'),
            'biological'    => (bool) $request->input('biological'),
            'salary_id'     => $request->input('salary'),
            'employment_id' => $request->input('employment'),
            'grade_id'      => $request->input('grade'),
            'address'       => $request->input('address'),
            'rt'            => $request->input('rt'),
            'rw'            => $request->input('rw'),
            'village'       => $request->input('village'),
            'district_id'   => $request->input('district'),
            'postal'        => $request->input('postal')
        ];

        $data['__type'] = $type;

        if ($request->has('ktp')){
            $file = $request->file('ktp');
            \Storage::delete($registrant->user->{$type}->ktp);
            $data['ktp'] = $file->store('user_files/'.$registrant->user->id);
        }

        if ($registrant->user->{$type}()->updateOrCreate([], $data)) {
            return redirect($request->get('next', route('account.home')))
                        ->with(['success' => 'Sukses, informasi data '.$this->trans[$type].' telah berhasil diperbarui.']);
        }

        return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }

    /**
     * --------------------------------------------------
     * --------------------------------------------------
     * --------------------------------------------------
     */

    /**
     * Validate the parent type from form submission.
     */
    public function validateParentType($type)
    {
        if (!in_array($type, array_keys($this->models))) 
            return abort(404);
    }
}
