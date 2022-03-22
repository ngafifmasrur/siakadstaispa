<?php

namespace Modules\Admission\Http\Controllers\Admin\Database\Manage;

use App\Models\User;
use App\Models\UserAddress;
use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Requests\RegisterRequest;

use Modules\Admission\Http\Controllers\Form\ParentController;
use Modules\Admission\Http\Requests\Admin\Database\Manage\Registrant\StoreRequest;
use Modules\Admission\Http\Requests\Admin\Database\Manage\Registrant\UpdateRequest;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class RegistrantController extends Controller
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

        $this->authorizeResource(AdmissionRegistrant::class, 'registrant', [
            'repass' => 'repass',
            'restore' => 'restore',
            'kill' => 'forceDelete',
        ]);
    }

    /**
     * Display administration homepage.
     */
    public function index(Request $request)
    {
    	$admission = $this->repo->admission = Admission::withCount(['registrants'])->with('period')->where('open', 1)->get();

        $registrants = $this->repo->setLimit(request('limit', $this->repo->limit))
                                  ->onlyTrashed(request('trash', false))
                                  ->search(request('search', ''));

        return view('admission::admin.database.manage.registrants.index', compact('admission', 'registrants'));
    }

    /**
     * Display registrant information.
     */
    public function show(AdmissionRegistrant $registrant)
    {
        $registrant = $this->repo->show($registrant);
        $status_cbt = (count($registrant->admission->cbts) == count($registrant->cbts->where('status', 2))) ? true : false;

        return view('admission::admin.database.manage.registrants.show', compact('registrant', 'status_cbt'));
    }

    /**
     * Register a new registrant.
     */
    public function create(Request $request)
    {
        $admissions = Admission::with('period')
                        ->opened()
                        ->whereIn('id', auth()->user()->admissionCommittees->pluck('admission_id'))
                        ->get();

        return view('admission::admin.database.manage.registrants.create', compact('admissions'));
    }

    /**
     * Do the admission.
     */
    public function store(StoreRequest $request)
    {
        if ($admission = Admission::opened()->find($request->input('admission_id'))) {

            $user = new User([
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'created_by' => auth()->id()
            ]);
            $user->save();

            $user->profile()->create([
                'name' => $request->input('name'),
                'pob' => $request->input('pob'),
                'dob' => date('Y-m-d', strtotime($request->input('dob'))),
                'sex' => $request->input('sex'),
            ]);

            $registrant = new AdmissionRegistrant([
                'user_id' => $user->id,
                'admission_id' => $request->input('admission_id'),
                'kd' => date('ym-dHis')
            ]);
            $registrant->save();

            return redirect()->route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id])
                             ->with(['success' => 'Selamat datang '.$user->profile->full_name.', silahkan lengkapi data dibawah ini untuk melanjutkan.']);
        }

        return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Maaf, jalur pendaftaran tidak dibuka.']);
    }

    /**
     * Edit the specified resource from storage.
     */
    public function edit(AdmissionRegistrant $registrant, Request $request)
    {
        $registrant = $this->repo->show($registrant);

        $key = $request->get('key');

        switch ($key) {
            case 'profile':
            case 'email':
            case 'phone':
            case 'address':
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'key'));

            case 'parent':
                $type = $request->get('type');
                $ctrl = new ParentController($this->repo);
                
                $address = $registrant->user->address ?? new UserAddress();
                $trans = $ctrl->trans[$type];
                $parent = $registrant->user->{$type} ?? new $ctrl->models[$type]();

                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'key', 'parent', 'trans', 'type', 'address'));
            
            case 'studies.index':
                $studies = $registrant->user->studies()->with(['grade', 'district.regency.province'])->orderBy('grade_id')->get();
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'studies'));

            case 'studies.create':
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant'));

            case 'studies.edit':
                $study = $registrant->user->studies()->findOrFail($request->get('study_id'));
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'study'));

            case 'organizations.index':
                $organizations = $registrant->user->organizations()->with(['type', 'position'])->get();
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'organizations'));

            case 'organizations.create':
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant'));

            case 'achievements.index':
                $achievements = $registrant->user->achievements()->with(['type', 'num'])->get();
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'achievements'));

            case 'achievements.create':
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant'));

            case 'file':
                $files = $registrant->admission->files->load([
                    'registrants' => function($query) use ($registrant) { 
                        $query->where('registrant_id', $registrant->id); 
                    }
                ]);
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'files', 'key'));

            case 'test':
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'key'));
            
            case 'major':
                $majors = AdmissionRegistrant::$major_long;
                return view('admission::admin.database.manage.registrants.edit.'.$key, compact('registrant', 'key', 'majors'));

            default:
                return abort(404);
        }
    }

    /**
     * Update the specified resource from storage.
     */
    public function update(AdmissionRegistrant $registrant, UpdateRequest $request)
    {
        $key = $request->get('key');
        $data = $this->transformRequest($request, $key);

        switch ($key) {
            case 'profile':
            case 'email':
            case 'phone':
            case 'address':
            case 'parent':
                if($key == 'profile') {
                    if ($request->has('avatar')){
                        $file = $request->file('avatar');
                        \Storage::delete($registrant->avatar);
                        $path =  $file->store('user_files/'.$registrant->user->id.'/admissions');
                    }
                    
                    $registrant->update([
                        'avatar' => $path ?? $registrant->avatar ?? null,
                    ]);
                }

                if($key == 'parent') {
                    $parent = new ParentController($this->repo);
                    $key = $data['data']['__type'];
                    $data['name'] = 'data '.$parent->trans[$key];

                    if ($request->has('ktp')){
                        $file = $request->file('ktp');
                        \Storage::delete($registrant->user->{$key}->ktp);
                        $data['data']['ktp'] =  $file->store('user_files/'.$registrant->user->id);
                    }
                }

                if($user = $registrant->user->{$key}()->updateOrCreate(['user_id' => $registrant->user->id], $data['data'])) {
                    return redirect($request->get('next', route('admission.admin.database.manage.registrants.show', ['registrant' => $registrant->id])))
                                ->with(['success' => 'Sukses, '.$data['name'].' berhasil diperbarui.']);
                }

            case 'studies.store':
                $registrant->user->studies()->create($data['data']);

                return redirect($request->get('next'))
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil ditambahkan.']);

            case 'studies.update':
                $registrant->user->studies()->find($request->get('study_id'))->update($data['data']);

                return redirect($request->get('next'))
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil diperbarui.']);

            case 'studies.delete':
                $registrant->user->studies()->find($request->get('study_id'))->delete();

                return redirect()->back()
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil dihapus.']);

            case 'organizations.store':
                if ($request->has('file')){
                    $file = $request->file('file');
                    $data['data']['file'] = $file->store('user_files/'.$registrant->user->id);
                }

                $registrant->user->organizations()->create($data['data']);

                return redirect($request->get('next'))
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil ditambahkan.']);

            case 'organizations.delete':
                $organization = $registrant->user->organizations()->find($request->get('organization_id'));

                \Storage::delete($organization->file);
                $organization->delete();

                return redirect()->back()
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil dihapus.']);

            case 'achievements.store':
                if ($request->has('file')){
                    $file = $request->file('file');
                    $data['data']['file'] = $file->store('user_files/'.$registrant->user->id);
                }

                $registrant->user->achievements()->create($data['data']);

                return redirect($request->get('next'))
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil ditambahkan.']);

            case 'achievements.delete':
                $achievement = $registrant->user->achievements()->find($request->get('achievement_id'));

                \Storage::delete($achievement->file);
                $achievement->delete();

                return redirect()->back()
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil dihapus.']);

            case 'file':
                $file = $request->file('file');
                $path = $file->store('user_files/'.$registrant->user_id.'/admissions');
                $type = $request->get('type');

                if($file = $registrant->files->where('pivot.file_id', $type)->first()) {

                    \Storage::delete($file->pivot->file);

                }
                
                $registrant->files()->syncWithoutDetaching([$type => ['file' => $path]]);

                return response()->json('Sukses, berkas berhasil diunggah!', 200);

            case 'test':
                if ($registrant->update($data['data'])) {
                    return redirect($request->get('next'))
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil diperbarui.']);
                }

            case 'major':
                if ($registrant->update($data['data'])) {
                    return redirect($request->get('next'))
                            ->with(['success' => 'Sukses, '.$data['name'].' telah berhasil diperbarui.']);
                }

            default:
                return abort(404);
        }

        return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);

    }

    /**
     * Restoring the specified resource from storage.
     */
    public function specialize(AdmissionRegistrant $registrant)
    {
        $registrant->update([
            'special' => !$registrant->special
        ]);

        return redirect()->back()
                    ->with(['success' => 'Sukses, calon mahasiswa baru atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah '.($registrant->special ? 'ditetapkan sebagai' : 'dihapus dari').' mahasiswa rekomendasi']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdmissionRegistrant $registrant)
    {
        if($tmp = $this->repo->delete($registrant)) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, calon mahasiswa baru atas nama <strong>'.$tmp->user->profile->full_name.'</strong> telah berhasil dihapus.']);
        }
    }

    /**
     * Restoring the specified resource from storage.
     */
    public function restore(AdmissionRegistrant $registrant)
    {
        if($this->repo->restore($registrant)) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, calon mahasiswa baru atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil dipulihkan.']);
        }
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(AdmissionRegistrant $registrant)
    {
        if($tmp = $this->repo->kill($registrant)) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, calon mahasiswa baru atas nama <strong>'.$tmp->user->profile->full_name.'</strong> telah berhasil dihapus secara permanen dari sistem.']);
        }
    }

    /**
     * Reset registrant password.
     */
    public function repass(AdmissionRegistrant $registrant)
    {
        $password = substr(str_shuffle('ABCDEF123456789'), 0, 6);

        $registrant->user->update([
            'password'  => bcrypt($password)
        ]);

        return redirect()->back()
                    ->with(['success' => 'Sukses, password calon mahasiswa baru atas nama <strong>'.$registrant->user->profile->full_name.' ('.$registrant->user->username.')</strong> telah berhasil diperbarui menjadi <b>'.$password.'</b>.']);
    }

    /**
     * --------------------------------------------------
     * --------------------------------------------------
     * --------------------------------------------------
     */

    /**
     * Transform request.
     */
    public function transformRequest(Request $request, $key)
    {
        switch ($key) {
            case 'profile':
                return [
                    'name' => 'data diri',
                    'data' => [
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
                        'child_order' => $request->input('child_order'),
                        'siblings' => $request->input('siblings'),
                        'biological' => (bool) $request->input('biological'),
                        'illness' => $request->input('illness'),
                        'nisn' => $request->input('nisn'),
                    ]
                ];
            case 'email':
                return [
                    'name' => 'alamat e-mail',
                    'data' => [
                        'address'        => $request->input('email'),
                        // 'verified_at'    => $request->input('verified_at') ?? null
                    ]
                ];
            case 'phone': 
                return [
                    'name' => 'nomor HP',
                    'data' => [
                        'number'        => $request->input('number'),
                        'whatsapp'      => (bool) $request->input('whatsapp')
                    ]
                ];
            case 'address':
                return [
                    'name' => 'alamat asal',
                    'data' => [
                        'address'       => $request->input('address'),
                        'rt'            => $request->input('rt'),
                        'rw'            => $request->input('rw'),
                        'village'       => $request->input('village'),
                        'district_id'   => $request->input('district'),
                        'postal'        => $request->input('postal')
                    ]
                ];
            case 'parent':
                return [
                    'name' => 'data parent',
                    'data' => [
                        'nik'           => $request->input('nik'),
                        'name'          => $request->input('name'),
                        'pob'           => $request->input('pob'),
                        'dob'           => date('Y-m-d', strtotime($request->input('dob'))),
                        'is_dead'       => (bool) $request->input('is_dead'),
                        'salary_id'     => $request->input('salary'),
                        'employment_id' => $request->input('employment'),
                        'grade_id'      => $request->input('grade'),
                        'address'       => $request->input('address'),
                        'rt'            => $request->input('rt'),
                        'rw'            => $request->input('rw'),
                        'village'       => $request->input('village'),
                        'district_id'   => $request->input('district'),
                        'postal'        => $request->input('postal'),
                        'biological'    => $request->input('biological'),
                        '__type'        => $request->input('type')
                    ]
                ];
            case 'studies.store':
            case 'studies.update':
                return [
                    'name' => 'riwayat pendidikan',
                    'data' => [
                        'grade_id'      => $request->input('grade'),
                        'name'          => $request->input('name'),
                        'npsn'          => $request->input('npsn'),
                        'nss'           => $request->input('nss'),
                        'from'          => $request->input('from'),
                        'to'            => $request->input('to'),
                        'district_id'   => $request->input('district')
                    ]
                ];
            case 'studies.delete':
                return [
                    'name' => 'riwayat pendidikan',
                    'data' => []
                ];
            case 'organizations.store':
                return [
                    'name' => 'riwayat organisasi',
                    'data' => [
                        'name'              => $request->input('name'),
                        'type_id'           => $request->input('type'),
                        'year'              => $request->input('year'),
                        'duration'          => $request->input('duration'),
                        'position_id'       => $request->input('position'),
                        'file'              => $request->input('file') ?? null,
                        'description'       => $request->input('description') ?? null,
                    ]
                ];
            case 'organizations.delete':
                return [
                    'name' => 'riwayat organisasi',
                    'data' => []
                ];
            case 'achievements.store':
                return [
                    'name' => 'data prestasi',
                    'data' => [
                        'name'              => $request->input('name'),
                        'territory_id'      => $request->input('territory'),
                        'type_id'           => $request->input('type'),
                        'num_id'            => $request->input('num'),
                        'year'              => $request->input('year'),
                        'file'              => $request->input('file') ?? null,
                        'description'       => $request->input('description') ?? null,
                    ]
                ];
            case 'achievements.delete':
                return [
                    'name' => 'data prestasi',
                    'data' => []
                ];
            case 'file':
                return [
                    'name' => 'berkas pendaftaran',
                    'data' => []
                ];
            case 'test':
                return [
                    'name' => 'pemilihan tanggal tes',
                    'data' => [
                        'test_at' => date('Y-m-d', strtotime($request->input('test_at'))),
                        'session_id' => $request->input('session')
                    ]
                ];
            case 'major':
                return [
                    'name' => 'pemilihan program studi',
                    'data' => [
                        'major1' => $request->input('major1'),
                        'major2' => $request->input('major2')
                    ]
                ];
            default:
                return abort(404);
                break;
        }
    }
}
