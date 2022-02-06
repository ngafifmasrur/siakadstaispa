<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class t_peserta_kelas_kuliah extends Model
{
    use HasFactory, Sushi;

    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    public $sushiInsertChunkSize = 20;

    public function getRows()
    {
        return GetDataFeeder('GetPesertaKelasKuliah');
    }

    public function nilai()
    {
        return $this->belongsTo(t_detail_nilai_perkuliahan_kelas::class, 'id_kelas_kuliah', 'id_kelas_kuliah');
    }
}
