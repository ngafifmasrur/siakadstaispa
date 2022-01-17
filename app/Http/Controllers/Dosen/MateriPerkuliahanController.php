<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dosen\MateriPerkuliahanRequest;
use App\Models\m_mata_kuliah;
use App\Models\m_program_studi;
use App\Models\t_bahan_ajar;
use Session, DB;

class MateriPerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($materi_perkuliahan)
    {
        if (! in_array($materi_perkuliahan, ['bahan_ajar', 'buku_referensi'])) {
            abort(404);
        }

        $materiText = ucwords(str_replace('_', ' ', $materi_perkuliahan));

        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $matkul = m_mata_kuliah::pluck('nama_mata_kuliah', 'id_matkul')->prepend('Pilih Mata Kuliah', NULL);;

        return view('dosen.materi_perkuliahan.index', compact('prodi', 'matkul', 'materi_perkuliahan', 'materiText'));
    }

    public function data_index(Request $request, $materi_perkuliahan)
    {
        $query = t_bahan_ajar::byDosen()->jenis($materi_perkuliahan);

        return datatables()->of($query)
            ->addIndexColumn()
            ->editColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->editColumn('matkul', function ($data) {
                return $data->matkul->nama_mata_kuliah;
            })
            ->editColumn('link', function ($data) {
                if (! $data->link) {
                    return "";
                }

                return "<a href='{$data->link}' target='_blank'>Lihat</a>";
            })
            ->editColumn('path_file', function ($data) {
                return "<a class='btn btn-success' href='". load_from_local($data->path_file) ."' target='_blank'>Lihat</a>";
            })
            ->addColumn('action', function ($data) use ($materi_perkuliahan) {

                $button = '<div class="btn-group" role="group" aria-label="Basic example">';

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    'attribute' => [
                        'data-id_prodi' => $data->id_prodi,
                        'data-id_dosen' => $data->id_dosen,
                        'data-id_matkul' => $data->id_matkul,
                        'data-judul' => $data->judul,
                        'data-path_file' => load_from_local($data->path_file),
                        'data-link' => $data->link,
                        'data-jenis' => $data->jenis
                    ],
                    "route" => route('dosen.{materi_perkuliahan}.update', ['materi_perkuliahan' => $materi_perkuliahan, 'id', $data->id]),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('dosen.{materi_perkuliahan}.destroy', ['materi_perkuliahan' => $materi_perkuliahan, 'id', $data->id])
                ]);

                $button .= '</div>';

                return $button;
            })
            ->rawColumns(['action', 'link', 'path_file'])
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
    public function store(MateriPerkuliahanRequest $request, $materi_perkuliahan)
    {
        DB::beginTransaction();

        try {
            $data = $request->except('path_file');
            $data['id_dosen'] = auth()->user()->dosen->id_dosen;
            $data['jenis'] = $materi_perkuliahan;

            if ($request->hasFile('path_file')) {
                $data['path_file'] = upload_in_local($materi_perkuliahan, $request->file('path_file'), $request->judul);
            }

            t_bahan_ajar::create($data);
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('dosen.{materi_perkuliahan}.index', ['materi_perkuliahan' => $materi_perkuliahan]);
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
    public function update(MateriPerkuliahanRequest $request, $materi_perkuliahan, $id)
    {
        DB::beginTransaction();

        try {
            $data = $request->except('path_file');
            $data['id_dosen'] = auth()->user()->dosen->id_dosen;
            $data['jenis'] = $materi_perkuliahan;

            $t_bahan_ajar = t_bahan_ajar::findOrFail($id);

            if ($request->hasFile('path_file')) {
                remove_in_local($t_bahan_ajar->path_file);

                $data['path_file'] = upload_in_local($materi_perkuliahan, $request->file('path_file'), $request->judul);
            }

            $t_bahan_ajar->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('dosen.{materi_perkuliahan}.index', ['materi_perkuliahan' => $materi_perkuliahan]);
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
    public function destroy($materi_perkuliahan, $id)
    {
        $t_bahan_ajar = t_bahan_ajar::findOrFail($id);
        remove_in_local($t_bahan_ajar->path_file);
        $t_bahan_ajar->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
