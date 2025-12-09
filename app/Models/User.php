<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
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
            'profile' => 'array',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function voucherRedemptions()
    {
        return $this->hasMany(VoucherRedemption::class);
    }

    // ====== scope =========
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }

    // ====== Accessors ========
    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }

    public function getTotalBookingsAttribute(): int
    {
        return $this->bookings()->count();
    }

    public function getTotalSpentAttribute(): int
    {
        return $this->bookings()
            ->whereIn('status', ['paid', 'checked_in', 'confirmed', 'completed'])
            ->sum('total_price');
    }

    public function getLastBookingDateAttribute(): ?string
    {
        $lastBooking = $this->bookings()->latest()->first();
        return $lastBooking ? $lastBooking->created_at->format('d M Y') : null;
    }

    // ===== Methods ======
    public function canBeDeleted(): bool
    {
        // Tidak bisa hapus admin yang sedang login
        if ($this->id === Auth::id()) {
            return false;
        }

        // Tidak bisa hapus user dengan booking aktif
        return !$this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }

    public function getStatusBadgeColor(): string
    {
        if (!$this->is_active) return 'red';
        if ($this->trashed()) return 'gray';
        return 'green';
    }

    public function getStatusLabel(): string
    {
        if (!$this->is_active) return 'Inactive';
        if ($this->trashed()) return 'Deleted';
        return 'Active';
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
