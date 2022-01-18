<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_program_studi;
use Illuminate\Support\Facades\Http;
use Session, DB, Str;

class ProgramStudiController extends Controller
{
    public function index()
    {
        return view('admin.program_studi.index')->with([
            'jenjang_pendidikan' => $this->jenjang_pendidikan,
            'status_prodi' => $this->status_prodi
        ]);
    }

    public function data_index(Request $request)
    {
        $jenjang_pendidikan = $this->jenjang_pendidikan;
        $status_prodi = $this->status_prodi;
        // $query = m_program_studi::all();

        $resource = Http::get(config('app.url_feeder') .'/prodi');

        if ($resource->status() == 200) {
            $query = $resource->collect('data')->map(function ($item) {
                return (object) $item;
            });
        } else {
            $query = [];
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                $button = '<div class="btn-group" role="group" aria-label="Basic example">';

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    'attribute' => [
                        'data-kode' => $data->kode_program_studi,
                        'data-nama' => $data->nama_program_studi,
                        'data-jenjang' => $data->id_jenjang_pendidikan,
                        'data-status' => $data->status,
                    ],
                    "route" => route('admin.program_studi.update', $data->id_prodi),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.program_studi.destroy', $data->id_prodi),
                ]);

                $button .= '</div>';

                return $button;
            })
            ->addColumn('status', function ($data) use ($status_prodi) {
                return $status_prodi[$data->status];
            })
            ->addColumn('jenjang', function ($data) use ($jenjang_pendidikan) {
                return $jenjang_pendidikan[$data->id_jenjang_pendidikan];
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function show($id)
    {
        abort(404);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->merge([
                'id_prodi' => Str::uuid(),
                'nama_jenjang_pendidikan' => $this->jenjang_pendidikan[$request->id_jenjang_pendidikan]
            ]);
            // $data = m_program_studi::create($request->all());
            $resource = Http::post(config('app.url_feeder') .'/prodi', $request->all());
            if ($resource->status() != 200) {
                throw new \Exception('Terjadi kesalahan pada server');
            }
            // DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.program_studi.index');
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->merge([
                'nama_jenjang_pendidikan' => $this->jenjang_pendidikan[$request->id_jenjang_pendidikan]
            ]);
            $resource = Http::get(config('app.url_feeder') ."/prodi/$id");

            if ($resource->status() == 200) {
                $data = Http::put(config('app.url_feeder') ."/prodi/$id", $request->all());

                if ($data->status() != 200) {
                    throw new \Exception('Terjadi kesalahan pada server');
                }
            } else {
                throw new \Exception('Terjadi kesalahan pada server');
            }

            // DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.program_studi.index');
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $resource = Http::get(config('app.url_feeder') ."/prodi/$id");

            if ($resource->status() == 200) {
                $resource = Http::delete(config('app.url_feeder') ."/prodi/$id");

                if ($resource->status() != 200) {
                    throw new \Exception('Terjadi kesalahan pada server');
                }
            } else {
                throw new \Exception('Terjadi kesalahan pada server');
            }

            Session::flash('success_msg', 'Berhasil Dihapus');
            return back();
        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back();
        }
    }
}
