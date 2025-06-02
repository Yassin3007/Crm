<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'title',
        'action_type',
        'action_date',
        'action_time',
        'notes',
    ];

    protected $casts = [
        'action_date' => 'date',
        'action_time' => 'datetime:H:i',
    ];

    /**
     * Get the lead that owns the action.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Get the action type with proper formatting.
     */
    public function getFormattedActionTypeAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->action_type));
    }

    /**
     * Scope to get actions for a specific lead.
     */
    public function scopeForLead($query, $leadId)
    {
        return $query->where('lead_id', $leadId);
    }

    /**
     * Scope to get recent actions.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope to get actions by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('action_type', $type);
    }
}
