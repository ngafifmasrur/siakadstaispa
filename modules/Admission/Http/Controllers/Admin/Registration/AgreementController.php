<?php

namespace Modules\Admission\Http\Controllers\Admin\Registration;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class AgreementController extends Controller
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
     * Index.
     */
    public function index(Request $request)
    {
        $this->authorize('giveAgreementRegistrant', AdmissionRegistrant::class);

        $admissions = $this->repo->admission = auth()->user()->admissionCommittees->load('admission')->pluck('admission');

        $this->repo->admission = $admissions->when(!!$request->get('aid'), function ($query) use ($request) {
            return $query->where('id', $request->get('aid'));
        });

        $registrants = $this->repo->setWhere(function($query) {
                                    $query->whereNotNull('verified_at');
                                    $query->whereNotNull('tested_at');
                                  })
                                  ->setLimit(request('limit', $this->repo->limit))
                                  ->onlyTrashed(request('trash', false))
                                  ->search(request('search', ''));

        return view('admission::admin.registration.agreement.index', compact('admissions', 'registrants'));
    }

    /**
     * Verify registrant.
     */
    public function printAgreement(AdmissionRegistrant $registrant, Request $request)
    {
        $this->authorize('giveAgreementRegistrant', $registrant);

        $registrant->load('user');
        
        if(!$registrant->agreement_at) {
            $registrant->update([
                    'agreement_at' => now()
                ]);
        }

        $pdf = \PDF::loadView('admission::admin.registration.agreement.pdf.form', compact('registrant'))
                    ->setPaper('a4', 'portrait');

        return $pdf->stream('PERJANJIAN-'.$registrant->kd.'.pdf');
    }

    /**
     * Verify registrant.
     */
    public function printAgreementAlumni(AdmissionRegistrant $registrant, Request $request)
    {
        $this->authorize('giveAgreementRegistrant', $registrant);

        $registrant->load('user');
        
        if(!$registrant->agreement_at) {
            $registrant->update([
                    'agreement_at' => now()
                ]);
        }

        $pdf = \PDF::loadView('admission::admin.registration.agreement.pdf.form-alumni', compact('registrant'))
                    ->setPaper('a4', 'portrait');

        return $pdf->stream('PERJANJIAN-ALUMNI-'.$registrant->kd.'.pdf');
    }
}
