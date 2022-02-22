<?php

namespace App\Models;

class ref_detail_mahasiswa extends SushiModel
{
    public $sushiInsertChunkSize = 10;

    protected $primaryKey = 'id_mahasiswa';
    protected $schema = [
        'id_mahasiswa' => 'uuid',
        'id_agama' => 'integer',
        'jenis_kelamin' => 'string',
        'tanggal_lahir' => 'date',
        'nik' => 'string',
        'nama_mahasiswa' => 'string',
        'tempat_lahir' => 'string',
        'nisn' => 'string',
        'nik' => 'string',
        'jalan' => 'string',
        'rt' => 'string',
        'rw' => 'string',
        'dusun' => 'string',
        'kelurahan' => 'string',
        'kode_pos' => 'string',
        'nama_ayah' => 'string',
        'tanggal_lahir_ayah' => 'date',
        'nik_ayah' => 'string',
        'id_jenjang_pendidikan_ayah' => 'integer',
        'id_pekerjaan_ayah' => 'integer',
        'id_penghasilan_ayah' => 'integer',
        'id_kebutuhan_khusus_ayah' => 'integer',
        'tanggal_lahir_ibu' => 'date',
        'nik_ibu' => 'string',
        'id_jenjang_pendidikan_ibu' => 'integer',
        'id_pekerjaan_ibu' => 'integer',
        'id_penghasilan_ibu' => 'integer',
        'id_kebutuhan_khusus_ibu' => 'integer',
        'nama_wali' => 'string',
        'tanggal_lahir_wali' => 'date',
        'nik_wali' => 'string',
        'id_jenjang_pendidikan_wali' => 'integer',
        'id_pekerjaan_wali' => 'integer',
        'id_penghasilan_wali' => 'integer',
        'id_kebutuhan_khusus_mahasiswa' => 'integer',
        'telepon' => 'string',
        'handphone' => 'string',
        'email' => 'string',
        'penerima_kps' => 'boolean',
        'no_kps' => 'string',
        'npwp' => 'string',
        'id_wilayah' => 'integer',
        'kewarganegaraan' => 'string',
        'id_jenis_tinggal' => 'integer',
        'id_alat_transportasi' => 'integer',
    ];

    public function getRows()
    {       
        return  GetDataFeeder('GetBiodataMahasiswa', self::$filter);
    }
}


