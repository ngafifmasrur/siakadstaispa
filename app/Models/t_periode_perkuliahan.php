<?php

namespace App\Models;

class t_periode_perkuliahan extends SushiModel
{

    protected $primaryKey = 'id_prodi';
    protected $schema = [
        'id_prodi' => 'uuid',
        'nama_program_studi' => 'string',
        'id_semester' => 'uuid',
        'nama_semester' => 'string',
        'jumlah_target_mahasiswa_baru' => 'integer',
        'tanggal_awal_perkuliahan' => 'date',
        'tanggal_akhir_perkuliahan' => 'date'
    ];

    public function getRows()
    {
        return GetDataFeeder('GetListPeriodePerkuliahan', self::$filter);
    }
}