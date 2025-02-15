@extends('layouts.app')

@section('title', 'Add Vehicle Log')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Trip Information for Vehicle: {{ $vehicle->registration_number }}</h2>

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

    <small class="text-danger">Inputs marked with an asterisk (<span class="text-danger"> * </span>) are mandatory</small>

    <form action="{{ route('vehicle_logs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                <input type="date" name="departure_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="return_date" class="form-label">Return Date</label>
                <input type="date" name="return_date" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="start_kilometers" class="form-label">Start Kilometers<span class="text-danger">*</span></label>
                <input type="number" name="start_kilometers" id="start_kilometers" class="form-control"
                       placeholder="example: 54666" value="{{ $lastEndKilometers }}" required readonly>
            </div>
            <div class="col-md-6">
                <label for="end_kilometers" class="form-label">Close Kilometers</label>
                <input type="number" name="end_kilometers" class="form-control" placeholder="example: 54777">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                <input type="text" name="location" class="form-control" placeholder="example: Kasempa, Serenje, Ndola, Solwezi..." required>
            </div>
            <div class="col-md-6">
                <label for="material_delivered" class="form-label">Material Delivered</label>
                <input type="text" name="material_delivered" class="form-control" placeholder="example: copper ore, quary, blocks...">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <label for="quantity" class="form-label">Quantity (tonnes)</label>
                <input type="number" step="0.01" name="quantity" class="form-control" placeholder="example: 60, 25 ...">
            </div>
        </div>

        <h4 class="mt-4">Fuel Information</h4>

        <div class="mb-3">
            <label for="litres_added" class="form-label">Litres Added (Litres) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="litres_added" class="form-control" placeholder="example: 60" required>
        </div>

        <div class="mb-3">
            <label for="refuel_location" class="form-label">Refuel Location</label>
            <input type="text" name="refuel_location" class="form-control" placeholder="example: SITE, KALULUSHI STATION, CHIMWEMWE STATION ...">
        </div>

        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Save Vehicle Trip & Fuel Log
        </button>

    </form>
</div>
@endsection
