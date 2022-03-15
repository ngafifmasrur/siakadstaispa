<?php

namespace Modules\Admission\Http\Controllers;

use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionCBT;
use Modules\Admission\Models\RegistrantCBT;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Controllers\Controller;

class HomeController extends Controller
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
     * Display home.
     */
    public function index()
    {
    	$this->authorize('registration', Admission::class);

    	$registrant = $this->repo->getCurrentUser();
        $admission_cbt = AdmissionCBT::where('admission_cbt.admission_id', $registrant->admission_id)->get();
        $admission_cbt->map(function ($item) use ($registrant){
            $item['status_registrant_cbt'] = RegistrantCBT::where('registrant_id', $registrant->id)
            ->where('cbt_id', $item->id)->first()->status ?? 0;

            return $item;
        });
        $status_cbt = (count($registrant->admission->cbts) == count($registrant->cbts->where('status', 2))) ? true : false;


    	return view('admission::home.index', compact('registrant', 'admission_cbt', 'status_cbt'));
    }

    /**
     * Export the admission form.
     */
    public function form(AdmissionRegistrant $registrant)
    {
        $this->authorize('view', $registrant);

        $pdf = \PDF::loadView('admission::home.form', compact('registrant'))
                    ->setPaper('a4', 'portrait');

        return $pdf->stream('FORMULIR-PENDAFTARAN-'.$registrant->kd.'.pdf');
    }
}
