<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\{
    t_peserta_kelas_kuliah,
    m_mahasiswa,
    m_kelas_kuliah,
    m_global_konfigurasi,
    m_jadwal,
    t_dosen_wali_mahasiswa,
    t_riwayat_pendidikan_mahasiswa,
    m_dosen,
    m_informasi,
    t_krs_mahasiswa,
    t_dosen_pengajar_kelas_kuliah,
    m_kuesioner,
    t_jawaban_kuisioner,
    t_kuesioner
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class DashboardController extends Controller
{
    public function index()
    {
        $semester_aktif = m_global_konfigurasi::first()->id_semester_aktif;
        $check_feeder = t_riwayat_pendidikan_mahasiswa::count_total();
        if($check_feeder == 0) {
            Session::flash('error_msg', 'Aplikasi SIAKAD sedang mengalami gangguan, coba lagi nanti.');
            return view('mahasiswa.krs.index2'); 
        }
        $riwayat_pendidikan = t_riwayat_pendidikan_mahasiswa::setFilter([
            'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
        ])->first();
        if(!isset($riwayat_pendidikan)){
            Session::flash('error_msg', 'Mahasiswa tidak memiliki semester aktif / riwayat pendidikan');
            return view('mahasiswa.krs.index2');
        }

        $status_krs = t_krs_mahasiswa::where('id_registrasi_mahasiswa', $riwayat_pendidikan->id_registrasi_mahasiswa)->first();

        if(isset($status_krs) && $status_krs->status == 'Diverifikasi') {
            $pesertaKelasKuliah = t_peserta_kelas_kuliah::setFilter([
                'filter' => "id_mahasiswa='".Auth::user()->id_mahasiswa."'"
            ])->pluck('id_kelas_kuliah')->toArray();
            // dd($pesertaKelasKuliah)
            $kelasKuliah = m_kelas_kuliah::setFilter([
                'filter' => "id_semester='$semester_aktif'"
            ])->whereIn('id_kelas_kuliah', $pesertaKelasKuliah)->get();
    
            $kelasKuliah->map(function ($item){
                $jadwal = m_jadwal::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();
                $dosen = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $item->id_kelas_kuliah)->first();
                // $cekKuesioner = t_kuesioner::where('matkul_id',$item->id_kelas_kuliah)->where('mahasiswa_id', Auth::user()->id_mahasiswa)->get();
                $cekKuesioner = t_kuesioner::where('matkul_id',$item->id_kelas_kuliah)->where('mahasiswa_id', Auth::user()->id_mahasiswa)->first();
                // dd($cekKuesioner);
                // dd($dosen);
                $item['matkul_id'] = $cekKuesioner->matkul_id ?? null;
                $item['mahasiswa_id'] = $cekKuesioner->mahasiswa_id ?? null;
                $item['nama_dosen'] = $dosen->nama_dosen ?? null;
                $item['id_dosen'] = $dosen->id_dosen ?? null;
                $item['hari'] = $jadwal->hari ?? null;
                $item['jam_mulai'] = $jadwal->jam_mulai ?? null;
                $item['jam_akhir'] = $jadwal->jam_akhir ?? null;
                return $item;
            });
            // dd($informasi);
        } else {
            $kelasKuliah = null;
        }

        $dosen_wali = t_dosen_wali_mahasiswa::where('id_registrasi_mahasiswa', $riwayat_pendidikan->id_registrasi_mahasiswa)->first();
        if(isset($dosen_wali)) {
            $dosen = m_dosen::setFilter([
                'limit' => "100000"
            ])->where('id_dosen', $dosen_wali->id_dosen)->first()->nama_dosen;
        } else {
            $dosen = 'Belum memiliki dosen wali';
        }

        $informasi = m_informasi::where('status', 1)->get();

        return view('mahasiswa.dashboard', compact('kelasKuliah', 'dosen', 'informasi', 'status_krs'));
    }
    public function showKuisioner($id_matkul)
    {
        $id_matkul = $id_matkul;
        $dosen = t_dosen_pengajar_kelas_kuliah::where('id_kelas_kuliah', $id_matkul)->first();
        $id_dosen = $dosen->id_dosen;
        // dd($id_dosen);
        $data = m_kuesioner::where('status', 1)->get();

        return view('mahasiswa.kuisioner.index',compact('data','id_matkul','id_dosen'));
    }
    public function storeKuisioner(Request $request)
    {
        // dd($request);
        $kuesioner = m_kuesioner::get();
        foreach ($kuesioner as $key => $value) {
            $cekKuesioner= t_kuesioner::where('matkul_id', $request->matkul_id)->first();
            // dd($cekKuesioner);
            if(! isset($cekKuesioner)) {
                $jawaban = "jawaban$value->id";
                // dd($jawaban);
                $t_kuesioner = t_kuesioner::create([
                    'kuesioner_id' => $value->id,
                    'dosen_id' => $request->dosen_id,
                    'mahasiswa_id' => $request->mahasiswa_id,
                    'skor' => $this->skor($request->$jawaban),
                    'matkul_id' => $request->matkul_id
                ]);
                
                $t_jawaban_kuesioner = t_jawaban_kuisioner::create([
                    't_kuesioner_id' => $t_kuesioner->id,
                    'kuesioner' => $value->kuesioner,
                    'jawaban' => $request->$jawaban,
                    'skor'=> $this->skor($request->$jawaban)
                ]);

            }
        }
        return redirect()->route('mahasiswa.dashboard');
    }

    public function skor($jawaban) {
        $skor = 0;
        switch ($jawaban) {
            case 'sangat baik':
                $skor = 4;
                break;
            case 'baik':
                $skor = 3;
                break;
            case 'cukup':
                $skor = 2;
                break;
            case 'kurang':
                $skor = 1;
                break;
            default;
                break;
        }
        return $skor;
    }
}
