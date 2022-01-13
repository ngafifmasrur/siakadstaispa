<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_dosen extends Model
{
    use HasFactory;

    protected $table = 'm_dosen';
    protected $primaryKey = 'id_dosen';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
