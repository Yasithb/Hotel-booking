<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'nationality',
        'id_number'
    ];

    protected $casts = [
        'date_of_birth' => 'date'
    ];

    /**
     * Get the bookings for the guest.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get guest's full name
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get guest's current bookings
     */
    public function currentBookings()
    {
        return $this->bookings()
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->where('check_in_date', '<=', now()->toDateString())
            ->where('check_out_date', '>=', now()->toDateString());
    }

    /**
     * Get guest's booking history
     */
    public function bookingHistory()
    {
        return $this->bookings()
            ->where('status', 'checked_out')
            ->orderBy('check_out_date', 'desc');
    }
}
