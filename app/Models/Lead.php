<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'product_text',
        'source_id',
        'status_id',
        'assigned_to',
        'created_by',
    ];

    public function source()
    {
        return $this->belongsTo(LeadSource::class, 'source_id');
    }

    public function status()
    {
        return $this->belongsTo(LeadStatus::class, 'status_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to limit visible leads for a given user.
     * Admins see all; sales see only assigned leads.
     */
    public function scopeVisibleTo($query, User $user)
    {
        if ($user->isAdmin()) {
            return $query;
        }

        return $query->where('assigned_to', $user->id);
    }
}
