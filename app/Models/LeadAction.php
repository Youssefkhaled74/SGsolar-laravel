<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'action_type_id',
        'user_id',
        'notes',
        'scheduled_at',
        'completed_at',
        'parent_action_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function type()
    {
        return $this->belongsTo(ActionType::class, 'action_type_id');
    }
}
