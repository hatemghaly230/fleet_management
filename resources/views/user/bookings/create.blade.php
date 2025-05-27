@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Search for a Trip</h2>

    <form action="{{ route('user.bookings.search') }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="from_city_id" class="form-label">From City:</label>
            <select name="from_city_id" id="from_city_id" class="form-control" required>
                <option value="">Select a city</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('from_city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('from_city_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="to_city_id" class="form-label">To City:</label>
            <select name="to_city_id" id="to_city_id" class="form-control" required>
                <option value="">Select a city</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('to_city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('to_city_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Trip Date:</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') ?? date('Y-m-d') }}" required>
            @error('date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>
@endsection
