<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    m_aktivitas,
    m_anggota_aktifitas_mahasiswa,
    m_mahasiswa
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB;

class AnggotaAktivitasController extends Controller
{
    protected $jenisPeran = [
        '1' => 'Ketua',
        '2' => 'Anggota',
        '3' => 'Personal'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($aktivitas)
    {
        $mahasiswa = m_mahasiswa::pluck('nama_mahasiswa', 'id_mahasiswa');
        $jenisPeran = $this->jenisPeran;

        return view('admin.anggota_aktivitas.index', compact('aktivitas', 'jenisPeran', 'mahasiswa'));
    }

    public function data_index(Request $request, $aktivitas)
    {
        $query = m_anggota_aktifitas_mahasiswa::with('aktivitas', 'mahasiswa')
            ->where('id_anggota', $aktivitas);

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
                        'data-id_aktivitas' => $data->id_aktivitas,
                        'data-id_registrasi_mahasiswa' => $data->id_registrasi_mahasiswa,
                        'data-jenis_peran' => $data->jenis_peran
                    ],
                    "route" => route('admin.anggota_aktivitas.update', $data->id_anggota),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.anggota_aktivitas.destroy', $data->id_anggota),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('judul', function ($data) {
                return $data->aktivitas->judul;
            })
            ->addColumn('nim', function ($data) {
                return $data->mahasiswa->nim;
            })
            ->addColumn('mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->editColumn('jenis_peran', function ($data) {
                return $this->jenisPeran[(int) $data->jenis_peran] ?? '';
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function show(m_anggota_aktifitas_mahasiswa $anggota_aktivitas)
    {

        abort_if(! $anggota_aktivitas, 404);

        return response()->json([
			'code'    => 200,
			'message' => 'success',
			'data'    => $anggota_aktivitas
		], 200);
    }

    public function store(Request $request)
    {
        $records = $request->all();
        $result = InsertDataFeeder('InsertAnggotaAktivitasMahasiswa', $records);

        return $result;
    }

    public function update(Request $request, $anggota_aktivitas)
    {
        $records = $request->all();
        $key = [
            'id_anggota' => $anggota_aktivitas
        ];

        $result = UpdateDataFeeder('UpdateAnggotaAktivitasMahasiswa', $key, $records);

        return $result;
    }

    public function destroy(Request $request, $anggota_aktivitas)
    {
        $key = [
            'id_anggota' => $anggota_aktivitas
        ];
        
        $result = DeleteDataFeeder('DeleteAnggotaAktivitasMahasiswa', $key);

        return $result;
    }
}
