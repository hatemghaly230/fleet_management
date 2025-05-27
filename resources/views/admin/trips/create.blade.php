@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Create New Trip</h2>

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

    <form action="{{ route('admin.trips.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="from_city_id" class="form-label">From City</label>
            <select name="from_city_id" id="from_city_id" class="form-select" required>
                <option value="" disabled selected>Select from city</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('from_city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="to_city_id" class="form-label">To City</label>
            <select name="to_city_id" id="to_city_id" class="form-select" required>
                <option value="" disabled selected>Select to city</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('to_city_id') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Trip Date</label>
            <input type="date" name="date" id="date" class="form-control" required value="{{ old('date') }}">
        </div>

        <button type="submit" class="btn btn-primary">Create Trip</button>
        <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
