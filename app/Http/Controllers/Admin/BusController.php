<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Trip;
use App\Models\Seat;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with('trip')->latest()->get();
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        $trips = Trip::all();
        return view('admin.buses.create', compact('trips'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'name' => 'required|unique:buses,name',
            'number_plate' => 'required|unique:buses,number_plate',
            'seats' => 'required|integer|min:1|max:100',
        ]);

        $bus = Bus::create($request->only('trip_id', 'name', 'number_plate', 'seats'));

        // إنشاء مقاعد تلقائيًا
        for ($i = 1; $i <= $bus->seats; $i++) {
            Seat::create([
                'bus_id' => $bus->id,
                'seat_number' => 'A' . $i,
            ]);
        }

        return redirect()->route('admin.buses.index')->with('success', 'Bus created successfully with seats.');
    }

public function show(Bus $bus)
{
    $bus->load(['trip.fromCity', 'trip.toCity', 'busSeats']);
    return view('admin.buses.show', [
        'bus' => $bus,
        'seats' => $bus->busSeats,  // هنا مجموعة المقاعد، وليس count()
    ]);
}


    public function edit(Bus $bus)
    {
        $trips = Trip::all();
        return view('admin.buses.edit', compact('bus', 'trips'));
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'name' => 'required|unique:buses,name,' . $bus->id,
            'number_plate' => 'required|unique:buses,number_plate,' . $bus->id,
            'seats' => 'required|integer|min:1|max:100',
        ]);

        $bus->update($request->only('trip_id', 'name', 'number_plate', 'seats'));

        return redirect()->route('admin.buses.index')->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->route('admin.buses.index')->with('success', 'Bus deleted successfully.');
    }
}
