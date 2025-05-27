@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Trips List</h2>

    <a href="{{ route('admin.trips.create') }}" class="btn btn-primary mb-3">Add New Trip</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>From City</th>
                <th>To City</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trips as $trip)
                <tr>
                    <td>{{ $trip->id }}</td>
                    <td>{{ $trip->fromCity->name }}</td>
                    <td>{{ $trip->toCity->name }}</td>
                    <td>{{ $trip->date->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.trips.edit', $trip) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>

                        {{-- زر إدارة المحطات --}}
                        <a href="{{ route('admin.trip_stations.index', $trip) }}" class="btn btn-sm btn-info">
                            Manage Stations
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
