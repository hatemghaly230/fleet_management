<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// app/Models/Trip.php


class Trip extends Model
{
    protected $fillable = ['from_city_id', 'to_city_id', 'date'];

    // علاقة المدينة المبدأية
    public function fromCity()
    {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    // علاقة المدينة النهائية
    public function toCity()
    {
        return $this->belongsTo(City::class, 'to_city_id');
    }
    protected $casts = [
        'date' => 'date', // أو 'datetime' حسب نوع الحقل في قاعدة البيانات
    ];

    public function tripStations()
    {
        return $this->hasMany(TripStation::class);
    }
    public function buses()
{
    return $this->hasMany(Bus::class);
}

}
