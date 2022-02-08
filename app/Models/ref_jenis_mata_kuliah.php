<?php

namespace App\Models;

class ref_jenis_mata_kuliah extends SushiModel
{

    protected $primaryKey = 'id_jenis_mata_kuliah';

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
