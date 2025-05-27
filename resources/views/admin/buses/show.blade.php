{{-- resources/views/admin/buses/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bus Details</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Bus Name: {{ $bus->name }}</h5>
            <p class="card-text"><strong>Number Plate:</strong> {{ $bus->number_plate }}</p>
            <p class="card-text"><strong>Seats:</strong> {{ $bus->seats_count }}</p>
            @if($bus->trip)
                <p class="card-text"><strong>Trip:</strong>
                    From {{ $bus->trip->fromCity->name }} to {{ $bus->trip->toCity->name }}
                    on {{ $bus->trip->date }}
                </p>
            @endif
        </div>
    </div>

    <h4>Seats</h4>
    @if($seats->isEmpty())
        <p>No seats found for this bus.</p>
    @else
        <div class="row">
            @foreach($seats as $seat)
                <div class="col-md-2 mb-2">
                    <div class="card text-center">
                        <div class="card-body p-2">
                            Seat: {{ $seat->seat_number }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('admin.buses.index') }}" class="btn btn-secondary mt-3">Back to list</a>
</div>
@endsection
