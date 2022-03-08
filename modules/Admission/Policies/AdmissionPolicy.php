<?php

namespace Modules\Admission\Policies;

use App\Models\User;
use Modules\Admission\Models\AdmissionRegistrant;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any permissions.
     */
    public function registration(User $user)
    {
        return AdmissionRegistrant::currentUser($user)->count() ? true : false;
    }

    /**
     * Determine whether the user can view any permissions.
     */
    public function committee(User $user)
    {
        return $user->admissionCommittees()->exists();
    }

    /**
     * Determine whether the user can permissions.
     */
    public function manageRegistrants(User $user)
    {
        return $user->admissionCommitteeHasPermissions('manage-registrants');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function manageTestDates(User $user)
    {
        return $user->admissionCommitteeHasPermissions('manage-test-dates');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function manageTestSessions(User $user)
    {
        return $user->admissionCommitteeHasPermissions('manage-test-sessions');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function managePayments(User $user)
    {
        return $user->admissionCommitteeHasPermissions('manage-payments');
    }

    /**
     * Determine whether the user can permissions.
     */
    public function manageAdmissions(User $user)
    {
        return $user->admissionCommitteeHasPermissions('manage-admissions');
    }
}
