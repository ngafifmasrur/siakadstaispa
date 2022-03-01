<?php

namespace Modules\Admission\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionForm extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "admission_forms";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'admission_id', 'key', 'description', 'required', 'required_message'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'admission_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'name', 'route', 'params'
    ];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to admission.
     */
    public function admission () {
        return $this->belongsTo(Admission::class, 'admission_id');
    }

    /**
     * Get name attributes.
     */
    public function getNameAttribute () {
        return $this->availableForms()[$this->key]['name'] ?? null;
    }

    /**
     * Get route attributes.
     */
    public function getRouteAttribute () {
        return $this->availableForms()[$this->key]['route'] ?? null;
    }

    /**
     * Get params attributes.
     */
    public function getParamsAttribute () {
        return $this->availableForms()[$this->key]['params'] ?? [];
    }

    /**
     * Get params attributes.
     */
    public function getStatus ($registrant) {
        return $this->availableForms($registrant)[$this->key]['status'] ?? false;
    }

    /**
     * The table associated with the model.
     */
    protected function availableForms($registrant = false) {

        return [
            [
                'route' => 'profile', 
                'name' => 'Data diri',
                'status' => $registrant ? count($registrant->nullFields()) == 0 : null,
            ],
            [
                'route' => 'email', 
                'name' => 'Alamat e-mail',
                'status' => $registrant ? $registrant->user->email()->exists() : null,
            ],
            [
                'route' => 'phone', 
                'name' => 'Nomor HP',
                'status' => $registrant ? $registrant->user->phone()->exists() : null,
            ],
            [
                'route' => 'address', 
                'name' => 'Alamat asal',
                'status' => $registrant ? $registrant->user->address()->exists() : null,
            ],
            [
                'route' => 'parent', 
                'params' => ['type' => 'father'],
                'name' => 'Data ayah',
                'status' => $registrant ? $registrant->user->father()->exists() : null,
            ],
            [
                'route' => 'parent', 
                'params' => ['type' => 'mother'],
                'name' => 'Data ibu',
                'status' => $registrant ? $registrant->user->mother()->exists() : null,
            ],
            [
                'route' => 'parent', 
                'params' => ['type' => 'foster'],
                'name' => 'Data wali',
                'status' => $registrant ? $registrant->user->foster()->exists() : null,
            ],
            [
                'route' => 'studies.index', 
                'name' => 'Riwayat pendidikan',
                'status' => $registrant ? $registrant->user->studies()->exists() : null,
            ],
            [
                'route' => 'organizations.index', 
                'name' => 'Riwayat organisasi',
                'status' => $registrant ? $registrant->user->organizations()->exists() : null,
            ],
            [
                'route' => 'achievements.index', 
                'name' => 'Data prestasi',
                'status' => $registrant ? $registrant->user->achievements()->exists() : null,
            ],
            [
                'route' => 'major', 
                'name' => 'Pemilihan program studi',
                'status' => $registrant ? ($registrant->major1 || $registrant->major2) : null,
            ],
            [
                'route' => 'file', 
                'name' => 'Berkas pendaftaran',
                'status' => $registrant ? ($registrant->files()->where('required', 1)->count() >= $registrant->admission->files()->where('required', 1)->count()) : null,
            ],
            [
                'route' => 'test', 
                'name' => 'Pemilihan tanggal tes',
                'status' => $registrant ? ($registrant->test_at && $registrant->session_id) : null,
            ]
        ];
    }
}
