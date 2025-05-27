@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Booking</h2>
    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
        @csrf @method('PUT')
        <!-- Add fields to update booking -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
