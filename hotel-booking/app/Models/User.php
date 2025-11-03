<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'nationality',
        'password',
        'role',
        'newsletter_subscribed',
        'email_verified_at',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'newsletter_subscribed' => 'boolean',
            'active' => 'boolean',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's initials.
     */
    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is staff.
     */
    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff']);
    }

    /**
     * Check if user is a guest.
     */
    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    /**
     * Check if user account is active.
     */
    public function isActive(): bool
    {
        return $this->active ?? true;
    }

    /**
     * Scope to get only active users.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope to get users by role.
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to get newsletter subscribers.
     */
    public function scopeNewsletterSubscribers($query)
    {
        return $query->where('newsletter_subscribed', true);
    }

    /**
     * Get user's bookings.
     */
    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class, 'guest_id');
    }

    /**
     * Get user's profile picture URL.
     */
    public function getProfilePictureAttribute(): string
    {
        // Return default avatar or user's profile picture
        return "https://ui-avatars.com/api/?name=" . urlencode($this->full_name) . "&background=667eea&color=ffffff&size=200";
    }
}
