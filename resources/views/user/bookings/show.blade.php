@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Booking Details</h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Trip:</strong> {{ $booking->trip->fromCity->name ?? '' }} → {{ $booking->trip->toCity->name ?? '' }}</li>
        <li class="list-group-item"><strong>From:</strong> {{ $booking->fromCity->name }}</li>
        <li class="list-group-item"><strong>To:</strong> {{ $booking->toCity->name }}</li>
        <li class="list-group-item"><strong>Seat Number:</strong> {{ $booking->seat->seat_number }}</li>
        <li class="list-group-item"><strong>Booking Date:</strong> {{ $booking->created_at->format('Y-m-d H:i') }}</li>
    </ul>

    <a href="{{ route('user.bookings.index') }}" class="btn btn-secondary mt-3">Back to bookings</a>
</div>
@endsection
