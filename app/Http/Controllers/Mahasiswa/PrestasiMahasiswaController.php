<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\{
    m_jenis_prestasi,
    m_prestasi_mahasiswa,
    m_tingkat_prestasi,
    t_riwayat_pendidikan_mahasiswa
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB;

class PrestasiMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisPrestasi  = m_jenis_prestasi::pluck('nama_jenis_prestasi', 'id_jenis_prestasi');
        $tingkatPrestasi  = m_tingkat_prestasi::pluck('nama_tingkat_prestasi', 'id_tingkat_prestasi');

        return view('mahasiswa.prestasi.index', compact('jenisPrestasi', 'tingkatPrestasi'));
    }

    public function data_index(Request $request)
    {
        $query = m_prestasi_mahasiswa::with('jenis_prestasi')
            ->where('id_mahasiswa', Auth::user()->id_mahasiswa);

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm btn_edit',
                    "icon" => "fa fa-edit",
                    'attribute' => [
                        'data-id_jenis_prestasi' => $data->id_jenis_prestasi,
                        'data-id_tingkat_prestasi' => $data->id_tingkat_prestasi,
                        'data-nama_prestasi' => $data->nama_prestasi,
                        'data-tahun_prestasi' => $data->tahun_prestasi,
                        'data-penyelenggara' => $data->penyelenggara,
                        'data-peringkat' => $data->peringkat,
                    ],
                    "route" => route('mahasiswa.prestasi_mahasiswa.update', $data->id_prestasi),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('mahasiswa.prestasi_mahasiswa.destroy', $data->id_prestasi),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('jenis_prestasi', function ($data) {
                return $data->jenis_prestasi->nama_jenis_prestasi;
            })
            ->addColumn('tingkat_prestasi', function ($data) {
                return $data->tingkat_prestasi->nama_tingkat_prestasi;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function show(t_riwayat_pendidikan_mahasiswa $prestasi_mahasiswa)
    {

        abort_if(! $prestasi_mahasiswa, 404);

        return response()->json([
			'code'    => 200,
			'message' => 'success',
			'data'    => $prestasi_mahasiswa
		], 200);
    }

    public function store(Request $request)
    {
        $records = $request->all();
        $records['id_mahasiswa'] = Auth::user()->id_mahasiswa;
        $result = InsertDataFeeder('InsertPrestasiMahasiswa', $records);

        return $result;
    }

    public function update(Request $request, $prestasi_mahasiswa)
    {
        $records = $request->all();
        $key = [
            'id_prestasi' => $prestasi_mahasiswa
        ];

        $result = UpdateDataFeeder('UpdatePrestasiMahasiswa', $key, $records);

        return $result;
    }

    public function destroy(Request $request, $prestasi_mahasiswa)
    {
        $key = [
            'id_prestasi' => $prestasi_mahasiswa
        ];
        
        $result = DeleteDataFeeder('DeletePrestasiMahasiswa', $key);

        return $result;
    }
}
