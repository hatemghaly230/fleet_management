<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\Seat;

class BookingApiController extends Controller
{
    // إرجاع المقاعد المتاحة
 public function availableSeats(Request $request)
{
    $tripId = $request->trip_id;
    $fromStationId = $request->from;
    $toStationId = $request->to;

    $trip = Trip::with(['buses.busSeats.bookings', 'tripStations'])->findOrFail($tripId);

    $stations = $trip->tripStations->keyBy('city_id');
    $fromOrder = $stations[$fromStationId]->station_order ?? null;
    $toOrder = $stations[$toStationId]->station_order ?? null;

    if (!$fromOrder || !$toOrder || $fromOrder >= $toOrder) {
        return response()->json(['message' => 'Invalid station selection.'], 422);
    }

    $bus = $trip->buses->first(); // نفترض باص واحد

    $availableSeats = $bus->busSeats->filter(function ($seat) use ($fromOrder, $toOrder) {
        foreach ($seat->bookings as $booking) {
            $bFrom = $booking->from_station_order;
            $bTo = $booking->to_station_order;
            // إذا المحطات متداخلة، المقعد محجوز
            if ($fromOrder < $bTo && $toOrder > $bFrom) {
                return false;
            }
        }
        return true;
    })->values();

    return response()->json($availableSeats);
}



    // تنفيذ الحجز
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'seat_id' => 'required|exists:seats,id',
            'from_station_id' => 'required|exists:cities,id',
            'to_station_id' => 'required|exists:cities,id',
        ]);

        $trip = Trip::with(['tripStations'])->findOrFail($request->trip_id);
        $stations = $trip->tripStations->keyBy('city_id');
        $fromOrder = $stations[$request->from_station_id]->station_order ?? null;
        $toOrder = $stations[$request->to_station_id]->station_order ?? null;

        if (!$fromOrder || !$toOrder || $fromOrder >= $toOrder) {
            return response()->json(['message' => 'Invalid station selection.'], 422);
        }

        $seat = Seat::with(['bookings'])->findOrFail($request->seat_id);

        foreach ($seat->bookings as $booking) {
            if ($booking->trip_id == $trip->id) {
                $bFrom = $booking->from_station_order;
                $bTo = $booking->to_station_order;
                if ($fromOrder < $bTo && $toOrder > $bFrom) {
                    return response()->json(['message' => 'Seat is already booked in that range.'], 409);
                }
            }
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'trip_id' => $trip->id,
            'seat_id' => $seat->id,
            'from_city_id' => $request->from_station_id,
            'to_city_id' => $request->to_station_id,
            'from_station_order' => $fromOrder,
            'to_station_order' => $toOrder,
        ]);

        return response()->json(['message' => 'Booking created successfully.', 'booking' => $booking], 201);
    }
}

