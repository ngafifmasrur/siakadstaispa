<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ref_jenis_pendaftaran extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_jenis_daftar';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetJenisPendaftaran');
    }
}
