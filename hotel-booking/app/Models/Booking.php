<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'total_amount',
        'status',
        'special_requests',
        'booking_date'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'booking_date' => 'datetime',
        'total_amount' => 'decimal:2'
    ];

    /**
     * Get the guest that owns the booking.
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * Get the room that owns the booking.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Calculate the number of nights
     */
    public function getNumberOfNightsAttribute()
    {
        return $this->check_out_date->diffInDays($this->check_in_date);
    }

    /**
     * Calculate total amount based on room price and number of nights
     */
    public function calculateTotalAmount()
    {
        if ($this->room) {
            return $this->room->price_per_night * $this->number_of_nights;
        }
        return 0;
    }

    /**
     * Check if booking is active (current)
     */
    public function isActive()
    {
        $today = Carbon::now()->toDateString();
        return $this->status === 'checked_in' &&
               $this->check_in_date <= $today &&
               $this->check_out_date >= $today;
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']) &&
               $this->check_in_date > Carbon::now()->toDateString();
    }

    /**
     * Scope for active bookings
     */
    public function scopeActive($query)
    {
        $today = Carbon::now()->toDateString();
        return $query->where('status', 'checked_in')
                     ->where('check_in_date', '<=', $today)
                     ->where('check_out_date', '>=', $today);
    }

    /**
     * Scope for upcoming bookings
     */
    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['confirmed', 'pending'])
                     ->where('check_in_date', '>', Carbon::now()->toDateString());
    }
}
