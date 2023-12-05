<?php

namespace Modules\Admission\Http\Controllers\Admin\Registration;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SamanController extends Controller
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

        $registrants = $this->repo->setLimit(request('limit', $this->repo->limit))
                                  ->onlyTrashed(request('trash', false))
                                  ->search(request('search', ''));

        return view('admission::admin.registration.saman.index', compact('admissions', 'registrants'));
    }

    /**
     * Verify registrant.
     */
    public function verify(AdmissionRegistrant $registrant)
    {
        $this->repo->update([
            'is_saman' => 1
        ], $registrant);

        return redirect()->back()
                    ->with(['success' => 'Sukses, pendaftar atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil diverifikasi menjadi saman.']);
    }

    /**
     * Cancel SAMAN registrant.
     */
    public function cancel(AdmissionRegistrant $registrant)
    {
        $this->repo->update([
            'is_saman' => 0
        ], $registrant);

        return redirect()->back()
                    ->with(['success' => 'Sukses, pendaftar atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil dibatalkan menjadi saman.']);
    }

    /**
     * Kelola Jadwal Wawancara
     */
    public function jadwal_wawancara(AdmissionRegistrant $registrant)
    {
        $admissions = $this->repo->admission = auth()->user()->admissionCommittees->load('admission')->pluck('admission');

        return view('admission::admin.registration.saman.jadwal', compact('admissions', 'registrant'));
    }

    /**
     * Set Jadwal Wawancara
     */
    public function set_jadwal_wawancara(AdmissionRegistrant $registrant, Request $request)
    {
        $validated = $request->validate([
            'tanggal_wawancara' => 'required|date',
            'jenis_wawancara'   => 'required|in:online,offline'
        ]);

        $this->repo->update([
            'jadwal_wawancara' => $request->tanggal_wawancara,
            'jenis_wawancara' => $request->jenis_wawancara
        ], $registrant);

        return redirect()->back()
                    ->with(['success' => 'Sukses, jawal wawancara <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil disimpan.']);
    }

    /**
     * Update Status Wawancara
     */
    public function status_wawancara(AdmissionRegistrant $registrant, Request $request)
    {
        $validated = $request->validate([
            'status_wawancara' => 'required|integer',
        ]);

        $this->repo->update([
            'status_wawancara' => $request->status_wawancara
        ], $registrant);

        return redirect()->back()
                    ->with(['success' => 'Sukses, status_wawancara <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil disimpan.']);
    }
}
