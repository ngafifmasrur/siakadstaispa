<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;
use App\Models\m_kelas_kuliah;

class t_dosen_pengajar_kelas_kuliah extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_aktivitas_mengajar';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $appends = ['id_semester', 'id_prodi'];

    public function getRows()
    {
        $data = GetDataFeeder('GetDosenPengajarKelasKuliah');
        foreach($data as $key => $item) {
            $data[$key]['id_semester'] = $this->id_semester;
            $data[$key]['id_prodi'] = $this->id_prodi;
        }

        return $data;
    }

    public function kelas_kuliah()
    {
        return $this->belongsTo(m_kelas_kuliah::class, 'id_kelas_kuliah');
    }

    public function getIdSemesterAttribute()
    {
        return $this->kelas('id_semester');
    }

    public function getIdProdiAttribute()
    {
        return $this->kelas('id_prodi');
    }

    public function kelas($value)
    {
        $result = m_kelas_kuliah::where('id_kelas_kuliah', $this->id_kelas_kuliah)->first()->$value ?? NULL;
        return $result;
    }
}
