<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:cities,name',
        ]);

        City::create($request->only('name'));

        return redirect()->route('admin.cities.index')->with('success', 'City created successfully.');
    }

    public function show(City $city)
    {
        return view('admin.cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|unique:cities,name,' . $city->id,
        ]);

        $city->update($request->only('name'));

        return redirect()->route('admin.cities.index')->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', 'City deleted successfully.');
    }
}
