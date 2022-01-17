<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dosen\PengabdianRequest;
use App\Models\m_program_studi;
use App\Models\t_pengabdian;
use Session, DB;

class PengabdianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);

        return view('dosen.pengabdian.index', compact('prodi'));
    }

    public function data_index(Request $request)
    {
        $query = t_pengabdian::byDosen();

        return datatables()->of($query)
            ->addIndexColumn()
            ->editColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('action', function ($data) {

                $button = '<div class="btn-group" role="group" aria-label="Basic example">';

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    'attribute' => [
                        'data-id_prodi' => $data->id_prodi,
                        'data-id_dosen' => $data->id_dosen,
                        'data-sumber_dana' => $data->sumber_dana,
                        'data-nominal' => $data->nominal,
                        'data-tahun' => $data->tahun,
                        'data-judul_pengabdian' => $data->judul_pengabdian
                    ],
                    "route" => route('dosen.pengabdian.update', $data->id),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('dosen.pengabdian.destroy', $data->id),
                ]);

                $button .= '</div>';

                return $button;
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
    public function store(PengabdianRequest $request)
    {
        DB::beginTransaction();

        try {
            $request['id_dosen'] = auth()->user()->dosen->id_dosen;
            t_pengabdian::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('dosen.pengabdian.index');
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return dd($e);
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
    public function update(PengabdianRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $t_pengabdian = t_pengabdian::findOrFail($id);
            $t_pengabdian->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('dosen.pengabdian.index');
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
    public function destroy($id)
    {
        $t_pengabdian = t_pengabdian::findOrFail($id);
        $t_pengabdian->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
