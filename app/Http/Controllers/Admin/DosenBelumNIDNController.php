<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DosenRequest;
use App\Models\{
    m_dosen_belum_nidn,
    ref_agama,
    ref_wilayah,
    ref_jenis_sdm,
    t_penugasan_dosen_belum_nidn
};
use DB, Auth, Session, Str;


class DosenBelumNIDNController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        return view('admin.dosen_belum_nidn.index', compact('agama'));
    }

    public function data_index(Request $request)
    {
        $query = m_dosen_belum_nidn::all();
        $query->map(function ($item){
            $check = t_penugasan_dosen_belum_nidn::where('id_dosen', $item->id_dosen)->first();
            $item['penugasan_dosen'] = isset($check);
            return $item;
        });
        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                $button = '<div class="btn-group" role="group" aria-label="Basic example">';

                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fa fa-edit",
                    'attribute' => [
                        'data-nama_dosen' => $data->nama_dosen,
                        'data-nip' => $data->nip,
                        'data-tanggal_lahir' => $data->tanggal_lahir,
                        'data-id_agama' => $data->id_agama,
                        'data-id_status_aktif' => $data->id_status_aktif,
                        'data-jenis_kelamin' => $data->jenis_kelamin,
                    ],
                    "route" => route('admin.dosen_belum_nidn.edit', $data->id_dosen),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                        ''.$data->penugasan_dosen ? 'disabled' : 'enabled'.'' => $data->penugasan_dosen,
                    ],
                    "route" => route('admin.dosen_belum_nidn.destroy', $data->id_dosen),
                ]);

                $button .= '</div>';

                return $button;
            })
            ->addColumn('status', function ($data) {
                return $data->id_status_aktif ? 'Aktif' : 'Tidak Aktif';
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
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah');
        $ikatan_sdm = ref_jenis_sdm::pluck('nama_ikatan_kerja', 'id_ikatan_kerja');
        return view('admin.dosen_belum_nidn.create', compact('agama', 'wilayah', 'ikatan_sdm'));
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(m_dosen_belum_nidn $dosen_belum_nidn)
    {
        $agama = ref_agama::pluck('nama_agama', 'id_agama');
        $wilayah = ref_wilayah::pluck('nama_wilayah', 'id_wilayah');
        $ikatan_sdm = ref_jenis_sdm::pluck('nama_ikatan_kerja', 'id_ikatan_kerja');
        return view('admin.dosen_belum_nidn.edit', compact('agama', 'wilayah', 'ikatan_sdm', 'dosen_belum_nidn'));
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

            $nama_agama = ref_agama::where('id_agama', $request->id_agama)->first()->nama_agama;
            $ikatan_sdm = ref_jenis_sdm::where('id_ikatan_kerja', $request->id_jenis_sdm)->first()->nama_ikatan_kerja;

            $request->merge([
                'id_dosen' => Str::uuid(),
                'nidn' => $request->nik,
                'nama_agama' => $nama_agama,
                'nama_jenis_sdm' => $ikatan_sdm,
                'id_status_aktif' =>$request->id_status_aktif ?? 0,
                'nama_status_aktif' =>$request->id_status_aktif ? 'Aktif' : 'Tidak Aktif'
            ]);
            $data = m_dosen_belum_nidn::create($request->except('updated_at', 'created_at'));
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.dosen_belum_nidn.index');
        } catch (\Exception $e) {

            DB::rollback();
            dd($e);
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
    public function update(DosenRequest $request, m_dosen_belum_nidn $dosen_belum_nidn)
    {
        DB::beginTransaction();

        try {

            $nama_agama = ref_agama::where('id_agama', $request->id_agama)->first()->nama_agama;
            $ikatan_sdm = ref_jenis_sdm::where('id_ikatan_kerja', $request->id_jenis_sdm)->first()->nama_ikatan_kerja;

            $request->merge([
                'nidn' => $request->nik,
                'nama_agama' => $nama_agama,
                'nama_jenis_sdm' => $ikatan_sdm,
                'id_status_aktif' =>$request->id_status_aktif ?? 0,
                'nama_status_aktif' =>$request->id_status_aktif ? 'Aktif' : 'Tidak Aktif'
            ]);
            $dosen_belum_nidn->update($request->except('updated_at', 'created_at'));
            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.dosen_belum_nidn.index');
        } catch (\Exception $e) {

            DB::rollback();
            dd($e);
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
    public function destroy(m_dosen_belum_nidn $dosen_belum_nidn)
    {
        if (is_null($dosen_belum_nidn)) {
            abort(404);
        }

        $check = t_penugasan_dosen_belum_nidn::where('id_dosen', $dosen_belum_nidn->id_dosen)->first();
        if(isset($chech)) {
            Session::flash('error_msg', 'Tidak dapat dihapus, Dosen sudah memilik penugasan dosen!');
            return redirect()->back()->withInput();
        }

        $dosen_belum_nidn->delete();

        Session::flash('success_msg', 'Berhasil Dihapus');
        return back();
    }
}
