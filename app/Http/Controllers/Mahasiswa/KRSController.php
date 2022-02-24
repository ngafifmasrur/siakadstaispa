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
    m_mata_kuliah,
    t_krs_mahasiswa,
    t_dosen_wali_mahasiswa,
    m_global_konfigurasi_prodi,
    t_matkul_kurikulum,
    t_dosen_pengajar_kelas_kuliah,
    m_dosen
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

        $kelasKuliah = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->pluck('id_kelas_kuliah')->toArray();
        
        $jumlah_kelas = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $kelasKuliah)->count();


        $status_krs = t_krs_mahasiswa::where('id_registrasi_mahasiswa', $id_registrasi_mahasiswa->id_registrasi_mahasiswa)->first();
        $status_krs_prodi = m_global_konfigurasi_prodi::where('id_prodi', $id_registrasi_mahasiswa->id_prodi)->first()->buka_krs;

        return view('mahasiswa.krs.index', compact('status_krs', 'status_krs_prodi', 'id_registrasi_mahasiswa', 'jumlah_kelas'));
    }

    public function data_index(Request $request)
    {

        // Check Pengajuan KRS 
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        $status_krs = t_krs_mahasiswa::where('id_registrasi_mahasiswa', $mahasiswa->id_registrasi_mahasiswa)->first();
        $status_krs_prodi = m_global_konfigurasi_prodi::where('id_prodi', $mahasiswa->id_prodi)->first()->buka_krs;

        if((isset($status_krs) && ($status_krs->status == 'Diajukan' || $status_krs->status == 'Diverifikasi')) || $status_krs_prodi == false) {
            $check_status_krs = 'disabled';
        } else {
            $check_status_krs = 'enabled';
        }
        // END Check Pengajuan KRS 

        $kelasKuliah = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->pluck('id_kelas_kuliah')->toArray();
        
        $dosen = t_dosen_pengajar_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->get();

        $matkul_kurikulum = t_matkul_kurikulum::setFilter([
            'filter' => "id_semester='$semester_aktif' AND id_prodi='$mahasiswa->id_prodi'"
        ])->select('id_matkul', 'semester')->get();

        $query = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_kelas_kuliah', $kelasKuliah)->get();

        $query->map(function ($item) use ($dosen, $matkul_kurikulum) {
            // Jadwal
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();
            if(isset($jadwal)){
                $item['hari'] = $jadwal->hari;
                $item['jam_mulai'] = $jadwal->jam_mulai;
                $item['jam_akhir'] = $jadwal->jam_akhir;
            }
            $item['smt'] = $matkul_kurikulum->where('id_matkul', $item->id_matkul)->first()->semester ?? '-';
            $item['nama_dosen'] = $dosen->where('id_kelas_kuliah', $item->id_kelas_kuliah)->map(function($q) {
                return ('- '.$q->nama_dosen);
            })->implode('<br>');
        });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('jadwal',function ($data) {
                if($data->hari && $data->jam_mulai && $data->jam_akhir) {
                    return $data->hari.', '.$data->jam_mulai.'-'.$data->jam_akhir;
                }

                return '-';
            })
            ->addColumn('action',function ($data) use ($mahasiswa, $check_status_krs) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                        ''.$check_status_krs == 'disabled' ? 'disabled' : 'enabled'.'' => $check_status_krs,

                    ],
                    "route" => route('mahasiswa.krs.destroy', [$data->id_kelas_kuliah, $mahasiswa->id_registrasi_mahasiswa]),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('jadwal',function ($data) {
                if($data->hari && $data->jam_mulai && $data->jam_akhir) {
                    return $data->hari.', '.$data->jam_mulai.'-'.$data->jam_akhir;
                }

                return '-';
            })
            ->rawColumns(['action', 'ajukan'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function create()
    {
        // Check Pengajuan KRS 
        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        $status_krs = t_krs_mahasiswa::where('id_registrasi_mahasiswa', $mahasiswa->id_registrasi_mahasiswa)->first();
        $status_krs_prodi = m_global_konfigurasi_prodi::where('id_prodi', $mahasiswa->id_prodi)->first()->buka_krs;

        if(isset($status_krs)){
            if($status_krs->status == 'Diverifikasi') {
                Session::flash('error_msg', 'Sudah pernah mengajukan KRS, Tidak dapat mengubah KRS');
                return redirect()->route('mahasiswa.krs.index')->withInput();
            }
        }

        if($status_krs_prodi == false) {
            Session::flash('error_msg', 'KRS untuk program studi ini belum dibuka');
            return redirect()->route('mahasiswa.krs.index')->withInput();
        }
        // END Check Pengajuan KRS

        // List Semester
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $semester = [];
        for ($smt=1; $smt <= 8; $smt++) {
            $semester[$smt] = 'Semester '.$smt;
        }
 
        return view('mahasiswa.krs.create', compact('semester'));
    }

    public function list_kelas_kuliah(Request $request)
    {

        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;

        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        // Peserta Kelas
        $pesertaKelas = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_registrasi_mahasiswa='$riwayat_pendidikan->id_registrasi_mahasiswa'"
        ])->pluck('id_kelas_kuliah')->toArray();

        // Mahasiswa
        $mahasiswa = m_mahasiswa::setFilter([
            'filer' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        // List Kelas Kuliah
        $matkul_kurikulum = t_matkul_kurikulum::setFilter([
            'filter' => "id_semester='$semester_aktif' AND id_prodi='$riwayat_pendidikan->id_prodi' AND semester='$request->semester'"
        ])->pluck('id_matkul')->toArray();

        $matkul = t_matkul_kurikulum::setFilter([
            'filter' => "id_semester='$semester_aktif' AND id_prodi='$riwayat_pendidikan->id_prodi' AND semester='$request->semester'"
        ])->select('id_matkul', 'semester')->get();

        $query = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'"
        ])->whereIn('id_matkul', $matkul_kurikulum)->get();

        // Check Jika MHS Sudah Memiliki KRS Matkul Tsb
        $query->map(function ($item) use ($pesertaKelas, $matkul) {
            if(in_array($item->id_kelas_kuliah, $pesertaKelas)){
                $item['checked'] = 1;
            } else {
                $item['checked'] = 0;
            }
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();
            $item['hari'] = $jadwal->hari ?? null;
            $item['jam_mulai'] = $jadwal->jam_mulai ?? null;
            $item['jam_akhir'] = $jadwal->jam_akhir ?? null;
            $item['smt'] = $matkul->where('id_matkul', $item->id_matkul)->first()->semester ?? '-';
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
            ->addColumn('jadwal',function ($data) {
                if($data->hari && $data->jam_mulai && $data->jam_akhir) {
                    return $data->hari.', '.$data->jam_mulai.'-'.$data->jam_akhir;
                }

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
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kulaih)->first();
            $item['hari'] = $item->hari;
            $item['jam_mulai'] = $item->jam_mulai;
            $item['jam_akhir'] = $item->jam_akhir;
            $item['sks_mata_kuliah'] = $matkul->sks_mata_kuliah;
            return $item;
        });

        // Dosen Pembimbing
        $dosen_wali = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $riwayat_pendidikan->id_registrasi_mahasiswa)->first();
        if(isset($dosen_wali)) {
            $dosen = m_dosen::setFilter([
                'filter' => "id_dosen='$dosen_wali->id_dosen'"
            ])->first()->nama_dosen;
        } else {
            $dosen = '-';
        }
        
        $pdf = PDF::loadView('mahasiswa.krs.cetak', compact('riwayat_pendidikan', 'krs', 'nama_semester_aktif', 'dosen'))->setPaper('a4', 'landscape');
        return $pdf->stream('KRS_Online-_-'.$riwayat_pendidikan->nama_mahasiswa.'.pdf');    
    }

    public function ajukan($id_registrasi_mahasiswa)
    {

        $mahasiswa = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();

        $status_krs = t_krs_mahasiswa::where('id_registrasi_mahasiswa', $mahasiswa->id_registrasi_mahasiswa)->first();
        $status_krs_prodi = m_global_konfigurasi_prodi::where('id_prodi', $mahasiswa->id_prodi)->first()->buka_krs;

        DB::beginTransaction();

        try{

            if(isset($status_krs) && ($status_krs->status == 'Diajukan' || $status_krs->status == 'Diverifikasi')) {
                Session::flash('error_msg', 'Sudah pernah mengajukan');
                return redirect()->route('mahasiswa.krs.index')->withInput();
            }

            if($status_krs_prodi == false) {
                Session::flash('error_msg', 'KRS untuk program studi ini belum dibuka');
                return redirect()->route('mahasiswa.krs.index')->withInput();
            }

            $check = t_krs_mahasiswa::where('id_registrasi_mahasiswa', $id_registrasi_mahasiswa)->first();
            if(isset($check)) {
                $check->update([
                    'status' => 'Diajukan',
                ]);
            } else {
                t_krs_mahasiswa::create([
                    'id_registrasi_mahasiswa' => $mahasiswa->id_registrasi_mahasiswa,
                    'status' => 'Diajukan',
                ]);
            }

            
            DB::commit();

            Session::flash('success_msg', 'Berhasil Diajukan');
            return redirect()->route('mahasiswa.krs.index');

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return back()->withInput();
        }
    }

}
