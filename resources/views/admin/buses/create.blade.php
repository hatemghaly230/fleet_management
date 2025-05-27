@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Bus</h1>
    <form action="{{ route('admin.buses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="trip_id" class="form-label">Trip</label>
            <select name="trip_id" class="form-control">
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}">
                        {{ $trip->fromCity->name }} - {{ $trip->toCity->name }} ({{ $trip->date }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="number_plate" class="form-label">Number Plate</label>
            <input type="text" name="number_plate" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="seats" class="form-label">Seats</label>
            <input type="number" name="seats" class="form-control" value="12" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
