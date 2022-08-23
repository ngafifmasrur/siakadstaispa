<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_kuesioner extends Model
{
    use HasFactory;
    protected $table = 'm_kuesioner';
    protected $fillable = ['kuesioner','jenis','status'];
}
