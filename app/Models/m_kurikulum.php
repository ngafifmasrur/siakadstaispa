<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_kurikulum extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_kurikulum';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    public function getRows()
    {
        return GetDataFeeder('GetListKurikulum');
    }

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_semester');
    }
    
    public static function byProdi()
    {
        return static::query()->where('id_prodi', auth()->user()->id_prodi);
    }

}
