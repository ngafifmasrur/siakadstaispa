<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_program_studi;
use Session, DB;

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
        $query = m_program_studi::all();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fas fa-edit",
                    'attribute' => [
                        'data-kode' => $data->kode_program_studi,
                        'data-nama' => $data->nama_program_studi,
                        'data-jenjang' => $data->id_jenjang_pendidikan,
                        'data-status' => $data->status,
                    ],
                    "route" => route('admin.program_studi.update',['program_studi' => $data->id]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fas fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.program_studi.destroy',['program_studi' => $data->id]),
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

        try{
            
            $data = m_program_studi::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.program_studi.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request,m_program_studi $program_studi)
    {
        DB::beginTransaction();

        try{
            
            $program_studi->update($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.program_studi.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }
    
    public function destroy(m_program_studi $program_studi)
    {
        if(is_null($program_studi)){
            abort(404);
        }

        $program_studi->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }

}
