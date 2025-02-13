@extends('layouts.app')

@section('title', 'Edit Vehicle Log')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Trip Information for Vehicle: {{ $vehicleLog->vehicle->registration_number }}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('vehicle_logs.update', $vehicleLog->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="vehicle_id" value="{{ $vehicleLog->vehicle->id }}">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                <input type="date" name="departure_date" class="form-control" value="{{ $vehicleLog->departure_date }}" required>
            </div>
            <div class="col-md-6">
                <label for="return_date" class="form-label">Return Date</label>
                <input type="date" name="return_date" class="form-control" value="{{ $vehicleLog->return_date }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="start_kilometers" class="form-label">Start Kilometers <span class="text-danger">*</span></label>
                <input type="number" name="start_kilometers" class="form-control" value="{{ $vehicleLog->start_kilometers }}" required>
            </div>
            <div class="col-md-6">
                <label for="end_kilometers" class="form-label">End Kilometers</label>
                <input type="number" name="end_kilometers" class="form-control" value="{{ $vehicleLog->end_kilometers }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                <input type="text" name="location" class="form-control" value="{{ $vehicleLog->location }}" required>
            </div>
            <div class="col-md-6">
                <label for="material_delivered" class="form-label">Material Delivered</label>
                <input type="text" name="material_delivered" class="form-control" value="{{ $vehicleLog->material_delivered }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="quantity" class="form-label">Quantity (tonnes)</label>
                <input type="number" step="0.01" name="quantity" class="form-control" value="{{ $vehicleLog->quantity }}">
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update Vehicle Trip</button>
        <a href="{{ route('vehicles.show', $vehicleLog->vehicle_id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
