<?php

namespace Modules\Admission\Http\Controllers\Form;

use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Models\AdmissionKedatangan;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class TanggalKedatanganController extends Controller
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
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();
        $tanggal_kedatangan = AdmissionKedatangan::where('admission_id', $registrant->admission_id)->pluck('date', 'id');

        return view('admission::form.tanggal_kedatangan.index', compact('registrant', 'tanggal_kedatangan'));
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

        $tanggal = date('Y-m-d', strtotime('2022-03-15'));

        $this->repo->update([
            'tanggal_kedatangan' => $tanggal
        ], $registrant);

        return redirect()->back()->with(['success' => 'Sukses, berhasil menyimpan data tanggal kedatangan.']);;
    }
}
