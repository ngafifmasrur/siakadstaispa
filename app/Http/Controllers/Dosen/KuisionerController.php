<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\{
    t_peserta_kelas_kuliah,
    m_mahasiswa,
    m_kelas_kuliah,
    m_dosen,
    t_dosen_pengajar_kelas_kuliah,
    m_kuesioner,
    t_jawaban_kuisioner,
    t_kuesioner
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuisionerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_kelas_kuliah)
    {
        $id_kelas_kuliah = $id_kelas_kuliah;
        return view('dosen.jurnal_perkuliahan.kuisioner', compact('id_kelas_kuliah'));
    }

    public function data($id_kelas_kuliah)
    {
        $data = t_kuesioner::where('matkul_id', $id_kelas_kuliah)->where('dosen_id', Auth::user()->id_dosen)->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('nama_mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('action',function ($data) {
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Lihat Detail',
                    'class' => 'btn btn-outline-primary btn-xs',
                    "icon" => "fa fa-file",
                    "label" => "Lihat Detail",
                    "route" => route('dosen.kuisioner.show',$data->id),
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $id;
        return view('dosen.jurnal_perkuliahan.detail_kuisioner',compact('id'));
    }

    public function dataDetail($id)
    {
        $data = t_jawaban_kuisioner::where('t_kuesioner_id', $id)->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->rawColumns([''])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }
}
