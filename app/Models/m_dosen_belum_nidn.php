<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_dosen_belum_nidn extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_dosen';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = "m_dosen_belum_nidn";
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = false;

}
