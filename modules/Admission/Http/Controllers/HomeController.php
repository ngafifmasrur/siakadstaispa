<?php

namespace Modules\Admission\Http\Controllers;

use Modules\Admission\Models\AdmissionRegistrant;
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

    	return view('admission::home.index', compact('registrant'));
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
