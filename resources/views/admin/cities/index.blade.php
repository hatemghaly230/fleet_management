@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Cities</h2>
        <a href="{{ route('admin.cities.create') }}" class="btn btn-success">Add City</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 5%;">#</th>
                <th scope="col">Name</th>
                <th scope="col" style="width: 20%;" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cities as $city)
            <tr>
                <th scope="row">{{ $city->id }}</th>
                <td>{{ $city->name }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.cities.edit', $city) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.cities.destroy', $city) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted">No cities found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
