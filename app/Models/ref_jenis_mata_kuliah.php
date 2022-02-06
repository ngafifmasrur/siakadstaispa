<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ref_jenis_mata_kuliah extends Model
{
    use HasFactory, Sushi;

    protected $primaryKey = 'id_jenis_mata_kuliah';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';

    // Isi Model
    protected $rows = [
        [
            'id_jenis_mata_kuliah' => 'A',
            'nama_jenis_mata_kuliah' => 'Wajib'
        ],
        [
            'id_jenis_mata_kuliah' => 'B',
            'nama_jenis_mata_kuliah' => 'Pilihan'
        ],
        [
            'id_jenis_mata_kuliah' => 'C',
            'nama_jenis_mata_kuliah' => 'Wajib Peminatan'
        ],
        [
            'id_jenis_mata_kuliah' => 'D',
            'nama_jenis_mata_kuliah' => 'Pilihan Peminatan'
        ],
        [
            'id_jenis_mata_kuliah' => 'S',
            'nama_jenis_mata_kuliah' => 'Tugas akhir/Skripsi/Tesis/Disertasi'
        ]
    ];
}
