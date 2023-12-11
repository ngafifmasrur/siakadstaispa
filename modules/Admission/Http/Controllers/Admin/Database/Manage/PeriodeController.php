<?php

namespace Modules\Admission\Http\Controllers\Admin\Database\Manage;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\InstancePeriod;
use App\Traits\PeriodeTrait;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admission\Models\Admission;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

class PeriodeController extends Controller
{
    use PeriodeTrait;

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
        return view('admission::admin.database.manage.periode.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d',
            'year' => 'required|numeric',
            'status' => 'required|boolean|in:0,1',
        ]);

        DB::beginTransaction();
        try {

            $admission = $this->generatePeriodeAndAdmission((object) $validated);
            $this->generateAdmissionCommittes($admission);
            $this->generateAdmissionForms($admission);
            $this->generateAdmissionReqs($admission);
            $this->generateAdmissionFiles($admission);
            $this->generateAdmissionSession($admission);

            if ($request->status) {
                $this->update($admission, $request);
            }

            DB::commit();

            return redirect()->back()
                    ->with(['success' => 'Sukses, tahun akademik baru berhasil dibuat!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput();
        }
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
            'open' => 1,
            'published' => 1
        ]);

        Admission::where('id', '!=', $periode->id)->update([
            'open' => 0,
            'published' => 0
        ]);

        $committeess = DB::table('admission_committees')->where('admission_id', $periode->id)->get();
        DB::table('admission_committee_members')->where('kd', 'PAN-01')->update([
            'committee_id' => $committeess->where('name', 'Panitia')->first()->id
        ]);
        DB::table('admission_committee_members')->where('kd', 'PRG-01')->update([
            'committee_id' => $committeess->where('name', 'Programmer')->first()->id
        ]);
        DB::table('admission_committee_members')->where('kd', 'PB-01')->update([
            'committee_id' => $committeess->where('name', 'Div. Pembayaran')->first()->id
        ]);

        return redirect($request->get('next', route('admission.admin.database.manage.periode.index')))
                    ->with(['success' => 'Sukses, Periode berhasil diubah']);
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
