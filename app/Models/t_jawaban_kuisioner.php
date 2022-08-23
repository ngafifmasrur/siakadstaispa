<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_jawaban_kuisioner extends Model
{
    use HasFactory;
    protected $table = 't_jawaban_kuesioner';
    protected $fillable = ['id','t_kuesioner_id','kuesioner','jawaban','skor'];
    public function kuesioner()
    {
        return $this->belongsTo(t_kuesioner::class, 't_kuesioner_id');
    }
}
