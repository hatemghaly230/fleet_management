@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Bookings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Trip</th>
                <th>From</th>
                <th>To</th>
                <th>Seat</th>
                <th>Booking Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->trip->fromCity->name }} → {{ $booking->trip->toCity->name }}</td>
                    <td>{{ $booking->fromStation->city->name ?? '-' }}</td>
                    <td>{{ $booking->toStation->city->name ?? '-' }}</td>
                    <td>{{ $booking->seat->seat_number ?? '-' }}</td>
                    <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                    <td>
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
