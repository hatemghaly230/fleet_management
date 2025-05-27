@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Buses</h1>

    <a href="{{ route('admin.buses.create') }}" class="btn btn-primary mb-3">Add New Bus</a>

    @if($buses->isEmpty())
        <p>No buses found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Number Plate</th>
                    <th>Seats</th>
                    <th>Trip</th>
                    <th>Actions</th> {{-- ← العمود الجديد --}}
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                    <tr>
                        <td>{{ $bus->id }}</td>
                        <td>{{ $bus->name }}</td>
                        <td>{{ $bus->number_plate }}</td>
                        <td>{{ $bus->seats }}</td>
                        <td>{{ $bus->trip->fromCity->name }} → {{ $bus->trip->toCity->name }}</td>
                        <td>
                            <a href="{{ route('admin.buses.show', $bus->id) }}" class="btn btn-sm btn-info">Show</a>
                            <a href="{{ route('admin.buses.edit', $bus->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.buses.destroy', $bus->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this bus?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
