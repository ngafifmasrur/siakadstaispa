<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\m_jadwal;
use App\Models\m_kelas_kuliah;
use App\Models\m_dosen;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah_aktif;
use App\Models\m_ruang_kelas;
use App\Models\m_tahun_ajaran;
use App\Models\m_semester;
use App\Models\t_krs;
use App\Models\t_jurnal_kuliah;
use App\Models\t_absensi_mahasiswa;
use App\Http\Requests\JadwalRequest;
use Session, DB, Auth, PDF;

class JurnalPerkuliahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun_ajaran = m_tahun_ajaran::where('a_periode_aktif', 1)->pluck('nama_tahun_ajaran', 'id_tahun_ajaran')->prepend('Pilih Tahun Ajaran', NULL);
        $semester = m_semester::pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('dosen.jurnal_perkuliahan.index', compact('tahun_ajaran', 'semester'));
    }

    public function data_index(Request $request)
    {
        $query = m_jadwal::query()
                ->select('m_jadwal.*', 'm_tahun_ajaran.id_tahun_ajaran', 'm_mata_kuliah_aktif.id_semester')
                ->join('m_mata_kuliah_aktif', 'm_mata_kuliah_aktif.id', 'm_jadwal.id_matkul_aktif')
                ->join('m_semester', 'm_semester.id_semester', 'm_mata_kuliah_aktif.id_semester')
                ->join('m_tahun_ajaran', 'm_tahun_ajaran.id_tahun_ajaran', 'm_semester.id_tahun_ajaran')
                ->when($request->semester, function ($query) use ($request) {
                    $query->where('m_mata_kuliah_aktif.id_semester', $request->semester);
                })->when($request->tahun_ajaran, function ($query) use ($request) {
                    $query->where('m_tahun_ajaran.id_tahun_ajaran', $request->tahun_ajaran);
                })->withCount('krs');

        // $krs = t_krs::query();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Isi Jurnal',
                    'class' => 'btn btn-outline-primary btn-xs',
                    "icon" => "fa fa-pencil",
                    "label" => "Isi Jurnal",
                    "route" => route('dosen.jurnal_perkuliahan.jurnal_index', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Cetak Jurnal',
                    'class' => 'btn btn-outline-primary btn-xs',
                    "icon" => "fa fa-print",
                    "label" => "Cetak Jurnal",
                    'attribute' => ['target' => '_blank'],
                    "route" => route('dosen.jurnal_perkuliahan.cetak', $data->id),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('kode_matkul', function ($data) {
                return $data->matkul->matkul->kode_mata_kuliah;
            })
            ->addColumn('nama_matkul', function ($data) {
                return $data->matkul->matkul->nama_mata_kuliah;
            })
            ->addColumn('ruangan', function ($data) {
                return $data->ruangan->nama_ruangan;
            })
            ->addColumn('dosen', function ($data) {
                return $data->dosen->nama_dosen;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('kelas', function ($data) {
                return $data->kelas->nama_kelas_kuliah;
            })
            ->addColumn('jadwal', function ($data) {
                return $data->hari.', '.$data->jam_mulai.' - '.$data->jam_akhir;
            })
            ->addColumn('jumlah_peserta', function ($data) {
                return $data->krs_count;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function jurnal_index($id_jadwal)
    {
        $jadwal = m_jadwal::findOrFail($id_jadwal);
        return view('dosen.jurnal_perkuliahan.jurnal_index', compact('id_jadwal', 'jadwal'));
    }

    public function jurnal_data_index($id_jadwal)
    {
        $query = t_jurnal_kuliah::query()
                ->where('id_jadwal', $id_jadwal)
                ->where('id_dosen', Auth::user()->dosen->id_dosen);

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Ubah',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fa fa-edit",
                    "route" => route('dosen.jurnal_perkuliahan.edit', $data->id),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'button',
                    'tooltip' => 'Hapus',
                    'class' => 'btn btn-outline-danger btn-sm btn_delete',
                    "icon" => "fa fa-trash",
                    'attribute' => [
                        'data-text' => 'Anda yakin ingin menghapus data ini ?',
                    ],
                    "route" => route('dosen.jurnal_perkuliahan.destroy', $data->id),
                ]);
    
                $button .= '</div>';
    
                return $button;
            })
            ->addColumn('prodi', function ($data) {
                return $data->prodi->nama_program_studi;
            })
            ->addColumn('jadwal', function ($data) {
                return $data->jadwal->hari.', '.$data->jadwal->jam_mulai.' - '.$data->jadwal->jam_akhir;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function create($id_jadwal)
    {
        $jadwal = m_jadwal::findOrFail($id_jadwal);
        return view('dosen.jurnal_perkuliahan.create', compact('jadwal'));
    }

    public function edit(t_jurnal_kuliah $jurnal_perkuliahan)
    {
        $jadwal = m_jadwal::findOrFail($jurnal_perkuliahan->id_jadwal);
        $absensi = t_absensi_mahasiswa::where('id_jurnal_kuliah', $jurnal_perkuliahan);
        return view('dosen.jurnal_perkuliahan.edit', compact('jadwal','absensi', 'jurnal_perkuliahan'));
    }

    public function list_mahasiswa($id_jadwal, $id_jurnal = null)
    {
        $query = t_krs::query()
                ->where('id_jadwal', $id_jadwal);
                
        if(!is_null($id_jurnal)) {
            $absensi = t_absensi_mahasiswa::query()->where('id_jurnal_kuliah', $id_jurnal);
        } else {
            $absensi = null;
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('hadir',function ($data) use ($absensi) {
                if(is_null($absensi)) {
                    $button = '<input type="radio" value="Hadir" name="'.$data->mahasiswa->id_mahasiswa.'" checked class="form-checkbox">';
                } else {
                    $status = ($absensi->where('id_mahasiswa', $data->mahasiswa->id_mahasiswa)->first()->status ?? null) == 'Hadir' ? 'checked' : '';
                    $button = '<input type="radio" value="Hadir" name="'.$data->mahasiswa->id_mahasiswa.'" '.$status.' class="form-checkbox">';
                }

                return $button;
            })
            ->addColumn('sakit',function ($data) use ($absensi) {
                if(is_null($absensi)) {
                    $button = '<input type="radio" value="Sakit" name="'.$data->mahasiswa->id_mahasiswa.'" class="form-checkbox">';
                } else {
                    $status = ($absensi->where('id_mahasiswa', $data->mahasiswa->id_mahasiswa)->first()->status ?? null) == 'Sakit' ? 'checked' : '';
                    $button = '<input type="radio" value="Sakit" name="'.$data->mahasiswa->id_mahasiswa.'" '.$status.' class="form-checkbox">';
                }
                return $button;
            })
            ->addColumn('ijin',function ($data) use ($absensi) {
                if(is_null($absensi)) {
                    $button = '<input type="radio" value="Ijin" name="'.$data->mahasiswa->id_mahasiswa.'" class="form-checkbox">';
                } else {
                    $status = ($absensi->where('id_mahasiswa', $data->mahasiswa->id_mahasiswa)->first()->status ?? null) == 'Ijin' ? 'checked' : '';
                    $button = '<input type="radio" value="Ijin" name="'.$data->mahasiswa->id_mahasiswa.'" '.$status.' class="form-checkbox">';
                }
                return $button;
            })
            ->addColumn('alpa',function ($data) use ($absensi) {
                if(is_null($absensi)) {
                    $button = '<input type="radio" value="Alpa" name="'.$data->mahasiswa->id_mahasiswa.'" class="form-checkbox">';
                } else {
                    $status = ($absensi->where('id_mahasiswa', $data->mahasiswa->id_mahasiswa)->first()->status ?? null) == 'Alpa' ? 'checked' : '';
                    $button = '<input type="radio" value="Alpa" name="'.$data->mahasiswa->id_mahasiswa.'" '.$status.' class="form-checkbox">';
                }
                return $button;
            })
            ->addColumn('mahasiswa', function ($data) {
                return $data->mahasiswa->nama_mahasiswa;
            })
            ->addColumn('nim', function ($data) {
                return $data->mahasiswa->nim;
            })
            ->rawColumns(['action','hadir','sakit','ijin','alpa'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pelaksanaan' => 'required|date',
        ]);

        $jadwal = m_jadwal::findOrFail($request->id_jadwal);

        $cek = t_jurnal_kuliah::where('id_jadwal', $jadwal->id)
                ->whereDate('tanggal_pelaksanaan', $request->tanggal_pelaksanaan)
                ->count();

        if($cek > 0) {
            Session::flash('error_msg', 'Jurnal Kuliah dengan Tanggal Pelaksanaan '.$request->tanggal_pelaksanaan.' sudah ada.');
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();

        try{

            $jurnal_kuliah = t_jurnal_kuliah::create([
                'id_prodi' => $jadwal->prodi->id_prodi,
                'id_dosen' => Auth::user()->dosen->id_dosen,
                'id_jadwal' => $jadwal->id,
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'topik' => $request->topik,
            ]);

            // Insert Absensi Siswa
            $absensi = [];
            $list_absensi = $request->except('_token', 'tanggal_pelaksanaan', 'topik', 'id_jadwal', 'nama_matkul', 'kode_matkul', 'dataTables_length');
            foreach ($list_absensi as $id => $status) {
                $absensi[] = [
                    'id_jurnal_kuliah' => $jurnal_kuliah->id,
                    'id_mahasiswa' => $id,
                    'status' => $status,
                ];
            }
            t_absensi_mahasiswa::insert($absensi);

            DB::commit();

            Session::flash('success_msg', 'Jurnal Kuliah Berhasil Disimpan!');
            return redirect()->route('dosen.jurnal_perkuliahan.jurnal_index', $jadwal->id);

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, t_jurnal_kuliah $jurnal_perkuliahan)
    {
        $validated = $request->validate([
            'tanggal_pelaksanaan' => 'required|date',
        ]);

        $jadwal = m_jadwal::findOrFail($request->id_jadwal);
        if($jurnal_perkuliahan->tanggal_pelaksanaan !== $request->tanggal_pelaksanaan) {
            $cek = t_jurnal_kuliah::where('id_jadwal', $request->id_jadwa)
                    ->whereDate('tanggal_pelaksanaan', $request->tanggal_pelaksanaan)
                    ->count();

            if($cek > 0) {
                Session::flash('error_msg', 'Jurnal Kuliah dengan Tanggal Pelaksanaan '.$request->tanggal_pelaksanaan.' sudah ada.');
                return redirect()->back()->withInput();
            }
        }

        DB::beginTransaction();

        try{

            $jurnal_perkuliahan->update([
                'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
                'topik' => $request->topik,
            ]);

            // Update or Insert Absensi Siswa
            $list_absensi = $request->except('_token', 'tanggal_pelaksanaan', 'topik', 'id_jadwal', 'nama_matkul', 'kode_matkul', 'dataTables_length', '_method');
            foreach ($list_absensi as $id => $status) {
                $absensi = t_absensi_mahasiswa::where('id_jurnal_kuliah', $jurnal_perkuliahan->id)
                                    ->where('id_mahasiswa', $id)->first();
                                    
                if($absensi) {
                    $absensi->update(['status' => $status]);
                } else {
                    t_absensi_mahasiswa::create([
                        'id_jurnal_kuliah' => $jurnal_perkuliahan->id,
                        'id_mahasiswa' => $id,
                        'status' => $status,
                    ]);
                }
            }

            DB::commit();

            Session::flash('success_msg', 'Jurnal Kuliah Berhasil Disimpan!');
            // return redirect()->route('dosen.jurnal_perkuliahan.jurnal_index', $jadwal->id);
             return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return dd($e);
        }
    }

    public function destroy(t_jurnal_kuliah $jurnal_perkuliahan)
    {

        if(is_null($jurnal_perkuliahan)){
            abort(404);
        }

        DB::beginTransaction();

        try{
            $jurnal_perkuliahan->absensi()->delete();
            $jurnal_perkuliahan->delete();

            DB::commit();

            Session::flash('success_msg', 'Jurnal Kuliah Berhasil Dihapus!');
            // return redirect()->route('dosen.jurnal_perkuliahan.jurnal_index', $jadwal->id);
             return redirect()->back();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return dd($e);
        }
    }

    public function cetak($id_jadwal)
    { 
        $jadwal = m_jadwal::findOrfail($id_jadwal);
        $matkul = $jadwal->matkul->matkul->nama_mata_kuliah;
        $pdf = PDF::loadView('dosen.jurnal_perkuliahan.cetak_jurnal', compact('jadwal', 'matkul'))->setPaper('a4', 'landscape');
        return $pdf->stream('Jurnal_-_Perkuliahan-_-'.$matkul.'.pdf');    }
}
