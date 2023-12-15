<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public $fillable = [
        'name',
        'hotel_id',
        'room_type',
        'price',
        'available',
    ];
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class, 'room_id');
    }
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
