<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_mata_kuliah extends Model
{
    use HasFactory;

    protected $table = 'm_mata_kuliah';
    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo('App\Models\m_program_studi', 'id_prodi');
    }
}
