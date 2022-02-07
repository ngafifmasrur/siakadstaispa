<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    m_aktivitas,
    m_jenis_aktivitas,
    m_program_studi,
    m_semester,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Session, DB;

class AktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisAktivitas  = m_jenis_aktivitas::pluck('nama_jenis_aktivitas_mahasiswa', 'id_jenis_aktivitas_mahasiswa');
        $prodi  = m_program_studi::pluck('nama_program_studi', 'id_prodi');
        $semester  = m_semester::pluck('nama_semester', 'id_semester');

        return view('admin.aktivitas.index', compact('jenisAktivitas', 'prodi', 'semester'));
    }

    public function data_index(Request $request)
    {
        $query = m_aktivitas::with('jenis_aktivitas', 'semester', 'prodi', 'anggota');

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
                        'data-id_jenis_aktivitas' => $data->id_jenis_aktivitas,
                        'data-id_prodi' => $data->id_prodi,
                        'data-id_semester' => $data->id_semester,
                        'data-judul' => $data->judul,
                        'data-keterangan' => $data->keterangan,
                        'data-lokasi' => $data->lokasi,
                        'data-sk_tugas' => $data->sk_tugas,
                    ],
                    "route" => route('admin.aktivitas.update', $data->id_aktivitas),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('admin.aktivitas.destroy', $data->id_aktivitas),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('jenis_aktivitas', function ($data) {
                return $data->jenis_aktivitas->nama_jenis_aktivitas_mahasiswa ?? '';
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('semester', function ($data) {
                return $data->semester->nama_semester;
            })
            ->addColumn('anggota', function ($data) {
                return view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Lihat',
                    'class' => 'btn btn-primary btn-sm',
                    'label' => $data->anggota->where('id_aktivitas', $data->id_aktivitas)->count(),
                    "route" => route('admin.anggota_aktivitas.index', $data->id_aktivitas),
                ]);
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function show(m_aktivitas $aktivitas)
    {

        abort_if(! $aktivitas, 404);

        return response()->json([
			'code'    => 200,
			'message' => 'success',
			'data'    => $aktivitas
		], 200);
    }

    public function store(Request $request)
    {
        $records = $request->all();
        $result = InsertDataFeeder('InsertAktivitasMahasiswa', $records);

        return $result;
    }

    public function update(Request $request, $aktivitas)
    {
        $records = $request->all();
        $key = [
            'id_aktivitas' => $aktivitas
        ];

        $result = UpdateDataFeeder('UpdateAktivitasMahasiswa', $key, $records);

        return $result;
    }

    public function destroy(Request $request, $aktivitas)
    {
        $key = [
            'id_aktivitas' => $aktivitas
        ];
        
        $result = DeleteDataFeeder('DeleteAktivitasMahasiswa', $key);

        return $result;
    }
}
