<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_kelas_kuliah;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah;
use App\Models\m_semester;
use App\Http\Requests\KelasKuliahRequest;
use Session, DB;

class KelasKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        $mata_kuliah = m_mata_kuliah::pluck('nama_mata_kuliah', 'id_matkul')->prepend('Pilih Matkul', NULL);

        return view('admin.kelas_kuliah.index', compact('prodi', 'semester', 'mata_kuliah'));
    }

    public function data_index(Request $request)
    {
        $query = m_kelas_kuliah::query()
                ->when($request->id_prodi, function ($q) use ($request) {
                    $q->where('id_prodi', $request->id_prodi);
                })
                ->when($request->id_semester, function ($q) use ($request) {
                    $q->where('id_semester', $request->id_semester);
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
                    "route" => route('admin.kelas_kuliah.update',['kelas_kuliah' => $data->id_kelas_kuliah]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.kelas_kuliah.destroy',['kelas_kuliah' => $data->id_kelas_kuliah]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('dosen',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Daftar Dosen',
                    'class' => 'btn btn-primary btn-sm',
                    "icon" => "fa fa-users",
                    "attribute" => [
                        'data-nama' => $data->nama_kelas_kuliah,
                        'data-prodi' => $data->id_prodi,
                        'data-semester' => $data->id_semester,
                        'data-matkul' => $data->id_matkul,
                        'data-bahasan' => $data->bahasan,
                        'data-tanggal_mulai' => $data->tanggal_mulai_efektif,
                        'data-tanggal_akhir' => $data->tanggal_akhir_efektif,
                    ],
                    "route" => route('admin.pengajar_kelas_kuliah.index',['id_kelas_kuliah' => $data->id_kelas_kuliah]),
                ]);
                return $button;
            })
            ->addColumn('mahasiswa',function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Daftar Mahasiswa',
                    'class' => 'btn btn-primary btn-sm',
                    "icon" => "fa fa-users",
                    "route" => route('admin.peserta_kelas_kuliah.index',['id_kelas_kuliah' => $data->id_kelas_kuliah]),
                ]);
                return $button;
            })
            ->addColumn('nama_program_studi', function ($data) {
                return $data->nama_program_studi;
            })
            ->addColumn('nama_mata_kuliah', function ($data) {
                return $data->nama_mata_kuliah;
            })
            ->addColumn('nama_semester', function ($data) {
                return $data->nama_semester;
            })
            ->rawColumns(['action', 'dosen', 'mahasiswa'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function store(Request $request)
    {
        $records = $request->except('_token', '_method');
        $result = InsertDataFeeder('InsertKelasKuliah', $records, 'GetListKelasKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function update(Request $request, $kelas_kuliah)
    {
        $records = $request->except('_token', '_method');
        $key = [
            'id_kelas_kuliah' => $kelas_kuliah
        ];

        $result = UpdateDataFeeder('UpdateKelasKuliah', $key, $records, 'GetListKelasKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Diupdate');
        return redirect()->back();
    }

    public function destroy(Request $request, $kelas_kuliah)
    {
        $key = [
            'id_kelas_kuliah' => $kelas_kuliah
        ];
        
        $result = DeleteDataFeeder('DeleteKelasKuliah', $key, 'GetListKelasKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Dihapus');
        return redirect()->back();
    }
}
