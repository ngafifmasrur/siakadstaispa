<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_mahasiswa;
use App\Models\m_program_studi;
use App\Models\ref_agama;
use App\Models\m_semester;
use App\Models\m_perguruan_tinggi;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\MahasiswaRequest;
use Session, DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id');
        $periode = m_semester::pluck('nama_semester', 'id');
        $agama = ref_agama::pluck('nama_agama', 'id');
        $status_mahasiswa = $this->status_mahasiswa;

        return view('admin.mahasiswa.index', compact('prodi', 'periode', 'agama', 'status_mahasiswa'));
    }

    public function data_index(Request $request)
    {
        $query = m_mahasiswa::all();
        $status_mahasiswa = $this->status_mahasiswa;

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
                        'data-nama' => $data->nama_mahasiswa,
                        'data-prodi' => $data->id_prodi,
                        'data-periode' => $data->id_periode,
                        'data-tanggal_lahir' => $data->tanggal_lahir,
                        'data-id_agama' => $data->id_agama,
                        'data-nim' => $data->nim,
                        'data-id_status_mahasiswa' => $data->id_status_mahasiswa,
                        'data-id_perguruan_tinggi' => $data->id_perguruan_tinggi,
                    ],
                    "route" => route('admin.mahasiswa.update',['mahasiswa' => $data->id]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fas fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.mahasiswa.destroy',['mahasiswa' => $data->id]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('agama', function ($data) {
                return $data->agama->nama_agama;
            })
            ->addColumn('periode', function ($data) {
                return $data->periode->nama_semester;
            })
            ->addColumn('status_mahasiswa', function ($data) use ($status_mahasiswa) {
                return $status_mahasiswa[$data->id_status_mahasiswa];
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
    public function store(MahasiswaRequest $request)
    {
        $perguruan_tinggi = m_perguruan_tinggi::find(1) ?? 0;
        DB::beginTransaction();

        try{
            $role_mahasiswa  = Role::where('name', 'mahasiswa')->first();

            $user = new User();
            $user->email = $request->nim;
            $user->name = $request->nama_mahasiswa;
            $user->password = bcrypt($request->password);
            $user->role_id = 2;
            $user->save();
            $user->roles()->attach($role_mahasiswa);


            $request->merge(['id_perguruan_tinggi' => $perguruan_tinggi]);
            $data = m_mahasiswa::create($request->except('password'));
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.mahasiswa.index');

        }catch(\Exception $e){

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
    public function update(MahasiswaRequest $request, m_mahasiswa $mahasiswa)
    {
        DB::beginTransaction();

        try{
            $role_mahasiswa  = Role::where('name', 'mahasiswa')->first();

            $user = User::where('nim', $mahasiswa)->first();
            $user->email = $request->nim;
            $user->name = $request->nama_mahasiswa;
            if($request->password){
                $user->password = bcrypt($request->password);
            }
            $user->update();

            $mahasiswa->update($request->except('password'));
            DB::commit();

            Session::flash('success_msg', 'Berhasil Dibah');
            return redirect()->route('admin.mahasiswa.index');

        }catch(\Exception $e){

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
    public function destroy(m_mahasiswa $mahasiswa)
    {
        if(is_null($mahasiswa)){
            abort(404);
        }

        $mahasiswa->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
