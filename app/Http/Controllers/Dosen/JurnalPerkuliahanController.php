<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
use App\Models\t_dosen_pengajar_kelas_kuliah;
use App\Models\t_peserta_kelas_kuliah;
use App\Http\Requests\JadwalRequest;
use App\Models\m_global_konfigurasi;
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
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::orderBy('nama_semester','DESC')->pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('dosen.jurnal_perkuliahan.index', compact('prodi', 'semester'));
    }

    public function data_index(Request $request)
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $kelasKuliah = t_dosen_pengajar_kelas_kuliah::setFilter([
                        'filter' => "id_dosen='".Auth::user()->id_dosen."'"
                    ])
                    ->where('id_dosen', Auth::user()->id_dosen)
                    ->pluck('id_kelas_kuliah')->toArray();

        $query = m_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_aktif'",
        ])
        ->whereIn('id_kelas_kuliah', $kelasKuliah)
        ->when($request->prodi, function($q) use ($request){
            $q->where('id_prodi', $request->prodi);
        })->get();

        $query->map(function ($item){
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();
            $item['hari'] = $jadwal->hari ?? null;
            $item['jam_mulai'] = $jadwal->jam_mulai ?? null;
            $item['jam_akhir'] = $jadwal->jam_akhir ?? null;

            return $item;
        });

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('jadwal',function ($data) {
                if($data->hari && $data->jam_mulai && $data->jam_akhir) {
                    return $data->hari.', '.$data->jam_mulai.'-'.$data->jam_akhir;
                }

                return '-';
            })
            ->addColumn('jumlah_mahasiswa', function ($data) {
                return $data->jumlah_mahasiswa;
            })
            ->addColumn('action',function ($data) {
           
                $button = '<div class="btn-group" role="group" aria-label="Basic example">';
    
                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Isi Jurnal',
                    'class' => 'btn btn-outline-primary btn-xs',
                    "icon" => "fa fa-pencil",
                    "label" => "Isi Jurnal",
                    "route" => route('dosen.jurnal_perkuliahan.jurnal_index', $data->id_kelas_kuliah),
                ]);
    
                $button .= view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Cetak Jurnal',
                    'class' => 'btn btn-outline-primary btn-xs',
                    "icon" => "fa fa-print",
                    "label" => "Cetak Jurnal",
                    'attribute' => ['target' => '_blank'],
                    "route" => route('dosen.jurnal_perkuliahan.cetak', $data->id_kelas_kuliah),
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

    public function jurnal_index($id_kelas_kuliah)
    {

        $jadwal = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->first();
        $kelas_kuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'"
        ])->first();

        return view('dosen.jurnal_perkuliahan.jurnal_index', compact('jadwal', 'kelas_kuliah'));
    }

    public function jurnal_data_index($id_kelas_kuliah)
    {
        $query = t_jurnal_kuliah::query()
                ->where('id_kelas_kuliah', $id_kelas_kuliah)
                ->where('id_dosen', Auth::user()->id_dosen)
                ->orderBy('pertemuan_ke', 'ASC')->get();

        $query->map(function ($item){
            $kelas_kuliah = m_kelas_kuliah::setFilter([
                'filter' => "id_kelas_kuliah='$item->id_kelas_kuliah'"
            ])->first();
            $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();

            $item['kode_mata_kuliah'] = $kelas_kuliah->kode_mata_kuliah ?? null;
            $item['nama_mata_kuliah'] = $kelas_kuliah->nama_mata_kuliah ?? null;
            $item['nama_kelas_kuliah'] = $kelas_kuliah->nama_kelas_kuliah ?? null;
            $item['hari'] = $jadwal->hari ?? null;
            $item['jam_mulai'] = $jadwal->jam_mulai ?? null;
            $item['jam_akhir'] = $jadwal->jam_akhir ?? null;
            $item['link_zoom'] = $jadwal->link_zoom ?? '-';
            return $item;
        });

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
            ->addColumn('jadwal',function ($data) {
                if($data->hari && $data->jam_mulai && $data->jam_akhir) {
                    return $data->hari.', '.$data->jam_mulai.'-'.$data->jam_akhir;
                }

                return '-';
            })
            ->addColumn('absen_mahasiswa',function ($data) {
                $link = route('mahasiswa.absen.index', $data->id);
                $qrcode = '<div class="align-items-center">
                <span>'.QrCode::size(100)->generate($link).'</span>
                <a class="btn_share" href="#"
                data-link_absensi="'.$link.'"
                data-link_zoom="'.$data->link_zoom.'"
                data-tanggal_pelaksanaan="'.$data->tanggal_pelaksanaan.'"
                data-kode_matkul="'.$data->kode_mata_kuliah.'"
                data-nama_matkul="'.$data->nama_mata_kuliah.'"
                data-nama_kelas="'.$data->nama_kelas_kuliah.'">
                    <i class="fa fa-share text-success ml-2"></i>
                </a>
                </div>';
                return $qrcode;
            })
            ->rawColumns(['action', 'absen_mahasiswa'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function create($id_kelas_kuliah)
    {
        $jadwal = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->first();
        return view('dosen.jurnal_perkuliahan.create', compact('jadwal'));
    }

    public function edit(t_jurnal_kuliah $jurnal_perkuliahan)
    {
        $jadwal = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $jurnal_perkuliahan->id_kelas_kuliah)->first();
        $absensi = t_absensi_mahasiswa::where('id_jurnal_kuliah', $jurnal_perkuliahan);
        return view('dosen.jurnal_perkuliahan.edit', compact('jadwal','absensi', 'jurnal_perkuliahan'));
    }

    public function list_mahasiswa(Request $request, $id_kelas_kuliah, $id_jurnal = null)
    {
        $query = t_peserta_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->orderBy('nama_mahasiswa', 'ASC')->get();

        if(!is_null($id_jurnal)) {
            $absensi = t_absensi_mahasiswa::where('id_jurnal_kuliah', $id_jurnal)->get();
        } else {
            $absensi = null;
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('hadir',function ($data) use ($absensi) {
                if(is_null($absensi)) {
                    $button = '<input type="radio" value="Hadir" name="'.$data->id_mahasiswa.'" checked class="form-checkbox">';
                } else {
                    $status = ($absensi->where('id_mahasiswa', $data->id_mahasiswa)->first()->status ?? null) == 'Hadir' ? 'checked' : '';
                    $button = '<input type="radio" value="Hadir" name="'.$data->id_mahasiswa.'" '.$status.' class="form-checkbox">';
                }

                return $button;
            })
            ->addColumn('sakit',function ($data) use ($absensi) {
                if(is_null($absensi)) {
                    $button = '<input type="radio" value="Sakit" name="'.$data->id_mahasiswa.'" class="form-checkbox">';
                } else {
                    $status = ($absensi->where('id_mahasiswa', $data->id_mahasiswa)->first()->status ?? null) == 'Sakit' ? 'checked' : '';
                    $button = '<input type="radio" value="Sakit" name="'.$data->id_mahasiswa.'" '.$status.' class="form-checkbox">';
                }
                return $button;
            })
            ->addColumn('ijin',function ($data) use ($absensi) {
                if(is_null($absensi)) {
                    $button = '<input type="radio" value="Ijin" name="'.$data->id_mahasiswa.'" class="form-checkbox">';
                } else {
                    $status = ($absensi->where('id_mahasiswa', $data->id_mahasiswa)->first()->status ?? null) == 'Ijin' ? 'checked' : '';
                    $button = '<input type="radio" value="Ijin" name="'.$data->id_mahasiswa.'" '.$status.' class="form-checkbox">';
                }
                return $button;
            })
            ->addColumn('alpa',function ($data) use ($absensi) {
                if(is_null($absensi)) {
                    $button = '<input type="radio" value="Alpa" name="'.$data->id_mahasiswa.'" class="form-checkbox">';
                } else {
                    $status = ($absensi->where('id_mahasiswa', $data->id_mahasiswa)->first()->status ?? null) == 'Alpa' ? 'checked' : '';
                    $button = '<input type="radio" value="Alpa" name="'.$data->id_mahasiswa.'" '.$status.' class="form-checkbox">';
                }
                return $button;
            })
            ->addColumn('mahasiswa', function ($data) {
                return $data->nama_mahasiswa;
            })
            ->addColumn('nim', function ($data) {
                return $data->nim;
            })
            ->rawColumns(['action','hadir','sakit','ijin', 'alpa'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pelaksanaan' => 'required',
            'pertemuan_ke' => 'integer|required',
            'status_dosen' => 'required|in:Sakit,Hadir,Alpa,Ijin'
        ]);

        $tanggal = date('Y-m-d', strtotime($request->tanggal_pelaksanaan));

        $jadwal = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $request->id_kelas_kuliah)->first();
        $kelas_kuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$jadwal->id_kelas_kuliah'",
        ])->first();

        $cek = t_jurnal_kuliah::where('id_kelas_kuliah', $jadwal->id_kelas_kuliah)
                ->whereDate('tanggal_pelaksanaan', $tanggal)
                ->count();

        if($cek > 0) {
            Session::flash('error_msg', 'Jurnal Kuliah dengan Tanggal Pelaksanaan '.$tanggal.' sudah ada.');
            return redirect()->back()->withInput();
        }

        $cek_pertemuan = t_jurnal_kuliah::where('id_kelas_kuliah', $jadwal->id_kelas_kuliah)
        ->where('pertemuan_ke', $request->pertemuan_ke)
        ->count();

        if($cek_pertemuan > 0) {
            Session::flash('error_msg', 'Jurnal Kuliah dengan Pertemuan ke '.$request->pertemuan_ke.' sudah ada.');
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();

        try{

            $jurnal_kuliah = t_jurnal_kuliah::create([
                'id_prodi' => $kelas_kuliah->id_prodi,
                'id_dosen' => Auth::user()->id_dosen,
                'id_kelas_kuliah' => $jadwal->id_kelas_kuliah,
                'tanggal_pelaksanaan' => $tanggal,
                'topik' => $request->topik,
                'pertemuan_ke' => $request->pertemuan_ke,
                'status' => $request->status_dosen,
            ]);

            // Insert Absensi Siswa
            $absensi = [];
            $list_absensi = $request->except('_token', 'tanggal_pelaksanaan', 'topik', 'id_kelas_kuliah', 'nama_matkul', 'kode_matkul', 'dataTables_length', 'status_dosen', 'pertemuan_ke');
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
            return redirect()->route('dosen.jurnal_perkuliahan.jurnal_index', $jadwal->id_kelas_kuliah);

        }catch(\Exception $e){

            DB::rollback();
            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, t_jurnal_kuliah $jurnal_perkuliahan)
    {
        $validated = $request->validate([
            'tanggal_pelaksanaan' => 'required',
            'pertemuan_ke' => 'integer|required',
            'status_dosen' => 'required|in:Sakit,Hadir,Alpa,Ijin'
        ]);

        $tanggal = date('Y-m-d', strtotime($request->tanggal_pelaksanaan));

        $jadwal = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $request->id_kelas_kuliah)->first();
        if($jurnal_perkuliahan->tanggal_pelaksanaan !== $tanggal) {
            $cek = t_jurnal_kuliah::where('id_kelas_kuliah', $request->id_kelas_kuliah)
                    ->whereDate('tanggal_pelaksanaan', $tanggal)
                    ->where('id', '!=', $jurnal_perkuliahan->id)
                    ->count();

            if($cek > 0) {
                Session::flash('error_msg', 'Jurnal Kuliah dengan Tanggal Pelaksanaan '.$tanggal.' sudah ada.');
                return redirect()->back()->withInput();
            }
        }

        if($jurnal_perkuliahan->pertemuan_ke !== $request->pertemuan_ke) {
            $cek_pertemuan = t_jurnal_kuliah::where('id_kelas_kuliah', $jadwal->id_kelas_kuliah)
            ->where('pertemuan_ke', $request->pertemuan_ke)
            ->where('id', '!=', $jurnal_perkuliahan->id)
            ->count();

            if($cek_pertemuan > 0) {
                Session::flash('error_msg', 'Jurnal Kuliah dengan Pertemuan ke '.$request->pertemuan_ke.' sudah ada.');
                return redirect()->back()->withInput();
            }
        }

        DB::beginTransaction();

        try{

            $jurnal_perkuliahan->update([
                'tanggal_pelaksanaan' => $tanggal,
                'topik' => $request->topik,
                'pertemuan_ke' => $request->pertemuan_ke,
                'status' => $request->status_dosen,
            ]);

            // Update or Insert Absensi Siswa
            $list_absensi = $request->except('_token', 'tanggal_pelaksanaan', 'topik', 'id_jadwal', 'nama_matkul', 'kode_matkul', 'dataTables_length', '_method', 'id_kelas_kuliah', 'status_dosen', 'pertemuan_ke');
            foreach ($list_absensi as $id => $status) {
                $absensi = t_absensi_mahasiswa::where('id_jurnal_kuliah', $jurnal_perkuliahan->id)
                                    ->where('id_mahasiswa', $id)->first();
                                    
                if(isset($absensi)) {
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
            return redirect()->back()->withInput();

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return redirect()->back();
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

    public function cetak($id_kelas_kuliah)
    { 
        $jadwal = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->first();
        $matkul = $jadwal->kelas_kuliah->nama_mata_kuliah;
        $jurnal = t_jurnal_kuliah::where('id_kelas_kuliah', $id_kelas_kuliah)->get();
        $pdf = PDF::loadView('dosen.jurnal_perkuliahan.cetak_jurnal', compact('jadwal', 'matkul', 'jurnal'))->setPaper('a4', 'landscape');
        return $pdf->stream('Jurnal_-_Perkuliahan-_-'.$matkul.'.pdf');    }
}
