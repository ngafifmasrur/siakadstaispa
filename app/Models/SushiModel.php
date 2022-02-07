<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Sushi\Sushi;

class SushiModel extends Eloquent
{
    use HasFactory, Sushi;

    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    public $sushiInsertChunkSize = 20;
    protected static $filter;

    public static function setFilter($value = [])
    {
        self::$filter = $value;
		return self::query();
    }
}
