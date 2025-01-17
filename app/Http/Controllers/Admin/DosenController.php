<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\m_dosen;
use App\Models\ref_agama;
use App\Models\ref_wilayah;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\DosenRequest;
use Session, DB, Str, Response;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        return view('admin.dosen.index', compact('agama'));
    }

    public function data_index(Request $request)
    {
        $query = m_dosen::setFilter([
            'limit' => $request->start+$request->length,
        ])->get();

        $count_total = m_dosen::count_total();
        $count_filter = m_dosen::count_total([
            'limit' => $request->start+$request->length,
        ]);

        return datatables()->of($query)
            ->with([
                "recordsTotal"    => $count_total,
                "recordsFiltered" => $count_filter,
            ])
            ->addIndexColumn()
            ->addColumn('select_all', function ($data) {
                return '
                    <input type="checkbox"' .' name="dosen_id[]" value="'. $data->id_dosen .'">
                ';
            })
            ->addColumn('action', function ($data) {

                $button = '<div class="btn-group" role="group" aria-label="Basic example">';

                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fa fa-edit",
                    // 'attribute' => [
                    //     'data-nama_dosen' => $data->nama_dosen,
                    //     'data-id_prodi' => $data->id_prodi,
                    //     'data-id_semester' => $data->id_semester,
                    //     'data-jumlah_sks_lulus' => $data->jumlah_sks_lulus,
                    //     'data-jumlah_sks_wajib' => $data->jumlah_sks_wajib,
                    //     'data-jumlah_sks_pilihan' => $data->jumlah_sks_pilihan,
                    // ],
                    "route" => route('admin.dosen.edit', ['dosen' => $data->id_dosen]),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.dosen.destroy', ['dosen' => $data->id_dosen]),
                ]);

                $button .= '</div>';

                return $button;
            })
            ->addColumn('status', function ($data) {
                return $data->id_status_aktif ? 'Aktif' : 'Tidak Aktif';
            })
            ->rawColumns(['action', 'select_all'])
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
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah');

        return view('admin.dosen.create', compact('agama', 'wilayah'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DosenRequest $request)
    {
        DB::beginTransaction();

        try {
            $role_dosen  = Role::where('name', 'dosen')->first();

            $user = new User();
            $user->email = $request->nidn;
            $user->name = $request->nama_dosen;
            $user->password = bcrypt('000000');
            $user->role_id = $role_dosen->id;
            $user->save();
            $user->roles()->attach($role_dosen);

            $request->merge([
                'user_id' => $user->id,
                'id_dosen' => Str::uuid(),
            ]);
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
    public function edit(m_dosen $dosen)
    {
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah');

        return view('admin.dosen.edit', compact('agama', 'wilayah', 'dosen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DosenRequest $request, m_dosen $dosen)
    {
        DB::beginTransaction();

        try {

            $role_dosen  = Role::where('name', 'dosen')->first();

            $user = User::where('email', $dosen->nidn)->first();
            $user->email = $request->nidn;
            $user->name = $request->nama_dosen;
            if($request->password){
                $user->password = bcrypt($request->password);
            }
            $user->update();

            $dosen->update($request->validated());
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

    public function massCreateAccount(Request $request)
    {
        $role_dosen  = Role::where('name', 'dosen')->first();

        foreach ($request->dosen_id as $id) {
            $dosen = m_dosen::find($id);
            $user = new User();
            $user->email = $dosen->nidn;
            $user->name = $dosen->nama_dosen;
            $user->password = bcrypt('000000');
            $user->role_id = $role_dosen->id;
            $user->id_dosen = $dosen->id_dosen;
            $user->save();
            $user->roles()->attach($role_dosen);
        }

        return Response::json(['success' => 'Akun dosen terpilih berhasil dibuat!'], 200);
    }
}
