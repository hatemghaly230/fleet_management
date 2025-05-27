@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Bookings</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bookings->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Trip</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Seat</th>
                    <th>Booking Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->trip->fromCity->name ?? '' }} → {{ $booking->trip->toCity->name ?? '' }}</td>
                        <td>{{ $booking->fromCity->name }}</td>
                        <td>{{ $booking->toCity->name }}</td>
                        <td>{{ $booking->seat->seat_number }}</td>
                        <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('user.bookings.show', $booking->id) }}" class="btn btn-primary btn-sm">Details</a>
                            {{-- ممكن تضيف زر إلغاء أو تعديل هنا لو حابب --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $bookings->links() }}
    @else
        <p>You have no bookings yet.</p>
    @endif
</div>
@endsection
