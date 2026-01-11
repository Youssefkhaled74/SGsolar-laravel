<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        // Admin handled in before(); sales may view leads via scope
        return true;
    }

    public function view(User $user, Lead $lead)
    {
        return $user->isSales() ? ($lead->assigned_to === $user->id) : false;
    }

    public function create(User $user)
    {
        return $user->isSales() || $user->isAdmin();
    }

    public function update(User $user, Lead $lead)
    {
        return $user->isSales() ? ($lead->assigned_to === $user->id) : false;
    }

    public function delete(User $user, Lead $lead)
    {
        // Only admin (handled in before) can delete
        return false;
    }
}
