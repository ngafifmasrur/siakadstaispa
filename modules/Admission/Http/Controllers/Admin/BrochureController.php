<?php

namespace Modules\Admission\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admission\Models\Brochure;
use Illuminate\Support\Facades\Validator;

class BrochureController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $type = [ 'Brosur Depan', 'Download Brosur'];

        $data = Brochure::when($request->get('aid'), function($q) use ($request) {
            $q->where('type', $request->get('aid'));
        })->get();

        return view('admission::admin.brochure.index', compact('data', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $type = [ 'Brosur Depan', 'Download Brosur'];

        return view('admission::admin.brochure.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Brosur Depan,Download Brosur',
            'name' => 'required|string',
            'path_file' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,' . ($request->input('type') == 'Download Brosur' ? 'pdf' : ''),
                'max:' . ($request->input('type') == 'Download Brosur' ? '5048' : '2048'),
            ],
            'status' => 'in:0,1'
        ]);

        // Make other data inactive when select active status
       if ($request->status) {
            Brochure::where('status', 1)
                    ->where('type', $request->type)
                    ->update([
                        'status' => 0
                    ]);
        }

        $file = $request->file('path_file');

        Brochure::create([
            'type' => $request->type,
            'name' => $request->name,
            'path_file' => $file->store('brosur'),
            'status' => $request->status
        ]);

        return redirect($request->get('next', route('admission.admin.brochure.index')))
                    ->with(['success' => 'Sukses, data brochure berhasil ditambahkan']);
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
    public function edit(Brochure $brochure)
    {
        $type = [ 'Brosur Depan', 'Download Brosur'];

        return view('admission::admin.brochure.edit', compact('brochure', 'type'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Brochure $brochure)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:Brosur Depan,Download Brosur',
            'name' => 'required|string',
            'status' => 'in:0,1'
        ]);

        $validator->sometimes('path_file', 'nullable|file|mimes:jpg,jpeg,png|max:2048', function ($value) {
            return $value->type == 'Brosur Depan';
        });

        $validator->sometimes('path_file', 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5048', function ($value) {
            return $value->type == 'Download Brosur';
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
       }

       // Make other data inactive when select active status
       if ($request->status) {
            Brochure::where('status', 1)
                    ->where('type', $request->type)
                    ->update([
                        'status' => 0
                    ]);
        }

       $data = $validator->validated();

        if ($request->has('path_file')) {
            $data['path_file'] = $request->file('path_file')->store('brosur');
        }

        $brochure->update($data);

        return redirect($request->get('next', route('admission.admin.brochure.index')))
                    ->with(['success' => 'Sukses, data brochure berhasil diedit']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Brochure $brochure)
    {

        if($brochure->delete()) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, data brochure telah berhasil dihapus.']);
        }
    }
}
