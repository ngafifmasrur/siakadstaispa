<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;

class FooterInformation extends Model
{
    const TYPE = [
        'INFORMATION' => 'informasi',
        'EMAIL'       => 'email',
        'PHONE_NUMBER'=> 'nomor telepon',
        'WEBSITE'     => 'website'
    ];

    /**
     * The table associated with the model.
     */
    protected $table = "footer_information";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'content', 'type', 'status'
    ];

}
