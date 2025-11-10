<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'data',
        'action_url',
        'is_read',
        'read_at',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Scope: Unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: Not expired
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Get time ago text
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get icon based on type
     */
    public function getIconAttribute(): string
    {
        return match ($this->type) {
            'new_booking' => 'fa-calendar-check',
            'check_in_reminder' => 'fa-door-open',
            'check_out_reminder' => 'fa-door-closed',
            'no_show' => 'fa-exclamation-triangle',
            'expired' => 'fa-clock',
            default => 'fa-bell',
        };
    }

    /**
     * Get color based on type
     */
    public function getColorAttribute(): string
    {
        return match ($this->type) {
            'new_booking' => 'success',
            'check_in_reminder' => 'info',
            'check_out_reminder' => 'warning',
            'no_show' => 'danger',
            'expired' => 'secondary',
            default => 'primary',
        };
    }

    /**
     * Get Tailwind color class for icon background
     */
    public function getIconBgClassAttribute(): string
    {
        return match ($this->type) {
            'new_booking' => 'bg-green-100',
            'check_in_reminder' => 'bg-blue-100',
            'check_out_reminder' => 'bg-yellow-100',
            'no_show' => 'bg-red-100',
            'expired' => 'bg-gray-100',
            default => 'bg-light-primary/10',
        };
    }

    /**
     * Get Tailwind color class for icon
     */
    public function getIconColorClassAttribute(): string
    {
        return match ($this->type) {
            'new_booking' => 'text-green-600',
            'check_in_reminder' => 'text-blue-600',
            'check_out_reminder' => 'text-yellow-600',
            'no_show' => 'text-red-600',
            'expired' => 'text-gray-600',
            default => 'text-light-primary',
        };
    }
}
