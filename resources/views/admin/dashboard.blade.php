@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-3 mb-2">
            <a href="{{ route('admin.cities.index') }}" class="btn btn-outline-primary w-100">Manage Cities</a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="{{ route('admin.trips.index') }}" class="btn btn-outline-primary w-100">Manage Trips</a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-primary w-100">Manage Buses</a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary w-100">Manage Bookings</a>
        </div>
    </div>
</div>
@endsection
