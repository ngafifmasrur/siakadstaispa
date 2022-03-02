<?php

namespace Modules\Admission\Http\Controllers\Admin\Database\Manage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admission\Models\Admission;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

class PeriodeController extends Controller
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
        $admission = $this->repo->admission = Admission::with('period')->get();
        return view('admission::admin.database.manage.periode.index', compact('admission'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        abort(404);  
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

    public function edit(Admission $periode, Request $request)
    {
        return view('admission::admin.database.manage.periode.edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Admission $periode, Request $request)
    {
        $periode->update([
            'open' => $request->open,
            'published' => $request->published
        ]);
        
        return redirect($request->get('next', route('admission.admin.database.manage.rooms.index')))
                    ->with(['success' => 'Sukses, Status periode berhasil diubah']);
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        abort(404);
    }
}
