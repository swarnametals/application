@extends('layouts.app')

@section('title', 'Edit Vehicle')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Vehicle</h2>
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
    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="registration_number" class="form-label">Registration Number<span class="text-danger">*</span></label>
            <input type="text" name="registration_number" class="form-control" value="{{ $vehicle->registration_number }}" required>
        </div>
        <div class="mb-3">
            <label for="vehicle_type" class="form-label">Vehicle Type<span class="text-danger">*</span></label>
            <select name="vehicle_type" class="form-control" id="vehicle_type" required onchange="toggleOtherInput()">
                <option value="{{ $vehicle->vehicle_type }}">{{ $vehicle->vehicle_type }}</option>
                <option value="Tipper">Tipper</option>
                <option value="Hilux">Hilux</option>
                <option value="Machinery">Machinery</option>
                <option value="Low bed">Low Bed</option>
                <option value="Water Bowser">Water Bowser</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-3" id="other_vehicle_type_div" style="display: none;">
            <label for="other_vehicle_type" class="form-label">Specify Vehicle Type</label>
            <input type="text" name="other_vehicle_type" id="other_vehicle_type" class="form-control">
        </div>
        <div class="mb-3">
            <label for="driver" class="form-label">Driver</label>
            <input type="text" name="driver" class="form-control" value="{{ $vehicle->driver }}" >
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    function toggleOtherInput() {
        var select = document.getElementById("vehicle_type");
        var otherInputDiv = document.getElementById("other_vehicle_type_div");
        var otherInput = document.getElementById("other_vehicle_type");

        if (select.value === "Other") {
            otherInputDiv.style.display = "block";
            otherInput.required = true;
        } else {
            otherInputDiv.style.display = "none";
            otherInput.required = false;
        }
    }
</script>
@endsection
