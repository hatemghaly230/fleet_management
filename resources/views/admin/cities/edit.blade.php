@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit City</h2>
    <form action="{{ route('admin.cities.update', $city) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">City Name</label>
            <input type="text" name="name" class="form-control" value="{{ $city->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
