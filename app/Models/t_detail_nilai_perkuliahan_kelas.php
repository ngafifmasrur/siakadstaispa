<?php

namespace App\Models;

class t_detail_nilai_perkuliahan_kelas extends SushiModel
{
    protected $schema = [
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'id_semester' => 'uuid',
        'nama_semester' => 'string',
        'nama_dosen' => 'string',
        'id_kelas_kuliah' => 'uuid',
        'nama_kelas_kuliah' => 'string',
        'id_registrasi_mahasiswa' => 'uuid',
        'id_mahasiswa' => 'uuid',
        'nim' => 'string',
        'nama_mahasiswa' => 'string',
        'jurusan' => 'string',
        'angkatan' => 'integer',
        'nilai_angka' => 'integer',
        'nilai_indeks' => 'integer',
        'nilai_huruf' => 'integer',
    ];

    public function getRows()
    {
        return GetDataFeeder('GetDetailNilaiPerkuliahanKelas', self::$filter);
    }
}