<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TripStation extends Model
{
    use HasFactory;

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
