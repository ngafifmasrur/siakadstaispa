<?php

namespace Modules\Admission\Http\Controllers\Admin\Report;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionPayment;
use Modules\Admission\Models\AdmissionRegistrant;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class RegistrantController extends Controller
{
    /**
     * Display administration homepage.
     */
    public function index(Request $request)
    {
        $admissions = Admission::withCount(['registrants'])->with('period.instance')->get();

        return view('admission::admin.report.registrants.index', compact('admissions'));
    }

    /**
     * Export the registrants.
     */
    public function registrants(Request $request)
    {
        $filter = $request->get('filter');
        
        $registrants = AdmissionRegistrant::with(['user', 'files'])
                            ->where('admission_id', $request->input('aid'));
                            
        $registrants->where(function($registrant) use ($request) {
            if ($request->has('filter')) {
                foreach ($request->input('filter', []) as $filter) {
                    $registrant->whereNotNull($filter);
                };
            }
        });
        
        $registrants = $registrants->get();
        $files = Admission::find($request->input('aid'))->files;

        return view('admission::admin.report.registrants.export.registrants', compact('registrants', 'files'));
    }
}
