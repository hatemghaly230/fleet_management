@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New City</h2>
    <form action="{{ route('admin.cities.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">City Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
