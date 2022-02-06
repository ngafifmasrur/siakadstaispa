<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_mahasiswa extends Model
{
    use HasFactory, Sushi;

    // protected $table = 'm_mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    public $sushiInsertChunkSize = 20;

    public function getRows()
    {
        return GetDataFeeder('GetListMahasiswa');
    }
    
    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }

    public function periode()
    {
        return $this->belongsTo('App\Models\m_semester', 'id_periode');
    }

    public function pt()
    {
        return $this->belongsTo('App\Models\m_perguruan_tinggi', 'id_perguruan_tinggi');
    }

    public function agama()
    {
        return $this->belongsTo('App\Models\ref_agama', 'id_agama');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function hasUser()
    {
        $user = User::where('id_mahasiswa', $this->id_mahasiswa)->count();
        return $user > 0 ? true : false;
    }

    public function riwayat_pendidikan()
    {
        return $this->hasMany(t_riwayat_pendidikan::class, 'id_mahasiswa');
    }
}
