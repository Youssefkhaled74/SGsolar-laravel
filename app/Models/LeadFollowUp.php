<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class LeadFollowUp extends Model
{
    use HasFactory;

    protected static ?string $resolvedTable = null;

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

    protected static function resolveTableName(): string
    {
        if (static::$resolvedTable) {
            return static::$resolvedTable;
        }

        if (Schema::hasTable('lead_follow_ups')) {
            static::$resolvedTable = 'lead_follow_ups';
        } elseif (Schema::hasTable('lead_followups')) {
            static::$resolvedTable = 'lead_followups';
        } else {
            // Fallback keeps default Laravel naming if neither exists yet.
            static::$resolvedTable = 'lead_follow_ups';
        }

        return static::$resolvedTable;
    }

    public function getTable()
    {
        return static::resolveTableName();
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function parentAction()
    {
        return $this->belongsTo(LeadAction::class, 'lead_action_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
