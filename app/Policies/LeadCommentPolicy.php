<?php

namespace App\Policies;

use App\Models\LeadComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadCommentPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    protected function commentLeadAssignedToUser($user, $comment)
    {
        if (method_exists($comment, 'lead') && $comment->lead) {
            return $comment->lead->assigned_to === $user->id;
        }

        return false;
    }

    public function view(User $user, $comment)
    {
        return $user->isSales() ? $this->commentLeadAssignedToUser($user, $comment) : false;
    }

    public function create(User $user)
    {
        return $user->isSales() || $user->isAdmin();
    }

    public function update(User $user, $comment)
    {
        return $user->isSales() ? $this->commentLeadAssignedToUser($user, $comment) : false;
    }

    public function delete(User $user, $comment)
    {
        return false;
    }
}
