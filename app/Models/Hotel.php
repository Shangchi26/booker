<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'province_id',
        'image',
        'address',
        'hotline',
        'description',
    ];
    public function rooms()
    {
        return $this->hasMany(Amenity::class, 'hotel_id');
    }
    public function booking()
    {
        return $this->hasMany(Room::class);
    }
    public function dashboard()
    {
        return $this->hasMany(Dashboard::class);
    }
}
