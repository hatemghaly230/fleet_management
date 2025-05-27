@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Bus</h1>
    <form action="{{ route('admin.buses.update', $bus->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="trip_id" class="form-label">Trip</label>
            <select name="trip_id" class="form-control">
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}" {{ $bus->trip_id == $trip->id ? 'selected' : '' }}>
                        {{ $trip->fromCity->name }} - {{ $trip->toCity->name }} ({{ $trip->date }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $bus->name }}" required>
        </div>
        <div class="mb-3">
            <label for="number_plate" class="form-label">Number Plate</label>
            <input type="text" name="number_plate" class="form-control" value="{{ $bus->number_plate }}" required>
        </div>
        <div class="mb-3">
            <label for="seats" class="form-label">Seats</label>
            <input type="number" name="seats" class="form-control" value="{{ $bus->seats }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
