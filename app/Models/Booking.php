<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'trip_id',
        'seat_id',
        'from_city_id',
        'to_city_id',
        'from_station_order',
        'to_station_order',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }
    public function fromStation()
{
    return $this->belongsTo(\App\Models\TripStation::class, 'from_city_id');
}

public function toStation()
{
    return $this->belongsTo(\App\Models\TripStation::class, 'to_city_id');
}

}
