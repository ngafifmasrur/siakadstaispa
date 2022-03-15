<?php

namespace Modules\Admission\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admission\Models\AdmissionKedatangan;
use Modules\Admission\Models\Admission;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

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
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $admissions = $this->repo->admission = auth()->user()->admissionCommittees->load('admission')->pluck('admission');

        $this->repo->admission = $admissions->when(!!$request->get('aid'), function ($query) use ($request) {
            return $query->where('id', $request->get('aid'));
        });

        $data = AdmissionKedatangan::when($request->get('aid'), function($q) use ($request) {
            $q->where('admission_id', $request->get('aid'));
        })->get();

        return view('admission::admin.tanggal_kedatangan.index', compact('data', 'admissions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $admission = $this->repo->admission = Admission::with('period')->get();

        return view('admission::admin.tanggal_kedatangan.create', compact('admission'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        AdmissionKedatangan::create([
            'admission_id' => $request->admission_id,
            'date' => $request->date,
        ]);

        return redirect($request->get('next', route('admission.admin.tanggal_kedatangan.index')))
                    ->with(['success' => 'Sukses, data tanggal kedatangan berhasil ditambahkan']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(AdmissionKedatangan $tanggal_kedatangan)
    {
        $admission = $this->repo->admission = Admission::with('period')->get();

        return view('admission::admin.tanggal_kedatangan.edit', compact('cbt', 'admission'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, AdmissionKedatangan $tanggal_kedatangan)
    {
        $validated = $request->validate([
            'date' => 'required|date',
        ]);

        $tanggal_kedatangan->update([
            'admission_id' => $request->admission_id,
            'date' => $request->date,
        ]);

        return redirect($request->get('next', route('admission.admin.tanggal_kedatangan.index')))
                    ->with(['success' => 'Sukses, data tanggal kedatangan berhasil diedit']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(AdmissionKedatangan $tanggal_kedatangan)
    {

        if($tanggal_kedatangan->delete()) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, data tanggal kedatangan telah berhasil dihapus.']);
        }
    }
}
