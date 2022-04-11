<?php

namespace Modules\Admission\Http\Controllers\Admin\Registration;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionKedatangan;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Requests\Admin\Registration\Test\UpdateRequest;
use Modules\Admission\Http\Requests\Admin\Registration\Test\AssignRequest;

use Illuminate\Http\Request;
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
    public function index($registrant)
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();
        $tanggal_kedatangan = AdmissionKedatangan::where('admission_id', $registrant->admission_id)->pluck('date', 'id');

        return view('admission::admin.registration.tanggal_kedatangan.index', compact('registrant', 'tanggal_kedatangan'));
    }

    /**
     * Update current data.
     */
    public function update(Request $request)
    {
        $this->authorize('registration', Admission::class);
        
        $registrant = $this->repo->getCurrentUser();
        $validated = $request->validate([
            'tanggal_kedatangan' => 'required',
        ]);

        $tanggal = date('Y-m-d', strtotime($request->tanggal_kedatangan));

        $this->repo->update([
            'tanggal_kedatangan' => $tanggal
        ], $registrant);

        return redirect()->back()->with(['success' => 'Sukses, berhasil menyimpan data tanggal kedatangan.']);;
    }
	}
