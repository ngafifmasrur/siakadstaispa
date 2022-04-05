<?php

namespace Modules\Admission\Http\Controllers\Form;

use Modules\Admission\Http\Requests\Form\Test\AssignRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Models\AdmissionRegistrant;

use Modules\Admission\Http\Controllers\Controller;

class TestController extends Controller
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
        return redirect()->route('admission.home')->with(['success' => 'Calon Mahasiswa tidak perlu mengisi tanggal tes.']);

        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();
        $enabledDates = $registrant->admission->testDates->pluck('date');

        if(auth()->user()->can('registration', Admission::class)) {
            $picked = AdmissionRegistrant::select(\DB::raw('test_at, COUNT(*) as total'))
                            ->whereNotNull('test_at')
                            ->groupBy('test_at')
                            ->get()
                            ->flatMap(function($v) use ($registrant) {
                                return [$v->test_at->format('Y-m-d') => $v->total - ($registrant->test_at == $v->test_at ? 1 : 0)];
                            });

            if($picked->count() > 0) {
                $enabledDates = $enabledDates->filter(function ($value) use ($picked) {
                                return (strtotime($value.' 10:00:00') >= time()) && (empty($picked[$value]) || $picked[$value] < config('admission.maximum-test-per-day'));
                            })->take(6)->flatten();
            }
        }

        return view('admission::form.test.index', compact('registrant', 'enabledDates'));
    }

    /**
     * Update current data.
     */
    public function update(AssignRequest $request)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        $data = [
            'test_at' => date('Y-m-d', strtotime($request->input('test_at'))),
            'session_id' => $request->input('session')
        ];

        if ($this->repo->update($data, $registrant)) {
            return redirect(request('next', route('admission.home')))
                        ->with(['success' => 'Sukses, pemilihan tanggal tes telah berhasil ditetapkan.']);
        }

        return redirect()->back()->withInput()
                        ->with(['danger' => 'Maaf, terjadi kegagalan ketika proses penyimpanan.']);
    }
}
