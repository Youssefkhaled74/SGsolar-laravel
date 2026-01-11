<?php

namespace App\Policies;

use App\Models\LeadFollowUp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadFollowUpPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    protected function followUpLeadAssignedToUser($user, $followUp)
    {
        if (method_exists($followUp, 'lead') && $followUp->lead) {
            return $followUp->lead->assigned_to === $user->id;
        }

        return false;
    }

    public function view(User $user, $followUp)
    {
        return $user->isSales() ? $this->followUpLeadAssignedToUser($user, $followUp) : false;
    }

    public function create(User $user)
    {
        return $user->isSales() || $user->isAdmin();
    }

    public function update(User $user, $followUp)
    {
        return $user->isSales() ? $this->followUpLeadAssignedToUser($user, $followUp) : false;
    }

    public function delete(User $user, $followUp)
    {
        return false;
    }
}
