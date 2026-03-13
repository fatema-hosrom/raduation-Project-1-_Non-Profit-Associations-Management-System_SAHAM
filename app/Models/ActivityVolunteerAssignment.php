<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityVolunteerAssignment extends Model
{
    protected $fillable = [
        'activity_id',
        'volunteer_id',
        'status',
        'joined_at',
        'request_date',
        'decision_date',
        'rejection_reason',
        'is_deleted',
        'removed_at',
        'removed_by',
        'removal_reason'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'request_date' => 'datetime',
        'decision_date' => 'datetime',
        'removed_at' => 'datetime',
        'is_deleted' => 'boolean'
    ];

    // العلاقات
    public function activity(): BelongsTo
    {
        return $this->belongsTo(OrganizationActivity::class, 'activity_id');
    }

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_id');
    }

    public function removedBy(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'removed_by');
    }

    // Scopes مفيدة
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByActivity($query, $activityId)
    {
        return $query->where('activity_id', $activityId);
    }

    public function scopeByVolunteer($query, $volunteerId)
    {
        return $query->where('volunteer_id', $volunteerId);
    }
}
