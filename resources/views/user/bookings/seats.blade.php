@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Book Your Seat</h2>

    <p>
        <strong>Trip:</strong> From
        {{ $trip->tripStations->where('city_id', $fromCityId)->first()->city->name ?? 'Start' }}
        to
        {{ $trip->tripStations->where('city_id', $toCityId)->first()->city->name ?? 'End' }}
        on {{ \Carbon\Carbon::parse($trip->date)->format('F j, Y') }}
    </p>

    <form action="{{ route('user.bookings.store') }}" method="POST">
        @csrf

        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
        <input type="hidden" name="from_city_id" value="{{ $fromCityId }}">
        <input type="hidden" name="to_city_id" value="{{ $toCityId }}">

        <div class="mb-3">
            <label for="seat_id" class="form-label">Select Seat:</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($trip->buses->flatMap->busSeats as $seat)
                    @php
                        // تحقق إذا المقعد محجوز (مثلاً عن طريق جلب الحجوزات بالكنترولر)
                        $isBooked = false; // استبدل هذا بالتحقق الفعلي إذا ممكن
                    @endphp

                    <button
                        type="button"
                        class="btn btn-outline-primary seat-btn {{ $isBooked ? 'disabled btn-danger' : '' }}"
                        data-seat-id="{{ $seat->id }}"
                        @if($isBooked) disabled @endif
                    >
                        {{ $seat->seat_number }}
                    </button>
                @endforeach
            </div>
            <input type="hidden" name="seat_id" id="seat_id" required>
            @error('seat_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Book Seat</button>
    </form>
</div>

<script>
    // اجعل زر اختيار المقعد يملأ القيمة في الحقل المخفي seat_id
    document.querySelectorAll('.seat-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (this.classList.contains('disabled')) return;

            // إزالة التحديد من كل الأزرار
            document.querySelectorAll('.seat-btn').forEach(btn => btn.classList.remove('active'));

            // إضافة التحديد للزر المضغوط
            this.classList.add('active');

            // حفظ القيمة في الحقل المخفي
            document.getElementById('seat_id').value = this.getAttribute('data-seat-id');
        });
    });
</script>

<style>
    .seat-btn {
        min-width: 50px;
    }
    .seat-btn.active {
        background-color: #0d6efd;
        color: white;
    }
    .seat-btn.disabled {
        pointer-events: none;
        opacity: 0.6;
    }
</style>

@endsection
