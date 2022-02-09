<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_riwayat_pendidikan_mahasiswa,
    t_perkuliahan_mahasiswa,
    m_program_studi,
    m_semester,
    ref_status_mahasiswa,
    m_tahun_ajaran
};
use Session, DB;

class PerkuliahanMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::orderBy('nama_semester','DESC')->pluck('nama_semester', 'id_semester');
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::pluck('nama_mahasiswa', 'id_registrasi_mahasiswa')->prepend('Pilih Mahasiswa', NULL);
        $status_mahasiswa = ref_status_mahasiswa::pluck('nama_status_mahasiswa', 'id_status_mahasiswa')->prepend('Pilih Status Mahasiswa', NULL);
        $angkatan = m_tahun_ajaran::orderBy('id_tahun_ajaran','asc')->pluck('id_tahun_ajaran', 'id_tahun_ajaran')->prepend('Pilih Angkatan', NULL);

        return view('admin.perkuliahan_mahasiswa.index', compact('prodi', 'semester', 'mahasiswa', 'angkatan', 'status_mahasiswa'));
    }

    public function data_index(Request $request)
    {
        $query = t_perkuliahan_mahasiswa::setFilter([
            'filter' => "id_semester='$request->semester'"
        ])
        ->when($request->prodi, function ($query) use ($request) {
            $query->where('id_prodi', $request->prodi);
        })
        ->when($request->angkatan, function ($query) use ($request) {
            $query->where('angkatan', $request->angkatan);
        })
        ->when($request->status_mahasiswa, function ($query) use ($request) {
            $query->where('id_status_mahasiswa', $request->status_mahasiswa);
        })->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    "route" => route('admin.perkuliahan_mahasiswa.update', [$data->id_registrasi_mahasiswa, $data->id_semester]),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.perkuliahan_mahasiswa.destroy', [$data->id_registrasi_mahasiswa, $data->id_semester]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function store(Request $request)
    {
        $records = $request->except('_token', '_method');
        $result = InsertDataFeeder('InsertPerkuliahanMahasiswa', $records, 'GetListPerkuliahanMahasiswa');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function update(Request $request, $id_registrasi_mahasiswa, $id_semester)
    {
        $records = $request->except('_token', '_method');
        $key = [
            'id_registrasi_mahasiswa' => $id_registrasi_mahasiswa,
            'id_semester' => $id_semester
        ];

        $result = UpdateDataFeeder('UpdatePerkuliahanMahasiswa', $key, $records, 'GetListPerkuliahanMahasiswa');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function destroy(Request $request, $id_registrasi_mahasiswa, $id_semester)
    {
        $key = [
            'id_registrasi_mahasiswa' => $id_registrasi_mahasiswa,
            'id_semester' => $id_semester
        ];
        
        $result = DeleteDataFeeder('DeletePerkuliahanMahasiswa', $key, 'GetListPerkuliahanMahasiswa');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }
}
