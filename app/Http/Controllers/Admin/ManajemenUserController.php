<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Role,
    m_dosen,
    m_mahasiswa,
    m_program_studi,
    m_semester
};
use Auth, Response, DB, Session;

class ManajemenUserController extends Controller
{
    public function index()
    {
        $role = Role::whereIn('name', ['dosen', 'mahasiswa'])->pluck('name', 'id')->prepend('Pilih Role User', NULL);
        return view('admin.manajemen_user.index', compact('role'));
    }

    public function data_index(Request $request)
    {
        $query = User::query()
        ->whereIn('role_id', [2,3])
        ->when($request->role_id, function($q) use ($request) {
            $q->where('role_id', $request->role_id);
        });

        return datatables()->of($query)
        ->addIndexColumn()
        ->addColumn('action',function ($data) {
            $button = '<div class="btn-group" role="group" aria-label="Basic example">';

            $button .= view("components.button.default", [
                'type' => 'button',
                'tooltip' => 'Ubah',
                'class' => 'btn btn-outline-primary btn-sm btn_edit',
                "icon" => "fa fa-edit",
                "route" => route('admin.manajemen_user.update', $data->id),
            ]);

            $button .= view("components.button.default", [
                'type' => 'button',
                'tooltip' => 'Hapus',
                'class' => 'btn btn-outline-danger btn-sm btn_delete',
                "icon" => "fa fa-trash",
                'attribute' => [
                    'data-text' => 'Anda yakin ingin menghapus data ini ?',
                ],
                "route" => route('admin.manajemen_user.destroy', $data->id),
            ]);

            $button .= view("components.button.default", [
                'type' => 'link',
                'tooltip' => 'Login as',
                'class' => 'btn btn-outline-primary btn-sm',
                "icon" => "fa fa-sign-in",
                "route" => route('impersonate', $data->id),
            ]);

            $button .= '</div>';

            return $button;
        })
        ->addColumn('role', function ($data) {
            return ucfirst($data->role->name);
        })
        ->rawColumns(['action'])
        ->setRowAttr([
            'style' => 'text-align: center',
        ])
        ->toJson();
    }

    public function mahasiswa()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester')->prepend('Pilih Angkatan', NULL);
        return view('admin.manajemen_user.mahasiswa', compact('prodi', 'semester'));
    }

    public function mahasiswa_index(Request $request)
    {
        $query = m_mahasiswa::setFilter([
            'limit' => $request->start+$request->length
        ])
        ->when($request->id_prodi, function($q) use ($request){
            $q->where('id_prodi', $request->id_prodi);
        })
        ->when($request->id_periode, function($q) use ($request){
            $q->where('id_periode', $request->id_periode);
        })
        ->get();

        $count_total = m_mahasiswa::count_total();
        $count_filter = m_mahasiswa::count_total([
            'limit' => $request->start+$request->length
        ]);

        return datatables()->of($query)
            ->with([
                "recordsTotal"    => intval($count_total),
                "recordsFiltered" => $count_filter,
            ])
            ->addIndexColumn()
            ->addColumn('select_all', function ($data) {
                if($data->hasUser()){
                    return '';
                } else {
                    return '<input type="checkbox"' .' name="mahasiswa_id[]" value="'. $data->id_mahasiswa .'">';
                }
            })
            ->addColumn('nama_program_studi', function ($data) {
                return $data->nama_program_studi;
            })
            ->addColumn('nama_periode_masuk', function ($data) {
                return $data->nama_periode_masuk;
            })
            ->rawColumns(['select_all'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
        ->toJson();
    }

    public function generate_user_mahasiswa(Request $request)
    {
        $role_mahasiswa  = Role::where('name', 'mahasiswa')->first();

        foreach ($request->mahasiswa_id as $id) {
            $mahasiswa = m_mahasiswa::find($id);
            $user = new User();
            $user->email = $mahasiswa->nim;
            $user->name = $mahasiswa->nama_mahasiswa;
            $user->password = bcrypt(str_replace("-", "",$mahasiswa->tanggal_lahir));
            $user->role_id = $role_mahasiswa->id;
            $user->id_mahasiswa = $mahasiswa->id_mahasiswa;
            $user->save();
            $user->roles()->attach($role_mahasiswa);
        }

        return Response::json(['success' => 'Akun mahasiswa terpilih berhasil dibuat!'], 200);
    }

    public function dosen()
    {
        return view('admin.manajemen_user.dosen');
    }

    public function dosen_index(Request $request)
    {
        $query = m_dosen::query();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('select_all', function ($data) {
                if($data->hasUser()){
                    return '';
                } else {
                    return '<input type="checkbox"' .' name="dosen_id[]" value="'. $data->id_dosen .'">';
                }
            })
            ->addColumn('status', function ($data) {
                return $data->id_status_aktif ? 'Aktif' : 'Tidak Aktif';
            })
            ->rawColumns(['select_all'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
        ->toJson();
    }


    public function generate_user_dosen(Request $request)
    {
        $role_dosen  = Role::where('name', 'dosen')->first();

        foreach ($request->dosen_id as $id) {
            $dosen = m_dosen::find($id);
            $user = new User();
            $user->email = $dosen->nidn;
            $user->name = $dosen->nama_dosen;
            $user->password = bcrypt(str_replace("-", "",$dosen->tanggal_lahir));
            $user->role_id = $role_dosen->id;
            $user->id_dosen = $dosen->id_dosen;
            $user->save();
            $user->roles()->attach($role_dosen);
        }

        return Response::json(['success' => 'Akun dosen terpilih berhasil dibuat!'], 200);
    }

    public function update(Request $request, User $manajemen_user)
    {
        $validated = $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);


        DB::beginTransaction();

        try{
            
            $manajemen_user->update([
                    'password' => bcrypt($request->password),
            ]);

            DB::commit();

            Session::flash('success_msg', 'Password berhasil diubah');
            return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(User $manajemen_user)
    {
        if(is_null($manajemen_user)){
            abort(404);
        }

        $manajemen_user->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
