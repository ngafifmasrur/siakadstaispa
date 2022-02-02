<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class m_dosen extends Model
{
    use HasFactory, Sushi;

    // protected $table = 'm_dosen';
    protected $primaryKey = 'id_dosen';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_dosen');
    }

    public function hasUser()
    {
        $user = User::where('id_dosen', $this->id_dosen)->count();
        return $user > 0 ? true : false;
    }

    public function getRows()
    {
        return GetDataFeeder('GetListDosen');
    }
}
