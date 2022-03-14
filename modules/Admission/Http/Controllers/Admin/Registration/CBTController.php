<?php

namespace Modules\Admission\Http\Controllers\Admin\Registration;
use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionCBT;
use Modules\Admission\Models\RegistrantCBT;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CBTController extends Controller
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
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $admissions = $this->repo->admission = auth()->user()->admissionCommittees->load('admission')->pluck('admission');

        $this->repo->admission = $admissions->when(!!$request->get('aid'), function ($query) use ($request) {
            return $query->where('id', $request->get('aid'));
        });

        $registrants = $this->repo->setWhere(function($query) {
                            $query->whereNotNull('verified_at');
                        })
                        ->setLimit(request('limit', $this->repo->limit))
                        ->search(request('search', ''));

        return view('admission::admin.registration.cbt.index', compact('admissions', 'registrants'));
    }

    /**
     * Show the registrant cbt.
     */
    public function show(AdmissionRegistrant $registrant)
    {
        $admission_cbt = AdmissionCBT::where('admission_cbt.admission_id', $registrant->admission_id)
        ->join('t_registrant_cbt', 't_registrant_cbt.cbt_id', 'admission_cbt.id')
        ->where('t_registrant_cbt.registrant_id', $registrant->id)
        ->select('admission_cbt.*', 't_registrant_cbt.status as status_registrant_cbt', 't_registrant_cbt.jumlah_jawaban_benar')
        ->get();

        return view('admission::admin.registration.cbt.show', compact('admission_cbt', 'registrant'));
    }
}
