<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        "booking_detail_id", "rate", "comment"
    ];
    public function bookingDetail()
    {
        return $this->belongsTo(BookingDetail::class);
    }
}
