<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = ['trip_id', 'name', 'number_plate', 'seats'];

    // Bus.php
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

  public function busSeats()
{
    return $this->hasMany(Seat::class, 'bus_id');
}

}
