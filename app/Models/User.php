<?php

// app/Models/User.php - Update fillable dan casts

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->room_number) {
                $room = \App\Models\Room::where('room_number', $user->room_number)->first();
                if ($room) {
                    $room->update(['status' => 'available']);
                }
            }
        });
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',              // Tambah field baru
        'role',
        'phone',
        'address',
        'room_number',
        'monthly_rent',
        'date_of_birth',      // Tambah field baru
        'emergency_contact',  // Tambah field baru
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'monthly_rent' => 'decimal:2',
        'date_of_birth' => 'date',
    ];

    // Helper methods for role checking
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // Relationships
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    public function complaints()
    {
        return $this->hasMany(\App\Models\Complaint::class);
    }

    // Helper untuk mendapatkan nama role
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'user' => 'Penghuni',
            default => 'Unknown'
        };
    }

    // Helper untuk URL foto
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        // Default avatar jika tidak ada foto
        return asset('images/default-avatar.png');
    }

    // Helper untuk initial nama
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }
}