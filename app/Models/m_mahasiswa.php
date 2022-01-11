<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa';
    protected $guarded = [];

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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
