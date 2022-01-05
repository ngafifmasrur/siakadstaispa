<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\m_dosen;
use App\Models\ref_agama;
use Illuminate\Http\Request;
use Session, DB;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agama = ref_agama::pluck('nama_agama', 'id');
        return view('admin.dosen.index', compact('agama'));
    }

    public function data_index(Request $request)
    {
        $query = m_dosen::all();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                $button = '<div class="btn-group" role="group" aria-label="Basic example">';

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fas fa-edit",
                    'attribute' => [
                        'data-nama_dosen' => $data->nama_dosen,
                        'data-id_prodi' => $data->id_prodi,
                        'data-id_semester' => $data->id_semester,
                        'data-jumlah_sks_lulus' => $data->jumlah_sks_lulus,
                        'data-jumlah_sks_wajib' => $data->jumlah_sks_wajib,
                        'data-jumlah_sks_pilihan' => $data->jumlah_sks_pilihan,
                    ],
                    "route" => route('admin.dosen.update', ['dosen' => $data->id]),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fas fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.dosen.destroy', ['dosen' => $data->id]),
                ]);

                $button .= '</div>';

                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('semester', function ($data) {
                return $data->semester->nama_semester;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $data = m_dosen::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.dosen.index');
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, m_dosen $dosen)
    {
        DB::beginTransaction();

        try {

            $dosen->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.dosen.index');
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(m_dosen $dosen)
    {
        if (is_null($dosen)) {
            abort(404);
        }

        $dosen->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
