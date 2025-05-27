@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Trip Search Results</h2>

    <a href="{{ route('user.bookings.create') }}" class="btn btn-secondary mb-3">New Search</a>

    @if ($trips->isEmpty())
        <p>No trips available for the selected date and route.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Trip Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trips as $trip)
                    <tr>
                        <td>{{ $trip->name ?? 'Trip' }}</td>
                        <td>{{ $trip->tripStations->firstWhere('city_id', $fromCityId)->city->name }}</td>
                        <td>{{ $trip->tripStations->firstWhere('city_id', $toCityId)->city->name }}</td>
                        <td>{{ $trip->date->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('user.bookings.seats', ['trip' => $trip->id, 'from' => $fromCityId, 'to' => $toCityId]) }}" class="btn btn-success">
                                Select Seat
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
