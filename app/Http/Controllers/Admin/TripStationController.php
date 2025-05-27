<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripStation;
use App\Models\Trip;
use App\Models\City;
use Illuminate\Http\Request;

class TripStationController extends Controller
{
    public function index($tripId)
    {
        $trip = Trip::with(['fromCity', 'toCity'])->findOrFail($tripId);
        $tripStations = TripStation::where('trip_id', $tripId)
            ->with('city')
            ->orderBy('station_order')
            ->get();

        return view('admin.trip_stations.index', compact('trip', 'tripStations'));
    }

    public function create($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        $cities = City::all();

        return view('admin.trip_stations.create', compact('trip', 'cities'));
    }

    public function store(Request $request, $tripId)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'station_order' => 'required|integer|min:1',
        ]);

        // Prevent duplicate city for the same trip
        $exists = TripStation::where('trip_id', $tripId)
            ->where('city_id', $request->city_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['city_id' => 'This city is already added to this trip.'])->withInput();
        }

        TripStation::create([
            'trip_id' => $tripId,
            'city_id' => $request->city_id,
            'station_order' => $request->station_order,
        ]);

        return redirect()->route('admin.trip_stations.index', $tripId)->with('success', 'Trip station added successfully.');
    }

    public function edit($tripId, TripStation $tripStation)
    {
        $trip = Trip::findOrFail($tripId);
        $cities = City::all();

        return view('admin.trip_stations.edit', compact('tripStation', 'trip', 'cities'));
    }

    public function update(Request $request, $tripId, TripStation $tripStation)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'station_order' => 'required|integer|min:1',
        ]);

        $tripStation->update($request->only(['city_id', 'station_order']));

        return redirect()->route('admin.trip_stations.index', $tripId)->with('success', 'Trip station updated successfully.');
    }

    public function destroy($tripId, TripStation $tripStation)
    {
        $tripStation->delete();
        return redirect()->route('admin.trip_stations.index', $tripId)->with('success', 'Trip station deleted successfully.');
    }
}
