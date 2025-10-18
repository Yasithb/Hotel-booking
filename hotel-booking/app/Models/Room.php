<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type',
        'price_per_night',
        'description',
        'amenities',
        'max_occupancy',
        'is_available'
    ];

    protected $casts = [
        'amenities' => 'array',
        'price_per_night' => 'decimal:2',
        'is_available' => 'boolean'
    ];

    /**
     * Get the bookings for the room.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if room is available for given dates
     */
    public function isAvailableForDates($checkIn, $checkOut)
    {
        if (!$this->is_available) {
            return false;
        }

        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                      ->orWhere(function ($query) use ($checkIn, $checkOut) {
                          $query->where('check_in_date', '<=', $checkIn)
                                ->where('check_out_date', '>=', $checkOut);
                      });
            })
            ->exists();
    }

    /**
     * Get current booking if room is occupied
     */
    public function currentBooking()
    {
        return $this->bookings()
            ->where('status', 'checked_in')
            ->where('check_in_date', '<=', now()->toDateString())
            ->where('check_out_date', '>=', now()->toDateString())
            ->first();
    }
}
