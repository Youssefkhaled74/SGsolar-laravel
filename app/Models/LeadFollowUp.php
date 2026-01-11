<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'lead_action_id',
        'assigned_to',
        'created_by',
        'note',
        'scheduled_at',
        'completed',
        'completed_at',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function parentAction()
    {
        return $this->belongsTo(LeadAction::class, 'lead_action_id');
    }
}
