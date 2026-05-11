<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'price',
        'status',
        'facilities',
        'photos',
        'description',
    ];

    protected $casts = [
        'facilities' => 'array',
        'photos' => 'array',
        'price' => 'decimal:2',
    ];

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'maintenance' => 'Perbaikan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'available' => 'green',
            'occupied' => 'red',
            'maintenance' => 'yellow',
            default => 'gray',
        };
    }
}
