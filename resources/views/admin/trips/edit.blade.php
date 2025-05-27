@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Trip</h2>

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.trips.update', $trip) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="from_city_id" class="form-label">From City</label>
            <select name="from_city_id" id="from_city_id" class="form-select" required>
                <option value="">Select a city</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $trip->from_city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="to_city_id" class="form-label">To City</label>
            <select name="to_city_id" id="to_city_id" class="form-select" required>
                <option value="">Select a city</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $trip->to_city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Trip Date</label>
            <input type="date" name="date" id="date" class="form-control" required value="{{ old('date', $trip->date->format('Y-m-d')) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Trip</button>
        <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
