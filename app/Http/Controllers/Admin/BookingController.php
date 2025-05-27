<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bus;
use App\Models\City;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'trip.fromCity', 'trip.toCity', 'fromStation.city', 'toStation.city', 'seat'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function userIndex()
    {
        // Get current user's bookings with related data for display
        $bookings = auth()->user()->bookings()->with(['trip', 'seat', 'fromCity', 'toCity'])->paginate(10);
        return view('user.bookings.index', compact('bookings'));
    }

    // Booking homepage - select cities and date
    public function create()
    {
        $cities = City::orderBy('name')->get();
        return view('user.bookings.create', compact('cities'));
    }

    // Search for available trips based on user input
    public function search(Request $request)
    {
        $request->validate([
            'from_city_id' => 'required|exists:cities,id',
            'to_city_id' => 'required|exists:cities,id|different:from_city_id',
            'date' => 'required|date',
        ]);

        $fromCityId = $request->from_city_id;
        $toCityId = $request->to_city_id;
        $date = $request->date;

        // Get trips that contain both cities and match the date
        $trips = Trip::where('date', $date)
            ->whereHas('tripStations', function ($query) use ($fromCityId, $toCityId) {
                // The trip must contain both stations (from before to)
                $query->whereIn('city_id', [$fromCityId, $toCityId]);
            })
            ->with(['tripStations' => function ($query) {
                $query->orderBy('station_order');
            }])
            ->get()
            ->filter(function ($trip) use ($fromCityId, $toCityId) {
                // Ensure station order is correct: from before to
                $stations = $trip->tripStations->pluck('city_id')->toArray();
                return array_search($fromCityId, $stations) < array_search($toCityId, $stations);
            });

        return view('user.bookings.search_results', compact('trips', 'fromCityId', 'toCityId', 'date'));
    }

    public function seats(Request $request)
    {
        $tripId = $request->query('trip');        // from trip_id
        $fromCityId = $request->query('from');    // from_city_id
        $toCityId = $request->query('to');        // to_city_id

        // Load trip data and seats for view
        $trip = Trip::with(['tripStations', 'buses.busSeats'])->findOrFail($tripId);

        return view('user.bookings.seats', [
            'trip' => $trip,
            'fromCityId' => $fromCityId,
            'toCityId' => $toCityId,
        ]);
    }

    public function store(Request $request)
    {
        // Validate incoming form data
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'from_city_id' => 'required|exists:cities,id',
            'to_city_id' => 'required|exists:cities,id',
            'seat_id' => 'required|exists:seats,id',
        ]);

        // Check if the seat is already booked for this route
        $exists = Booking::where('seat_id', $request->seat_id)
            ->where('trip_id', $request->trip_id)
            ->where('from_city_id', $request->from_city_id)
            ->where('to_city_id', $request->to_city_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['seat_id' => 'This seat is already booked for the selected route.'])->withInput();
        }

        // Load trip and get station orders
        $trip = Trip::with('tripStations')->findOrFail($request->trip_id);
        $stations = $trip->tripStations->keyBy('city_id');
        $fromOrder = $stations[$request->from_city_id]->station_order ?? null;
        $toOrder = $stations[$request->to_city_id]->station_order ?? null;

        // Create booking and link to current user
        Booking::create([
            'user_id' => auth()->id(),
            'trip_id' => $request->trip_id,
            'seat_id' => $request->seat_id,
            'from_city_id' => $request->from_city_id,
            'to_city_id' => $request->to_city_id,
            'from_station_order' => $fromOrder,       // Save order here
            'to_station_order' => $toOrder,           // Save order here
        ]);

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function userShow(\App\Models\Booking $booking)
    {
        // $this->authorize('view', $booking); // If using policies (optional)

        $booking->load(['trip.fromCity', 'trip.toCity', 'seat', 'fromCity', 'toCity']);
        return view('user.bookings.show', compact('booking'));
    }
}
