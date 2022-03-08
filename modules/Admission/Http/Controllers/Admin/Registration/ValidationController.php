<?php

namespace Modules\Admission\Http\Controllers\Admin\Registration;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class ValidationController extends Controller
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

        // $this->authorizeResource(AdmissionRegistrant::class, 'registrant');
    }

    /**
     * Index.
     */
    public function index(Request $request)
    {
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

        return view('admission::admin.registration.validation.index', compact('admissions', 'registrants'));
    }

    /**
     * Verify registrant.
     */
    public function validateRegistrant(AdmissionRegistrant $registrant, Request $request)
    {
        $this->repo->update([
            'validated_at' => $request->input('status') ? now() : null
        ], $registrant);
        
        return redirect()->back()
                    ->with(['success' => 'Sukses, data pendaftar atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah dinyatakan '.($request->input('status') ? '' : 'tidak').' valid.']);
    }
}
