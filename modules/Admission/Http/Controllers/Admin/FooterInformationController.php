<?php

namespace Modules\Admission\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Admission\Models\FooterInformation;

class FooterInformationController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = FooterInformation::when($request->get('aid'), function($q) use ($request) {
            $q->where('type', $request->get('aid'));
        })->get();

        return view('admission::admin.footer_information.index', [
            'data' => $data,
            'type' => FooterInformation::TYPE
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admission::admin.footer_information.create', [
            'type' => FooterInformation::TYPE
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', Rule::in(FooterInformation::TYPE)],
            'name' => 'required|string',
            'status' => 'in:0,1'
        ]);

        FooterInformation::create([
            'type' => $request->type,
            'name' => $request->name,
            'status' => $request->status
        ]);

        return redirect($request->get('next', route('admission.admin.footer_information.index')))
                    ->with(['success' => 'Sukses, data infromasi footer berhasil ditambahkan']);
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
    public function edit(FooterInformation $footerInformation)
    {
        return view('admission::admin.footer_information.edit', [
            'footerInformation' => $footerInformation,
            'type' => FooterInformation::TYPE
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, FooterInformation $footerInformation)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::in(FooterInformation::TYPE)],
            'name' => 'required|string',
            'status' => 'in:0,1'
        ]);

        $footerInformation->update($validated);

        return redirect($request->get('next', route('admission.admin.footer_information.index')))
                    ->with(['success' => 'Sukses, data informasi footer berhasil diedit']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(FooterInformation $footerInformation)
    {

        if($footerInformation->delete()) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, data informasi footer telah berhasil dihapus.']);
        }
    }
}
