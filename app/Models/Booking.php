<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id", "status", "price", "payments"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class, "booking_id");
    }
}
