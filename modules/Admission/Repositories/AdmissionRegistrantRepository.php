<?php

namespace Modules\Admission\Repositories;

use App\Models\User;
use Modules\Admission\Models\AdmissionRegistrant;

class AdmissionRegistrantRepository
{
    /**
     * Instance the main property.
     */    
    public $model;

    /**
     * Pagination limit (set false to disable pagination).
     */    
    public $limit = 5;

    /**
     * Admission class
     */    
    public $admission = false;

    /**
     * Create a new controller instance.
     */
    public function __construct(AdmissionRegistrant $registrant)
    {
        $this->model = $registrant;
    }

    /**
     * Get current user.
     */
    public function getCurrentUser($user = false)
    {
        return $this->model->with('user')->currentUser($user)->first();
    }

    /**
     * Get all resources.
     */
    public function getAll()
    {
        return $this->model->get();
    }

    /**
     * Where trashed.
     */
    public function onlyTrashed($bool = false)
    {
        if($bool)
            $this->model = $this->model->onlyTrashed();

        return $this;
    }

    /**
     * Set limit.
     */
    public function setLimit($limit = false)
    {
        if($limit) {
            $this->limit = $limit;
            if($limit > 100) {
                $this->limit = 100;
            }
        }

        return $this;
    }

    /**
     * Set where.
     */
    public function setWhere($function)
    {
        $this->model = $this->model->where($function);

        return $this;
    }

    /**
     * Search resources with query.
     */
    public function search($query = '')
    {
        $registrants = $this->model->with('user.profile')
                                   ->whereAdmissionIsOrAll($this->admission)
                                   ->where(function($query) {
                                        $query->where('kd', request('search', ''))
                                               ->orWhereHas('user.profile', function ($user) {
                                                    $user->where('name', 'like', '%'.request('search', '').'%');
                                               });
                                   })
                                   ->orderByDesc('created_at');

        return $this->limit ? $registrants->paginate($this->limit) : $registrants->get();
    }

    /**
     * Get detailed resource.
     */
    public function show(AdmissionRegistrant $registrant)
    {
        return $registrant->load(['admission.period', 'user']);
    }

    /**
     * Get and update detailed resource.
     */
    public function register($data, User $user)
    {
        $kd = date('ym-dHis');

        $user->profile()->update([
            'pob'   => $data['pob'],
            'dob'   => date('Y-m-d', strtotime($data['dob'])),
            'sex'   => $data['sex']
        ]);

        $registrant = new AdmissionRegistrant([
            'admission_id'  => $data['admission_id'],
            'user_id'       => $user->id,
            'kd'            => $kd
        ]);

        return $registrant->save() ? $registrant : false;
    }

    /**
     * Get and update detailed resource.
     */
    public function update($data, AdmissionRegistrant $registrant)
    {
        if ($registrant->update($data)) {
            return $registrant;
        }

        return false;
    }

    /**
     * Get and delete detailed resource.
     */
    public function delete(AdmissionRegistrant $registrant)
    {
        $tmp = $registrant;

        return $registrant->delete() ? $tmp : false;
    }

    /**
     * Get and restore detailed resource.
     */
    public function restore(AdmissionRegistrant $registrant)
    {
        return $registrant->restore() ? $registrant : false;
    }

    /**
     * Get and kill detailed resource.
     */
    public function kill(AdmissionRegistrant $registrant)
    {
        $tmp = $registrant;

        return $registrant->forceDelete() ? $tmp : false;
    }
}
