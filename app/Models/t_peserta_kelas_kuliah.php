<?php

namespace App\Models;

class t_peserta_kelas_kuliah extends SushiModel
{
    protected $schema = [
        'id_kelas_kuliah' => 'uuid',
        'nama_kelas_kuliah' => 'string',
        'id_registrasi_mahasiswa' => 'uuid',
        'id_mahasiswa' => 'uuid',
        'nim' => 'string',
        'nama_mahasiswa' => 'string',
        'id_matkul' => 'uuid',
        'kode_mata_kuliah' => 'string',
        'nama_mata_kuliah' => 'string',
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
    ];


    public function getRows()
    {
        return GetDataFeeder('GetPesertaKelasKuliah', self::$filter);
    }

    public function nilai()
    {
        return $this->belongsTo(t_detail_nilai_perkuliahan_kelas::class, 'id_kelas_kuliah', 'id_kelas_kuliah');
    }
}
