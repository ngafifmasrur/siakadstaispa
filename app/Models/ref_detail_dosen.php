<?php

namespace App\Models;

class ref_detail_dosen extends SushiModel
{
    protected $primaryKey = 'id_dosen';
    protected $schema = [
        'id_dosen' => 'uuid',
        'nama_dosen' => 'string',
        'tempat_lahir' => 'string',
        'tanggal_lahir' => 'date',
        'jenis_kelamin' => 'string',
        'id_agama' => 'integer',
        'nama_agama' => 'string',
        'id_status_aktif' => 'integer',
        'nama_status_aktif' => 'string',
        'nidn' => 'string',
        'nama_ibu' => 'string',
        'nik' => 'string',
        'nip' => 'string',
        'npwp' => 'string',
        'id_jenis_sdm' => 'integer',
        'nama_jenis_sdm' => 'string',
        'no_sk_cpns' => 'string',
        'tanggal_sk_cpns' => 'date',
        'no_sk_pengangkatan' => 'string',
        'mulai_sk_pengangkatan' => 'string',
        'id_lembaga_pengangkatan' => 'integer',
        'nama_lembaga_pengangkatan' => 'string',
        'id_pangkat_golongan' => 'integer',
        'nama_pangkat_golongan' => 'string',
        'id_sumber_gaji' => 'integer',
        'nama_sumber_gaji' => 'string',
        'jalan' => 'string',
        'dusun' => 'string',
        'rt' => 'string',
        'rw' => 'string',
        'ds_kel' => 'string',
        'kode_pos' => 'string',
        'id_wilayah' => 'string',
        'nama_wilayah' => 'string',
        'telepon' => 'string',
        'handphone' => 'string',
        'email' => 'string',
        'status_pernikahan' => 'integer',
        'nama_suami_istri' => 'string',
        'nip_suami_istri' => 'string',
        'tanggal_mulai_pns' => 'date',
        'id_pekerjaan_suami_istri' => 'integer',
        'nama_pekerjaan_suami_istri' => 'string',
        'mampu_handle_kebutuhan_khusus' => 'integer',
        'mampu_handle_braille' => 'integer',
        'mampu_handle_bahasa_isyarat' => 'integer'
    ];

    public function getRows()
    {

        $dosen_belum_nidn = m_dosen_belum_nidn::all();
        $dosen_belum_nidn->map(function ($item){
            $item['nama_ibu'] = $item->nama_ibu_kandung;
            return $item;
        });
        $array_data = $dosen_belum_nidn->toArray();

        $data = array_merge(GetDataFeeder('DetailBiodataDosen', self::$filter), $array_data);
        return $data;
    }
}


