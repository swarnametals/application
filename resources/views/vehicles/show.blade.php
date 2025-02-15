@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')
<div class="container">
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

    <div id="successMessage" class="alert alert-success" style="display: none;"></div>

    <h2 class="mb-4">Vehicle: {{ $vehicle->registration_number }} | Vehicle Type: {{ $vehicle->vehicle_type }} | Driver: {{ $vehicle->driver ?? '-' }}</h2>

    <div class="d-flex flex-column flex-md-row gap-2 mb-3">
        <a href="{{ route('vehicle_logs.create', $vehicle->id) }}" class="btn add" style="background-color:#510404; color: #fff;">
            <i class="fas fa-plus-circle"></i> Add Vehicle Trip
        </a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="fas fa-file-alt"></i> Generate Vehicle Report
        </button>
        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>


    <h2 class="mt-4">Vehicle Trips</h2>

    {{-- //This should be well implemented as a later update. Solve the compflict between the pagination and search functionality. --}}
    {{-- <form action="{{ route('vehicles.show', $vehicle->id) }}" method="GET" class="mb-4">
        <div class="row g-3">
            <!-- Month Filter -->
            <div class="col-12 col-md-4">
                <label for="month" class="form-label">Filter by Month</label>
                <select class="form-control" id="month" name="month" onchange="this.form.submit()">
                    <option value="">All Months</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Year Filter -->
            <div class="col-12 col-md-4">
                <label for="year" class="form-label">Filter by Year</label>
                <select class="form-control" id="year" name="year" onchange="this.form.submit()">
                    <option value="">All Years</option>
                    @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Submit Button for Non-JS Users -->
            <div class="col-12 col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form> --}}

    @if ($vehicleLogs->isEmpty())
        <div class="alert alert-warning">No trips available for this vehicle.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Departure Date</th>
                        <th>Return Date</th>
                        <th>Start Km</th>
                        <th>Close Km</th>
                        <th>Distance Travelled</th>
                        <th>Location</th>
                        <th>Material Delivered</th>
                        <th>Material Qty (tonnes)</th>
                        <th>Fuel Logs</th>
                        <th>Total Fuel Used</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicleLogs as $log)
                        <tr>
                            <td>{{ $log->departure_date }}</td>
                            <td>{{ $log->return_date ?? '-' }}</td>
                            <td>{{ number_format($log->start_kilometers) }}</td>
                            <td>{{ $log->end_kilometers ? number_format($log->end_kilometers) : '-' }}</td>
                            <td>{{ $log->distance_travelled ? number_format($log->distance_travelled) : '-' }} km</td>
                            <td>{{ $log->location }}</td>
                            <td>{{ $log->material_delivered ?? '-' }}</td>
                            <td>{{ $log->quantity ?? '-' }}</td>
                            <td>
                                @if ($log->fuelLogs->isEmpty())
                                    <span class="text-muted">No fuel data</span>
                                @else
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($log->fuelLogs as $fuelLog)
                                            <li>{{ $fuelLog->litres_added }} Litres at {{ $fuelLog->refuel_location ?? '-' }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>
                                {{ number_format($log->fuelLogs->sum('litres_added'),2) ?? '0.00' }} Litres
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <button class="btn btn-sm btn-warning updateTripBtn" data-bs-toggle="modal" data-bs-target="#updateTripModal" data-log-id="{{ $log->id }}">Update</button>
                                    <button class="btn btn-sm btn-success addFuelLogBtn" data-bs-toggle="modal" data-bs-target="#fuelLogModal" data-log-id="{{ $log->id }}">Add Fuel Log</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <div class="d-flex justify-content-center mt-3">
                {{ $vehicleLogs->links() }}
            </div> --}}
            {{-- <div class="d-flex justify-content-center mt-3">
                {{ $vehicleLogs->appends(request()->query())->links() }}
            </div> --}}

            <div class="d-flex justify-content-center mt-3">
                {{ $vehicleLogs->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        </div>
    @endif
</div>

<!-- Fuel Log Modal -->
<div class="modal fade" id="fuelLogModal" tabindex="-1" aria-labelledby="fuelLogModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fuelLogModalLabel">Add Fuel Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="fuelLogForm">
                    @csrf
                    <input type="hidden" name="vehicle_log_id" id="vehicleLogId">

                    <div class="mb-3">
                        <label for="litres_added" class="form-label">Litres Added <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="litres_added" id="litres_added" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="refuel_location" class="form-label">Refuel Location</label>
                        <input type="text" name="refuel_location" id="refuel_location" class="form-control" placeholder="Example: MT Meru Kitwe, Site">
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Fuel Log</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Trip Modal -->
<div class="modal fade" id="updateTripModal" tabindex="-1" aria-labelledby="updateTripModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTripModalLabel">Edit Trip Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateTripForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="vehicle_id" id="updateVehicleId">
                    <input type="hidden" name="log_id" id="updateLogId">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                            <input type="date" name="departure_date" id="departure_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="return_date" class="form-label">Return Date</label>
                            <input type="date" name="return_date" id="return_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_kilometers" class="form-label">Start Kilometers <span class="text-danger">*</span></label>
                            <input type="number" name="start_kilometers" id="start_kilometers" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_kilometers" class="form-label">End Kilometers</label>
                            <input type="number" name="end_kilometers" id="end_kilometers" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="location" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="material_delivered" class="form-label">Material Delivered</label>
                            <input type="text" name="material_delivered" id="material_delivered" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity (tonnes)</label>
                            <input type="number" step="0.01" name="quantity" id="quantity" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Update Trip</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Generate Vehicle Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reports.generate') }}" method="POST">
                    @csrf
                    <input type="hidden" id="vehicle_id" name="vehicle_id" value="{{ $vehicle->id }}">
                    <input type="hidden" id="format" name="format" value="csv">

                    <div class="mb-3">
                        <label for="month" class="form-label">Select Month</label>
                        <select class="form-control" id="month" name="month" required>
                            <option value="">Select Month</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year</label>
                        <select class="form-control" id="year" name="year" required>
                            <option value="">Select Year</option>
                            @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generate Report</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Add Fuel Log
        $('.addFuelLogBtn').on('click', function () {
            let logId = $(this).data('log-id');
            $('#vehicleLogId').val(logId);
        });

        $('#fuelLogForm').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('fuel_logs.store') }}",
                type: "POST",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert("Failed to add fuel log.");
                    }
                },
                error: function () {
                    alert("An error occurred. Please try again.");
                }
            });
        });

        // Update Trip
        $('.updateTripBtn').on('click', function () {
            let logId = $(this).data('log-id');
            $('#updateLogId').val(logId);

            // Fetch trip data via AJAX
            $.ajax({
                url: `/vehicle-logs/${logId}/edit`,
                type: "GET",
                success: function (response) {
                    $('#departure_date').val(response.departure_date);
                    $('#return_date').val(response.return_date);
                    $('#start_kilometers').val(response.start_kilometers);
                    $('#end_kilometers').val(response.end_kilometers);
                    $('#location').val(response.location);
                    $('#material_delivered').val(response.material_delivered);
                    $('#quantity').val(response.quantity);
                    $('#updateVehicleId').val(response.vehicle_id);
                },
                error: function () {
                    alert("An error occurred while fetching trip data.");
                }
            });
        });

        $('#updateTripForm').on('submit', function (e) {
            e.preventDefault();
            let logId = $('#updateLogId').val();
            let formData = $(this).serializeArray();
            let jsonData = {};

            $.each(formData, function () {
                jsonData[this.name] = this.value;
            });

            $.ajax({
                url: `/vehicle-logs/${logId}`,
                type: "PUT",
                data: JSON.stringify(jsonData),
                contentType: "application/json",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Display success message on the page
                        $('#successMessage').text(response.message).fadeIn().delay(3000).fadeOut();

                        $('#updateTripModal').modal('hide');

                        // Optionally reload after delay
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    } else {
                        alert("Failed to update trip.");
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "<ul>";
                        $.each(errors, function (key, messages) {
                            errorMessage += `<li>${messages[0]}</li>`;
                        });
                        errorMessage += "</ul>";

                        $('#successMessage').removeClass("alert-success").addClass("alert-danger").html(errorMessage).fadeIn();
                    } else {
                        $('#successMessage').removeClass("alert-success").addClass("alert-danger").text("An error occurred. Please try again.").fadeIn();
                    }
                }
            });
        });
    });
</script>
@endsection
