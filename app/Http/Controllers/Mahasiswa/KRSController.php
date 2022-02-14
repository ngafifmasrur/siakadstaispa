<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    t_krs,
    t_semester_mahasiswa,
    t_peserta_kelas_kuliah,
    m_global_konfigurasi,
    m_tahun_ajaran,
    m_jadwal,
    m_kelas_kuliah,
    t_riwayat_pendidikan_mahasiswa,
    m_mahasiswa,
    m_mata_kuliah
};
use Session, DB, Auth, PDF;

class KRSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $id_registrasi_mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();
        
        if(!isset($id_registrasi_mahasiswa)){
            Session::flash('error_msg', 'Mahasiswa tidak memiliki semester aktif');
            return view('mahasiswa.krs.index2');
        }
        return view('mahasiswa.krs.index');
    }

    public function data_index(Request $request)
    {

        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $id_registrasi_mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first()->id_registrasi_mahasiswa;

        $kelasKuliah = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->pluck('id_kelas_kuliah')->toArray();
        
        $query = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $kelasKuliah)->get();

        $query->map(function ($item){
            $matkul = m_mata_kuliah::setFilter([
                'filter' => "id_matkul='$item->id_matkul'"
            ])->first();
            $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;

            return $item;
        });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('sks_mata_kuliah',function ($data) {
                return $data->sks_mata_kuliah;
            })
            ->addColumn('nama_dosen',function ($data) {
                return '-';
            })
            ->addColumn('ruangan',function ($data) {
                return '-';
            })
            ->addColumn('action',function ($data) use ($id_registrasi_mahasiswa) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('mahasiswa.krs.destroy', [$data->id_kelas_kuliah, $id_registrasi_mahasiswa]),
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

    public function create()
    {
        return view('mahasiswa.krs.create');
    }

    public function list_kelas_kuliah()
    {

        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;

        $id_registrasi_mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first()->id_registrasi_mahasiswa;

        $id_prodi = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first()->id_prodi;

        // Peserta Kelas
        $pesertaKelas = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_registrasi_mahasiswa='$id_registrasi_mahasiswa'"
        ])->pluck('id_kelas_kuliah')->toArray();

        // Mahasiswa
        $mahasiswa = m_mahasiswa::setFilter([
            'filer' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        // List Kelas Kuliah
        $query = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif' AND id_prodi='$id_prodi'"
        ])->get();

        // Check Jika MHS Sudah Memiliki KRS Matkul Tsb
        $query->map(function ($item) use ($pesertaKelas) {
            if(in_array($item->id_kelas_kuliah, $pesertaKelas)){
                $item['checked'] = 1;
            } else {
                $item['checked'] = 0;
            }
            return $item;
        });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('select_all', function ($data) {
                if($data->checked == true){
                    return '';
                } else {
                    return '<input type="checkbox"' .' name="kelas_kuliah[]" value="'. $data->id_kelas_kuliah .'">';
                }
            })
            ->addColumn('sks_mata_kuliah',function ($data) {
                // return $data->mata_kuliah->sks_mata_kuliah;
                return '-';
            })
            ->addColumn('nama_dosen',function ($data) {
                return '-';
            })
            ->addColumn('ruangan',function ($data) {
                return '-';
            })
            ->addColumn('kapasitas',function ($data) {
                return '-';
            })
            ->rawColumns(['select_all'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function store(Request $request)
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $id_registrasi_mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first()->id_registrasi_mahasiswa;

        $kelas_kuliah = $request->except('_token', '_method');

        foreach ($request->kelas_kuliah as $id_kelas_kuliah) {
            $records = [
                "id_registrasi_mahasiswa" => $id_registrasi_mahasiswa,
                "id_kelas_kuliah" => $id_kelas_kuliah
            ];
        
            $results[] = InsertDataFeeder('InsertPesertaKelasKuliah', $records, 'GetPesertaKelasKuliah');
        }

        return redirect()->back()->with('results', $results);

    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_kelas_kuliah, $id_registrasi_mahasiswa)
    {
        $key = [
            'id_kelas_kuliah' => $id_kelas_kuliah,
            'id_registrasi_mahasiswa' => $id_registrasi_mahasiswa
        ];
        
        $result = DeleteDataFeeder('DeletePesertaKelasKuliah', $key, 'GetPesertaKelasKuliah');

        if($result['error_code'] !== '0') {
            Session::flash('error_msg', $result['error_desc']);
            return back()->withInput();
        }
       
        Session::flash('success_msg', 'Berhasil Dihapus');
        return redirect()->back();
    }

    public function cetak(Request $request)
    { 
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $nama_semester_aktif = m_global_konfigurasi::first()->nama_semester_aktif;

        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        $kelasKuliah = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->pluck('id_kelas_kuliah')->toArray();
        
        $krs = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $kelasKuliah)->get();

        $krs->map(function ($item){
            $matkul = m_mata_kuliah::setFilter([
                'filter' => "id_matkul='$item->id_matkul'"
            ])->first();
            $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
            return $item;
        });
        
        $pdf = PDF::loadView('mahasiswa.krs.cetak', compact('riwayat_pendidikan', 'krs', 'nama_semester_aktif'))->setPaper('a4', 'landscape');
        return $pdf->stream('KRS_Online-_-'.$riwayat_pendidikan->nama_mahasiswa.'.pdf');    
    }

}
