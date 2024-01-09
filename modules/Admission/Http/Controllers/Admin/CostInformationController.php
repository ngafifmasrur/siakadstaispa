<?php

namespace Modules\Admission\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admission\Models\CostInformation;

class CostInformationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $costInfomations = collect([
            [
                'name' => 'Rincian Pembayaran',
            ],[
                'name' => 'Biaya Pendidikan',
            ]
        ]);

        $costInfomationsMapped = $costInfomations->map(function ($costInformation) {

            $costInformationModel = CostInformation::where('name', $costInformation['name'])
                                    ->first();

            return [
                'name' => $costInformation['name'],
                'key' => strtolower(str_replace(' ', '_', $costInformation['name'])),
                'value' => $costInformationModel->description ?? null
            ];
        });

        $data = CostInformation::whereNotIn('name', $costInfomations)
                ->paginate(10);

        return view('admission::admin.cost_information.index', [
            'data' => $data,
            'costInfomations' => $costInfomationsMapped
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admission::admin.cost_information.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'detail' => 'required|numeric',
        ]);

        CostInformation::create([
            'name'   => $request->name,
            'detail' => $request->detail
        ]);

        return redirect(route('admission.admin.cost_information.index'))
                    ->with(['success' => 'Sukses, data informasi biaya berhasil ditambahkan']);
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
    public function edit(CostInformation $costInformation)
    {
        return view('admission::admin.cost_information.edit', [
            'costInformation' => $costInformation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, CostInformation $costInformation)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'detail' => 'required|numeric',
        ]);

        $costInformation->update($validated);

        return redirect(route('admission.admin.cost_information.index'))
                    ->with(['success' => 'Sukses, data informasi biaya berhasil diedit']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(CostInformation $costInformation)
    {

        if($costInformation->delete()) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, data informasi biaya telah berhasil dihapus.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function storeOrUpdateCosts(Request $request)
    {

        $costInfomations = collect([
            'Rincian Pembayaran',
            'Biaya Pendidikan'
        ]);

        $costInfomations->map(function ($costInfomation) use ($request) {

            $key = strtolower(str_replace(' ','_',$costInfomation));

            CostInformation::query()
                ->updateOrCreate([
                    'name' => $costInfomation
                ],[
                    'description' => $request->input($key)
                ]);
        });

        return redirect(route('admission.admin.cost_information.index'))
                    ->with(['success' => 'Sukses, data informasi biaya berhasil disimpan!']);
    }

}
