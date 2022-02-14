<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_jenis_sertifikasi extends Model
{
    protected $primaryKey = 'id_jenis_sertifikasi';
    protected $schema = [
        'id_jenis_sertifikasi' => 'integer',
        'nama_jenis_sertifikasi' => 'string',
    ];
    
    public function getRows()
    {
        return GetDataFeeder('GetJenisSertifikasi', self::$filter);
    }
}
