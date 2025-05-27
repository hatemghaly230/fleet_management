@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Trip Stations for Trip: {{ $trip->fromCity->name }} to {{ $trip->toCity->name }} (Date: {{ $trip->date->format('Y-m-d') }})</h2>

    <a href="{{ route('admin.trip_stations.create', $trip->id) }}" class="btn btn-success mb-3">Add Station</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($tripStations->isEmpty())
        <p>No stations added yet.</p>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tripStations as $station)
                <tr>
                    <td>{{ $station->station_order }}</td>
                    <td>{{ $station->city->name }}</td>
                    <td>
                        <a href="{{ route('admin.trip_stations.edit', [$trip->id, $station->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('admin.trip_stations.destroy', [$trip->id, $station->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary mt-3">Back to Trips</a>
</div>
@endsection
