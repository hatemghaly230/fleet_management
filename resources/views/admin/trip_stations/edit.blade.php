@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Station for Trip: {{ $trip->fromCity->name }} to {{ $trip->toCity->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.trip_stations.update', [$trip->id, $tripStation->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="city_id" class="form-label">City</label>
            <select name="city_id" id="city_id" class="form-select" required>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $tripStation->city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="station_order" class="form-label">Station Order</label>
            <input type="number" name="station_order" id="station_order" class="form-control" min="1" value="{{ $tripStation->station_order }}" required>
        </div>

        <button type="submit
