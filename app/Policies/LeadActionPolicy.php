<?php

namespace App\Policies;

use App\Models\LeadAction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadActionPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    protected function actionLeadAssignedToUser($user, $action)
    {
        if (method_exists($action, 'lead') && $action->lead) {
            return $action->lead->assigned_to === $user->id;
        }

        return false;
    }

    public function view(User $user, $action)
    {
        return $user->isSales() ? $this->actionLeadAssignedToUser($user, $action) : false;
    }

    public function create(User $user)
    {
        return $user->isSales() || $user->isAdmin();
    }

    public function update(User $user, $action)
    {
        return $user->isSales() ? $this->actionLeadAssignedToUser($user, $action) : false;
    }

    public function delete(User $user, $action)
    {
        return false;
    }
}
