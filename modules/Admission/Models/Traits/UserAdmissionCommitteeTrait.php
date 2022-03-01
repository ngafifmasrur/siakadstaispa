<?php

namespace Modules\Admission\Models\Traits;

trait UserAdmissionCommitteeTrait {

    /**
     * This belongs to many.
     */
    public function admissionCommittees () {
        return $this->belongsToMany('Modules\Admission\Models\AdmissionCommittee', 'admission_committee_members', 'member_id', 'committee_id')->withPivot('id', 'kd');
    }

    /**
     * This belongs to many.
     */
    public function getAdmissionCommitteePermissions () {
        return $this->admissionCommittees->load('permissions')->pluck('permissions')->flatten()->pluck('name');
    }

    /**
     * This belongs to many.
     */
    public function admissionCommitteeHasPermissions ($perms, $all = false) {
        $permissions = $this->getAdmissionCommitteePermissions();

        if ($all)
        	return $this->getAdmissionCommitteePermissions()->diff($perms)->count() == 0;
        else
        	return $this->getAdmissionCommitteePermissions()->intersect($perms)->count() > 0;
    }

}