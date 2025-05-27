<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function tripStations()
    {
        return $this->hasMany(TripStation::class);
    }
}

