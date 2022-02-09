<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_mahasiswa;
use App\Models\m_program_studi;
use App\Models\ref_agama;
use App\Models\m_semester;
use App\Models\ref_jenis_tinggal;
use App\Models\ref_jenjang_pendidikan;
use App\Models\ref_kebutuhan_khusus;
use App\Models\ref_pekerjaan;
use App\Models\ref_penghasilan;
use App\Models\ref_alat_transportasi;
use App\Models\ref_wilayah;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\MahasiswaRequest;
use Session, DB, Str, Response;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $periode = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester')->prepend('Pilih Periode Masuk', NULL);
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        $status_mahasiswa = $this->status_mahasiswa;

        return view('admin.mahasiswa.index', compact('prodi', 'periode', 'agama', 'status_mahasiswa'));
    }

    public function data_index(Request $request)
    {
        $query = m_mahasiswa::setFilter([
            'limit' => $request->start+$request->length
        ])
        ->when($request->prodi, function($q) use ($request){
            $q->where('id_prodi', $request->prodi);
        })
        ->when($request->periode, function($q) use ($request){
            $q->where('id_periode', $request->periode);
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
                return '
                    <input type="checkbox"' .' name="mahasiswa_id[]" value="'. $data->id_mahasiswa .'">
                ';
            })
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                // $button .= view("components.button.default", [
                //     'type' => 'link',
                //     'tooltip' => 'Detail',
                //     'class' => 'btn btn-outline-success btn-sm',
                //     "icon" => "fa fa-eye",
                //     "route" => route('admin.mahasiswa.show',['mahasiswa' => $data->id]),
                // ]);

                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fa fa-edit",
                    // 'attribute' => [
                    //     'data-nama' => $data->nama_mahasiswa,
                    //     'data-prodi' => $data->id_prodi,
                    //     'data-periode' => $data->id_periode,
                    //     'data-tanggal_lahir' => $data->tanggal_lahir,
                    //     'data-id_agama' => $data->id_agama,
                    //     'data-nim' => $data->nim,
                    //     'data-id_status_mahasiswa' => $data->id_status_mahasiswa,
                    //     'data-id_perguruan_tinggi' => $data->id_perguruan_tinggi,
                    // ],
                    "route" => route('admin.mahasiswa.edit',['mahasiswa' => $data->id_mahasiswa]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.mahasiswa.destroy',['mahasiswa' => $data->id_mahasiswa]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('agama', function ($data) {
                return $data->agama->nama_agama;
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
        $agama = ref_agama::pluck('nama_agama', 'id_agama')->prepend('Pilih', NULL);
        $jenis_tinggal = ref_jenis_tinggal::pluck('nama_jenis_tinggal', 'id_jenis_tinggal')->prepend('Pilih', NULL);
        $jenjang_pendidikan = ref_jenjang_pendidikan::pluck('nama_jenjang_didik', 'id_jenjang_didik')->prepend('Pilih', NULL);
        $kebutuhan_khusus = ref_kebutuhan_khusus::pluck('nama_kebutuhan_khusus', 'id_kebutuhan_khusus')->prepend('Pilih', NULL);
        $pekerjaan = ref_pekerjaan::pluck('nama_pekerjaan', 'id_pekerjaan')->prepend('Pilih', NULL);
        $penghasilan = ref_penghasilan::pluck('nama_penghasilan', 'id_penghasilan')->prepend('Pilih', NULL);
        $alat_transportasi = ref_alat_transportasi::pluck('nama_alat_transportasi', 'id_alat_transportasi')->prepend('Pilih', NULL);
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah')->prepend('Pilih', NULL);

        return view('admin.mahasiswa.create', compact('agama', 'jenis_tinggal', 'jenjang_pendidikan', 'kebutuhan_khusus', 'pekerjaan', 'penghasilan', 'alat_transportasi', 'wilayah'));
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(m_mahasiswa $mahasiswa)
    {
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        $jenis_tinggal = ref_jenis_tinggal::pluck('nama_jenis_tinggal', 'id_jenis_tinggal');
        $jenjang_pendidikan = ref_jenjang_pendidikan::pluck('nama_jenjang_didik', 'id_jenjang_didik');
        $kebutuhan_khusus = ref_kebutuhan_khusus::pluck('nama_kebutuhan_khusus', 'id_kebutuhan_khusus');
        $pekerjaan = ref_pekerjaan::pluck('nama_pekerjaan', 'id_pekerjaan');
        $penghasilan = ref_penghasilan::pluck('nama_penghasilan', 'id_penghasilan');
        $alat_transportasi = ref_alat_transportasi::pluck('nama_alat_transportasi', 'id_alat_transportasi');
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah');

        return view('admin.mahasiswa.edit', compact('agama', 'jenis_tinggal', 'jenjang_pendidikan', 'kebutuhan_khusus', 'pekerjaan', 'penghasilan', 'alat_transportasi', 'wilayah', 'mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MahasiswaRequest $request)
    {
        // $perguruan_tinggi = m_perguruan_tinggi::find(1) ?? 0;
        DB::beginTransaction();

        try{
            $role_mahasiswa  = Role::where('name', 'mahasiswa')->first();

            $user = new User();
            $user->email = $request->nim;
            $user->name = $request->nama_mahasiswa;
            $user->password = bcrypt('000000');
            $user->role_id = $role_mahasiswa->id;
            $user->save();
            $user->roles()->attach($role_mahasiswa);

            $request->merge([
                'user_id' => $user->id,
                'id_mahasiswa' => Str::uuid(),
            ]);
            $data = m_mahasiswa::create($request->all());
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.mahasiswa.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
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

            $user = User::where('email', $mahasiswa->nim)->first();
            $user->email = $request->nim;
            $user->name = $request->nama_mahasiswa;
            if($request->password){
                $user->password = bcrypt($request->password);
            }
            $user->update();

            $mahasiswa->update($request->validated());
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(m_mahasiswa $mahasiswa)
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id');
        $periode = m_semester::orderBy('nama_semester','DESC')->pluck('nama_semester', 'id');
        $agama = ref_agama::pluck('nama_agama', 'id');
        $status_mahasiswa = $this->status_mahasiswa;

        return view('admin.mahasiswa.show', compact('mahasiswa', 'prodi', 'periode', 'agama', 'status_mahasiswa'));
    }

    public function massCreateAccount(Request $request)
    {
        $role_mahasiswa  = Role::where('name', 'mahasiswa')->first();

        foreach ($request->mahasiswa_id as $id) {
            $mahasiswa = m_mahasiswa::find($id);
            $user = new User();
            $user->email = $mahasiswa->nim;
            $user->name = $mahasiswa->nama_mahasiswa;
            $user->password = bcrypt('000000');
            $user->role_id = $role_mahasiswa->id;
            $user->id_mahasiswa = $mahasiswa->id_mahasiswa;
            $user->save();
            $user->roles()->attach($role_mahasiswa);
        }

        return Response::json(['success' => 'Akun mahasiswa terpilih berhasil dibuat!'], 200);
    }
}
