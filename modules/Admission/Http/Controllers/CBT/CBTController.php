<?php

namespace Modules\Admission\Http\Controllers\CBT;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionCBT;
use Modules\Admission\Models\Question;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Requests\Admin\CBT\CBTRequest;
use Modules\Admission\Http\Requests\Admin\CBT\QuestionRequest;

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
    public function index()
    {
        $cbt = AdmissionCBT::with('admission')->get();
        
        return view('admission::admin.cbt.index', compact('cbt'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $admission = $this->repo->admission = Admission::with('period')->get();

        return view('admission::admin.cbt.create', compact('admission'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CBTRequest $request)
    {
        AdmissionCBT::create($request->all());

        return redirect($request->get('next', route('admission.admin.cbt.index')))
                    ->with(['success' => 'Sukses, data cbt berhasil ditambahkan']);
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
    public function edit(AdmissionCBT $cbt)
    {
        return view('admission::admin.cbt.edit', compact('cbt'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CBTRequest $request, AdmissionCBT $cbt)
    {
        $cbt->update($request->all());

        return redirect($request->get('next', route('admission.admin.cbt.index')))
                    ->with(['success' => 'Sukses, data cbt berhasil diedit']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(AdmissionCBT $cbt)
    {

        if($room->delete()) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, data cbt telah berhasil dihapus.']);
        }
    }
}
