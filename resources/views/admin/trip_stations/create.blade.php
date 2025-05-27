@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add Station to Trip: {{ $trip->fromCity->name }} to {{ $trip->toCity->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.trip_stations.store', $trip->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="city_id" class="form-label">City</label>
            <select name="city_id" id="city_id" class="form-select" required>
                <option value="">Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="station_order" class="form-label">Station Order</label>
            <input type="number" name="station_order" id="station_order" class="form-control" min="1" value="{{ old('station_order', 1) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Station</button>
        <a href="{{ route('admin.trip_stations.index', $trip->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
