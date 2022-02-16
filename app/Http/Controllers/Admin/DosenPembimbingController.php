<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_dosen_pembimbing,
    t_riwayat_pendidikan_mahasiswa,
    ref_kategori_kegiatan,
    m_aktivitas,
    m_dosen
};
use Session, DB;


class DosenPembimbingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen = m_dosen::pluck('nama_dosen', 'id_dosen')->prepend('Pilih Dosen', NULL);
        $aktivitas = m_aktivitas::pluck('judul', 'id_aktivitas')->prepend('Pilih Aktivitas', NULL);
        $kategori_kegiatan = ref_kategori_kegiatan::pluck('nama_kategori_kegiatan', 'id_kategori_kegiatan')->prepend('Pilih Kategori Kegiatan', NULL);
        return view('admin.dosen_pembimbing.index', compact('dosen', 'aktivitas', 'kategori_kegiatan'));
    }

    public function data_index(Request $request)
    {
        $query = t_dosen_pembimbing::all();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.dosen_pembimbing.destroy', $data->id_bimbing_mahasiswa),
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
        $result = InsertDataFeeder('InsertDosenPembimbing', $records, 'GetDosenPembimbing');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Ditambah');
        return redirect()->back();
    }

    public function destroy(Request $request, $dosen_pembimbing)
    {
        $key = [
            'id_bimbing_mahasiswa' => $dosen_pembimbing
        ];
        
        $result = DeleteDataFeeder('DeleteDosenPembimbing', $key, 'GetDosenPembimbing');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Dihapus');
        return redirect()->back();
    }
}
