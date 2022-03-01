<?php

namespace Modules\Admission\Policies;

use App\Models\User;
use Modules\Admission\Models\AdmissionRegistrant;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdmissionRegistrantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any registrants.
     */
    public function viewAny(User $user)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants');
    }

    /**
     * Determine whether the user can view the user.
     */
    public function view(User $user, AdmissionRegistrant $registrant)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants') || $user->id === $registrant->user_id;
    }

    /**
     * Determine whether the user can create registrants.
     */
    public function create(User $user)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants');
    }

    /**
     * Determine whether the user can update the user.
     */
    public function update(User $user, AdmissionRegistrant $registrant)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants');
    }

    /**
     * Determine whether the user can update the repassword.
     */
    public function repass(User $user, AdmissionRegistrant $registrant)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants') || $user->id != $registrant->user_id;
    }

    /**
     * Determine whether the user can delete the user.
     */
    public function delete(User $user, AdmissionRegistrant $registrant)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants') || $user->id != $registrant->user_id;
    }

    /**
     * Determine whether the user can restore the user.
     */
    public function restore(User $user, AdmissionRegistrant $registrant)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants') || $user->id != $registrant->user_id;
    }

    /**
     * Determine whether the user can permanently delete the user.
     */
    public function forceDelete(User $user, AdmissionRegistrant $registrant)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants') || $user->id != $registrant->user_id;
    }

    /**
     * Determine whether the user can permissions.
     */
    public function verifyRegistrant(User $user)
    {
        return $user->admissionCommitteeHasPermissions('verify');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function testRegistrant(User $user)
    {
        return $user->admissionCommitteeHasPermissions('test');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function validateRegistrant(User $user)
    {
        return $user->admissionCommitteeHasPermissions('validate');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function acceptPaymentRegistrant(User $user)
    {
        return $user->admissionCommitteeHasPermissions('accept-payment');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function giveAgreementRegistrant(User $user)
    {
        return $user->admissionCommitteeHasPermissions('give-agreement');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function giveRoomRegistrant(User $user)
    {
        return $user->admissionCommitteeHasPermissions('give-room');
    }
}
