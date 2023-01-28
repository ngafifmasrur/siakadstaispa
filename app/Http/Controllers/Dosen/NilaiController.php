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
use App\Models\m_skala_nilai_prodi;
use App\Models\m_semester;
use App\Models\t_krs;
use App\Models\t_dosen_pengajar_kelas_kuliah;
use App\Models\t_peserta_kelas_kuliah;
use App\Models\t_detail_nilai_perkuliahan_kelas;
use App\Models\m_global_konfigurasi;
use App\Http\Requests\JadwalRequest;
use App\Exports\NilaiExport;
use App\Exports\TemplateNilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Session, DB, Auth;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = m_program_studi::pluck('nama_program_studi', 'id_prodi')->prepend('Pilih Program Studi', NULL);
        $semester = m_semester::orderBy('nama_semester', 'desc')->pluck('nama_semester', 'id_semester')->prepend('Pilih Semester', NULL);
        return view('dosen.pengisian_nilai.index', compact('prodi', 'semester'));
    }

    public function data_index(Request $request)
    {
        $semester_nilai = m_global_konfigurasi::first()->id_semester_nilai;
        $kelasKuliah = t_dosen_pengajar_kelas_kuliah::setFilter([
            'filter' => "id_semester='$semester_nilai'"
        ])
        ->where('id_dosen', Auth::user()->id_dosen)
        ->when($request->prodi, function($q) use ($request){
            $q->where('id_prodi', $request->prodi);
        })
        ->pluck('id_kelas_kuliah')->toArray();

        $query = m_kelas_kuliah::whereIn('id_kelas_kuliah', $kelasKuliah)
        ->when($request->prodi, function($q) use ($request){
            $q->where('id_prodi', $request->prodi);
        })->get();

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('nama_semester', function ($data) {
                return $data->nama_semester;
            })
            ->addColumn('nama_program_studi', function ($data) {
                return $data->nama_program_studi;
            })
            ->addColumn('nama_mata_kuliah', function ($data) {
                return $data->nama_mata_kuliah;
            })
            ->addColumn('nama_kelas_kuliah', function ($data) {
                return $data->nama_kelas_kuliah;
            })
            ->addColumn('ruang', function ($data) {
                return  $data->ruangan ?? '-';
            })
            ->addColumn('hari', function ($data) {
                return $data->hari ?? '-';
            })
            ->addColumn('waktu', function ($data) {
                return $data->jam_mulai ?? ''.' - '.$data->jam_akhir ?? '';
            })
            ->addColumn('jumlah_mahasiswa', function ($data) {
                return $data->jumlah_mahasiswa;
            })
            ->addColumn('action', function ($data) {
                $button = view("components.button.default", [
                    'type' => 'link',
                    'tooltip' => 'Penilaian',
                    'class' => 'btn btn-outline-primary btn-sm',
                    "icon" => "fa fa-edit",
                    "route" => route('dosen.pengisian_nilai.form_nilai', $data->id_kelas_kuliah),
                ]);
                return $button;
            })
            ->rawColumns(['action'])
            ->setRowAttr([
                'style' => 'text-align: center',
            ])
            ->toJson();
    }

    public function form_nilai($id_kelas_kuliah)
    {
        $kelas_kuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->first();
        $peserta = t_detail_nilai_perkuliahan_kelas::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->get();
        return view('dosen.pengisian_nilai.form_nilai', compact('peserta', 'kelas_kuliah'));
    }

    public function store_nilai(Request $request)
    {

        DB::beginTransaction();

        try{
            
            $peserta = $request->except('_token', 'id_kelas_kuliah', 'id_prodi');

            foreach ($peserta as $ID => $nilai) {

                if(!is_null($nilai)){
                    if($nilai > 100 || $nilai < 0){
                        Session::flash('error_msg', 'Nilai tidak boleh lebih dari 100.');
                        return redirect()->back()->withInput();
                    }
    
                    $hasil_nilai =  m_skala_nilai_prodi::setFilter([
                                        'filter' => "id_prodi='$request->id_prodi'"
                                    ])->whereRaw('? between bobot_minimum and bobot_maksimum', [$nilai])->first();
                    
    
                    if(!$hasil_nilai){
                        Session::flash('error_msg', 'Skala Nilai tidak ditemukan.');
                        return redirect()->back()->withInput();
                    }
    
                    // Update Nilai
                    $records = [
                        "nilai_angka" => $nilai,
                        "nilai_indeks" => (string) $hasil_nilai->nilai_indeks,
                        "nilai_huruf" => $hasil_nilai->nilai_huruf,
                    ];

                    $key = [
                        'id_registrasi_mahasiswa' => $ID,
                        'id_kelas_kuliah' => $request->id_kelas_kuliah,
                    ];

                    $results[] = UpdateDataFeeder('UpdateNilaiPerkuliahanKelas', $key, $records, 'GetDetailNilaiPerkuliahanKelas');
                    
                }

            }
    
            DB::commit();

            // Session::flash('success_msg', 'Penilaian Berhasil!');
            return redirect()->back()->with('results', $results ?? []);

        }catch(\Exception $e){

            DB::rollback();

            Session::flash('error_msg', 'Terjadi kesalahan pada server');
            return dd($e);
        }
    }

    public function export($id_kelas_kuliah) 
    {
        
        $kelas_kuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->first();

        $file_name_1 = 'Nilai_-'.$kelas_kuliah->nama_mata_kuliah.'-_Kelas_'.$kelas_kuliah->nama_kelas_kuliah.'';
        $file_name = str_replace(array("/", "\\", ":", "*", "?", "«", "<", ">", "|"), "-", $file_name_1);

        return Excel::download(new NilaiExport($id_kelas_kuliah), ''.$file_name.'.xlsx');
    }

    public function template_import($id_kelas_kuliah) 
    {
        
        $kelas_kuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->first();

        $file_name_1 = 'Template_Import_Nilai_-'.$kelas_kuliah->nama_mata_kuliah.'-_Kelas_'.$kelas_kuliah->nama_kelas_kuliah.'';
        $file_name = str_replace(array("/", "\\", ":", "*", "?", "«", "<", ">", "|"), "-", $file_name_1);

        return Excel::download(new TemplateNilaiExport($id_kelas_kuliah), ''.$file_name.'.xlsx');
    }


    function import(Request $request)
    {
        $this->validate($request, [
            'import_file' => 'required|file|mimes:xls,xlsx'
        ]);

        $the_file = $request->file('import_file');
        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet        = $spreadsheet->getActiveSheet();
        $row_limit    = $sheet->getHighestDataRow();
        $column_limit = $sheet->getHighestDataColumn();
        $row_range    = range( 2, $row_limit );
        $column_range = range( 'F', $column_limit );
        $startcount = 2;
        $data = array();

            foreach ( $row_range as $row ) {
                $nilai = $sheet->getCell( 'D' . $row )->getValue();

                if($nilai > 100 || $nilai < 0){
                    Session::flash('error_msg', 'Nilai tidak boleh lebih dari 100.');
                    return redirect()->back()->withInput();
                }

                $hasil_nilai =  m_skala_nilai_prodi::where('id_prodi', $request->id_prodi)
                ->whereRaw('? between bobot_minimum and bobot_maksimum', [$nilai])->first();

                if(!$hasil_nilai){
                    Session::flash('error_msg', 'Skala Nilai tidak ditemukan.');
                    return redirect()->back()->withInput();
                }

                // Update Nilai
                $records = [
                    "nilai_angka" => $nilai,
                    "nilai_indeks" => $hasil_nilai->nilai_indeks,
                    "nilai_huruf" => $hasil_nilai->nilai_huruf
                ];
            
                $key = [
                    'id_registrasi_mahasiswa' => $sheet->getCell( 'A' . $row )->getValue(),
                    'id_kelas_kuliah' => $request->id_kelas_kuliah
                ];
            
                $results[] = UpdateDataFeeder('UpdateNilaiPerkuliahanKelas', $key, $records, 'GetDetailNilaiPerkuliahanKelas');
            }

        return redirect()->back()->with('results', $results);
    }
    
}
