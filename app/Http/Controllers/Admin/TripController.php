<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\City;
use Illuminate\Http\Request;

class TripController extends Controller
{
    // Show all trips
    public function index()
    {
        // Load trips with city names (from and to) using relationships
        $trips = Trip::with(['fromCity', 'toCity'])->get();
        return view('admin.trips.index', compact('trips'));
    }

    // Show create form
    public function create()
    {
        $cities = City::all();
        return view('admin.trips.create', compact('cities'));
    }

    // Store new trip
    public function store(Request $request)
    {
        $request->validate([
            'from_city_id' => 'required|exists:cities,id|different:to_city_id',
            'to_city_id' => 'required|exists:cities,id',
            'date' => 'required|date',
        ]);

        Trip::create($request->all())->except(['_token']);

        return redirect()->route('admin.trips.index')->with('success', 'Trip created successfully.');
    }

    // Show edit form
    public function edit(Trip $trip)
    {
        $cities = City::all();
        return view('admin.trips.edit', compact('trip', 'cities'));
    }

    // Update trip
    public function update(Request $request, Trip $trip)
    {
        $request->validate([
            'from_city_id' => 'required|exists:cities,id|different:to_city_id',
            'to_city_id' => 'required|exists:cities,id',
            'date' => 'required|date',
        ]);

        $trip->update($request->all());

        return redirect()->route('admin.trips.index')->with('success', 'Trip updated successfully.');
    }

    // Delete trip
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('admin.trips.index')->with('success', 'Trip deleted successfully.');
    }
}
