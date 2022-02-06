<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ref_kelompok_mata_kuliah extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_kelompok_mata_kuliah';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    // Isi Model
    protected $rows = [
        [
            'id_kelompok_mata_kuliah' => 'A',
            'nama_kelompok_mata_kuliah' => 'MPK'
        ],
        [
            'id_kelompok_mata_kuliah' => 'B',
            'nama_kelompok_mata_kuliah' => 'MKK'
        ],
        [
            'id_kelompok_mata_kuliah' => 'C',
            'nama_kelompok_mata_kuliah' => 'MKB'
        ],
        [
            'id_kelompok_mata_kuliah' => 'D',
            'nama_kelompok_mata_kuliah' => 'MPB'
        ],
        [
            'id_kelompok_mata_kuliah' => 'E',
            'nama_kelompok_mata_kuliah' => 'MBB'
        ],
        [
            'id_kelompok_mata_kuliah' => 'F',
            'nama_kelompok_mata_kuliah' => 'MKU/MKDU'
        ],
        [
            'id_kelompok_mata_kuliah' => 'G',
            'nama_kelompok_mata_kuliah' => 'MKDK'
        ],
        [
            'id_kelompok_mata_kuliah' => 'H',
            'nama_kelompok_mata_kuliah' => 'MKK'
        ]
    ];
}
