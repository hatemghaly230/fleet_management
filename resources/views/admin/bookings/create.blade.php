@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Create New Booking</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="bookingForm" action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf

        {{-- Select Trip --}}
        <div class="mb-3">
            <label for="trip_id" class="form-label">Select Trip</label>
            <select id="trip_id" name="trip_id" class="form-select" required>
                <option value="">-- Select Trip --</option>
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}" {{ old('trip_id') == $trip->id ? 'selected' : '' }}>
                        {{ $trip->fromCity->name }} ➔ {{ $trip->toCity->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Select Start Station --}}
        <div class="mb-3">
            <label for="start_station_id" class="form-label">Start Station</label>
            <select id="start_station_id" name="start_station_id" class="form-select" required disabled>
                <option value="">-- Select Start Station --</option>
            </select>
        </div>

        {{-- Select End Station --}}
        <div class="mb-3">
            <label for="end_station_id" class="form-label">End Station</label>
            <select id="end_station_id" name="end_station_id" class="form-select" required disabled>
                <option value="">-- Select End Station --</option>
            </select>
        </div>

        {{-- Available Seats --}}
        <div class="mb-3">
            <label for="seat_id" class="form-label">Available Seats</label>
            <select id="seat_id" name="seat_id" class="form-select" required disabled>
                <option value="">-- Select Seat --</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" disabled id="submitBtn">Book Seat</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

{{-- Scripts to dynamically load stations and seats --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tripSelect = document.getElementById('trip_id');
        const startSelect = document.getElementById('start_station_id');
        const endSelect = document.getElementById('end_station_id');
        const seatSelect = document.getElementById('seat_id');
        const submitBtn = document.getElementById('submitBtn');

        tripSelect.addEventListener('change', async () => {
            const tripId = tripSelect.value;
            resetSelect(startSelect);
            resetSelect(endSelect);
            resetSelect(seatSelect);
            disableSelect(startSelect, true);
            disableSelect(endSelect, true);
            disableSelect(seatSelect, true);
            submitBtn.disabled = true;

            if (!tripId) return;

            // Fetch stations for the selected trip
            const res = await fetch(`/admin/api/trips/${tripId}/stations`);
            const data = await res.json();

            if(data.stations && data.stations.length > 0){
                enableSelect(startSelect, true);
                data.stations.forEach(station => {
                    const option = document.createElement('option');
                    option.value = station.id;
                    option.textContent = station.name;
                    startSelect.appendChild(option);
                });
            }
        });

        startSelect.addEventListener('change', async () => {
            const tripId = tripSelect.value;
            const startId = startSelect.value;
            resetSelect(endSelect);
            resetSelect(seatSelect);
            disableSelect(endSelect, true);
            disableSelect(seatSelect, true);
            submitBtn.disabled = true;

            if (!startId) return;

            // Fetch possible end stations (those stations that come after start)
            const res = await fetch(`/admin/api/trips/${tripId}/stations-after/${startId}`);
            const data = await res.json();

            if(data.stations && data.stations.length > 0){
                enableSelect(endSelect, true);
                data.stations.forEach(station => {
                    const option = document.createElement('option');
                    option.value = station.id;
                    option.textContent = station.name;
                    endSelect.appendChild(option);
                });
            }
        });

        endSelect.addEventListener('change', async () => {
            const tripId = tripSelect.value;
            const startId = startSelect.value;
            const endId = endSelect.value;
            resetSelect(seatSelect);
            disableSelect(seatSelect, true);
            submitBtn.disabled = true;

            if (!endId) return;

            // Fetch available seats for this trip segment
            const res = await fetch(`/admin/api/trips/${tripId}/available-seats?start_station_id=${startId}&end_station_id=${endId}`);
            const data = await res.json();

            if(data.seats && data.seats.length > 0){
                enableSelect(seatSelect, true);
                data.seats.forEach(seat => {
                    const option = document.createElement('option');
                    option.value = seat.id;
                    option.textContent = `Seat #${seat.seat_number}`;
                    seatSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.textContent = 'No seats available';
                seatSelect.appendChild(option);
            }

            submitBtn.disabled = data.seats.length === 0;
        });

        function resetSelect(select) {
            select.innerHTML = '<option value="">-- Select --</option>';
        }

        function disableSelect(select, disable) {
            select.disabled = disable;
        }

        function enableSelect(select, enable) {
            select.disabled = !enable;
        }
    });
</script>
@endsection
