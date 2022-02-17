<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    m_dosen,
    m_dosen_wali,
    t_dosen_wali_mahasiswa,
    t_riwayat_pendidikan_mahasiswa,
    m_program_studi,
    m_semester,
};
use DB, Session, Response;

class DosenWaliController extends Controller
{
    public function index()
    {
        return view('admin.dosen_wali.index');
    }

    public function data_index()
    {
        $query = m_dosen_wali::with('dosen');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';

                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fa fa-edit",
                    "route" => route('admin.dosen_wali.edit', $data->id),
                ]);

                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                        ''.$data->mahasiswa->count() > 0 ? 'disabled' : 'enabled'.'' => '',
                    ],
                    "route" => route('admin.dosen_wali.destroy', $data->id),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('mahasiswa',function ($data) {

                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Detail Mahasiswa',
                    "icon" => "fa fa-users",
                    "label" => $data->mahasiswa->count(),
                    "route" => route('admin.dosen_wali.show', $data->id),
                ]);

                return $button;
            })
            ->addColumn('nidn',function ($data) {
                return $data->dosen->nidn;
            })
            ->addColumn('nama_dosen',function ($data) {
                return $data->dosen->nama_dosen;
            })
            ->rawColumns(['action', 'mahasiswa'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function list_mahasiswa(Request $request)
    {

        $query = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_prodi='$request->prodi' AND id_periode_masuk='$request->periode'"
        ])->get();

        $query->map(function ($item){
            $check = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $item->id_registrasi_mahasiswa)->first();
            $item['punya_wali'] = isset($check);

            return $item;
        });

        $count_total = $query->count() ; //count(GetDataFeeder('GetListMahasiswa'));
        $count_filter = t_riwayat_pendidikan_mahasiswa::count_total([
            'filter' => "id_prodi='$request->prodi' AND id_periode_masuk='$request->periode'"
        ]);

            return datatables()->of($query)
            ->with([
                "recordsTotal"    => intval($count_total),
                "recordsFiltered" => intval($count_filter),
            ])
            ->addIndexColumn()
            ->addColumn('select_all', function ($data) {
                if($data->punya_wali == true) {
                    return '';
                } else {
                    return '<input type="checkbox"' .' name="mahasiswa_id[]" value="'. $data->id_registrasi_mahasiswa .'">';
                }
            })
            ->addColumn('mahasiswa', function ($data) {
                return $data->nama_mahasiswa;
            })
            ->addColumn('nim', function ($data) {
                return $data->nim;
            })
            ->rawColumns(['select_all'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function mahasiswa_wali_index(Request $request, $dosen_wali)
    {

        $query = t_dosen_wali_mahasiswa::where('id_dosen', $dosen_wali)->with('mahasiswa')->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('select_all', function ($data) {
                return '<input type="checkbox"' .' name="id_registrasi_mahasiswa[]" value="'. $data->id_registrasi_mahasiswa .'">';
            })
            ->addColumn('action',function ($data) {

                $button = view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Copot',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    "label" => 'Copot',
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin mencopot mahasiswa ini ?',
                    ],
                    "route" => route('admin.dosen_wali.copot', $data->id_registrasi_mahasiswa),
                ]);

                return $button;
            })
            ->addColumn('nama_mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('nim', function ($data) {
                return $data->mahasiswa->nim;
            })
            ->addColumn('jenis_kelamin', function ($data) {
                return $data->mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->addColumn('nama_program_studi', function ($data) {
                return $data->mahasiswa->nama_program_studi;
            })
            ->rawColumns(['action', 'select_all'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
        ->toJson();
    }

    public function show(m_dosen_wali $dosen_wali)
    {
        return view('admin.dosen_wali.show', compact('dosen_wali'));
    }

    public function create()
    {
        $dosen_wali_aktif = t_dosen_wali_mahasiswa::pluck('id_dosen')->toArray();
        $dosen = m_dosen::whereNotIn('id_dosen', $dosen_wali_aktif)->pluck('nama_dosen', 'id_dosen')->prepend('Pilih Dosen', NULL);
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::pluck('nama_mahasiswa', 'id_registrasi_mahasiswa');
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi');
        $periode = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester');

        return view('admin.dosen_wali.create', compact('dosen', 'mahasiswa', 'prodi', 'periode'));
    }

    public function edit(m_dosen_wali $dosen_wali)
    {
        $dosen_wali_aktif = t_dosen_wali_mahasiswa::pluck('id_dosen')->except($dosen_wali->id_dosen)->toArray();
        $dosen = m_dosen::whereNotIn('id_dosen', $dosen_wali_aktif)->pluck('nama_dosen', 'id_dosen')->prepend('Pilih Dosen', NULL);
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi');
        $periode = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester');
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::pluck('nama_mahasiswa', 'id_registrasi_mahasiswa');
        
        return view('admin.dosen_wali.edit', compact('dosen', 'mahasiswa', 'prodi', 'periode', 'dosen_wali'));
    }

    public function store(Request $request)
    {
        $rules = [];
        $rules['id_dosen'] = ['required'];
        $this->validate($request, $rules);

        DB::beginTransaction();

        try{
            
            $dosen_wali = m_dosen_wali::create([
                'id_dosen' => $request->id_dosen
            ]);

            foreach ($request->mahasiswa_id as $id) {
                $mahasiswa[] = [
                    'id_dosen' => $dosen_wali->id_dosen,
                    'id_registrasi_mahasiswa' => $id
                ];
            }

            t_dosen_wali_mahasiswa::insert($mahasiswa);

            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.dosen_wali.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, m_dosen_wali $dosen_wali)
    {

        $rules = [];
        $rules['id_dosen'] = ['required'];
        $this->validate($request, $rules);

        DB::beginTransaction();

        try{
            
            t_dosen_wali_mahasiswa::where('id_dosen', $dosen_wali->id_dosen)->delete();

            $dosen_wali->update([
                'id_dosen' => $request->id_dosen
            ]);
            foreach ($request->mahasiswa_id as $id) {
                $mahasiswa[] = [
                    'id_dosen' => $dosen_wali->id_dosen,
                    'id_registrasi_mahasiswa' => $id
                ];
            }
        
            t_dosen_wali_mahasiswa::insert($mahasiswa);

            DB::commit();

            Session::flash('success_msg', 'Berhasil Ditambah');
            return redirect()->route('admin.dosen_wali.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(m_dosen_wali $dosen_wali)
    {
        DB::beginTransaction();

        try{
            
            $dosen_wali->delete();

            DB::commit();

            Session::flash('success_msg', 'Berhasil Dihapus');
            return redirect()->route('admin.dosen_wali.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function copot($id_registrasi_mahasiswa)
    {
        DB::beginTransaction();

        try{
            
            t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $id_registrasi_mahasiswa)->delete();

            DB::commit();

            Session::flash('success_msg', 'Berhasil Dihapus');
            return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function copot_pilihan(Request $request)
    {
        foreach ($request->id_registrasi_mahasiswa as $id) {
            $mahasiswa = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $id)->first();
            if(isset($mahasiswa)) {
                $mahasiswa->delete();
            }
        }

        return Response::json(['success' => 'Akun dosen terpilih berhasil dibuat!'], 200);
    }
}
