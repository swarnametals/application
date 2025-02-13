@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
<div class="container">
    <a href="{{ route('dashboards.admin') }}" class="btn btn-secondary mb-4">Back to Dashboard</a>
    <h2 class="mb-4">Vehicles List</h2>

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

    <a href="{{ route('vehicles.create') }}" class="btn mb-3" style="background-color:#510404; color: #fff;">Register Vehicle</a>
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#reportModal">
        Generate Report For all Vehicles
    </button>

    <!-- Search Form Later Update-->
    {{-- <form action="{{ route('vehicles.index') }}" method="GET" class="mb-3">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by Reg Number, Type, or Driver" value="{{ request('search') }}">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-12 col-md-2">
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </div>
    </form> --}}

    <!-- Dropdown to select vehicle -->
    <div class="mb-3">
        <label for="vehicleSelect" class="form-label">Select a Vehicle:</label>
        <select id="vehicleSelect" class="form-select">
            <option value="">Select a Vehicle</option>
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }}</option>
            @endforeach
        </select>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Registration Number</th>
                    <th>Vehicle Type</th>
                    <th>Driver</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $vehicle)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $vehicle->registration_number }}</td>
                    <td>{{ $vehicle->vehicle_type }}</td>
                    <td>{{ $vehicle->driver }}</td>
                    <td>
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Vehicle Log Form -->
{{-- <div class="modal fade" id="logTripModal" tabindex="-1" aria-labelledby="logTripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logTripModalLabel">Register a Trip</h5>
                <button type="button" class="btn-close" id="btn_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vehicle_logs.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="vehicle_id" id="selectedVehicleId">

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                            <input type="date" name="departure_date" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="return_date" class="form-label">Return Date</label>
                            <input type="date" name="return_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="start_kilometers" class="form-label">Start Kilometers<span class="text-danger">*</span></label>
                            <input type="number" name="start_kilometers" class="form-control" placeholder="example: 54666" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="end_kilometers" class="form-label">Close Kilometers</label>
                            <input type="number" name="end_kilometers" class="form-control" placeholder="example: 54777">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control" placeholder="example: Kasempa, Serenje, Ndoa, Solwezi..." required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="material_delivered" class="form-label">Material Delivered</label>
                            <input type="text" name="material_delivered" class="form-control" placeholder="example: copper ore, quary, blocks...">
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity (tonnes)</label>
                                <input type="number" step="0.01" name="quantity" class="form-control" placeholder="example: 60, 25 ...">
                            </div>
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn_close" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Vehicle Trip & Fuel Log</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<!-- Modal for Vehicle Log Form -->
<div class="modal fade" id="logTripModal" tabindex="-1" aria-labelledby="logTripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logTripModalLabel">Register a Trip</h5>
                <button type="button" class="btn-close" id="btn_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vehicle_logs.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="vehicle_id" id="selectedVehicleId">

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                            <input type="date" name="departure_date" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="return_date" class="form-label">Return Date</label>
                            <input type="date" name="return_date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="start_kilometers" class="form-label">Start Kilometers<span class="text-danger">*</span></label>
                            <input type="number" name="start_kilometers" id="start_kilometers" class="form-control" placeholder="example: 54666" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="end_kilometers" class="form-label">Close Kilometers</label>
                            <input type="number" name="end_kilometers" class="form-control" placeholder="example: 54777">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control" placeholder="example: Kasempa, Serenje, Ndoa, Solwezi..." required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="material_delivered" class="form-label">Material Delivered</label>
                            <input type="text" name="material_delivered" class="form-control" placeholder="example: copper ore, quary, blocks...">
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">Quantity (tonnes)</label>
                                <input type="number" step="0.01" name="quantity" class="form-control" placeholder="example: 60, 25 ...">
                            </div>
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn_close" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Vehicle Trip & Fuel Log</button>
                    </div>
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
                <h5 class="modal-title" id="reportModalLabel">Generate Report For all Vehicles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reports.generate_all') }}" method="POST">
                    @csrf
                    <input type="hidden" id="vehicle_id" name="vehicle_id" value="{{ $vehicle->id ?? '' }}">
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
                        <button type="submit" class="btn btn-success">Generate Report For all Vehicles</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var vehicleSelect = document.getElementById('vehicleSelect');
    var vehicleIdField = document.getElementById('selectedVehicleId');
    var modalElement = document.getElementById('logTripModal');
    var startKilometersField = document.getElementById('start_kilometers');

    if (vehicleSelect && vehicleIdField && modalElement && startKilometersField) {
        vehicleSelect.addEventListener('change', function() {
            if (this.value) {
                vehicleIdField.value = this.value;

                // Fetch the last trip's end_kilometers for the selected vehicle
                fetch(`/vehicle-logs/last-trip/${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate the start_kilometers field
                        if(data.end_kilometers != null) {
                            startKilometersField.value = data.end_kilometers;

                        } else {
                            startKilometersField.value = 0;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching last trip details:', error);
                    });

                // Show the modal
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        });

        document.getElementById('btn_close').addEventListener('click', function () {
            var modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    }
});
</script>

{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        var vehicleSelect = document.getElementById('vehicleSelect');
        var vehicleIdField = document.getElementById('selectedVehicleId');
        var modalElement = document.getElementById('logTripModal');

        if (vehicleSelect && vehicleIdField && modalElement) {
            vehicleSelect.addEventListener('change', function() {
                if (this.value) {
                    vehicleIdField.value = this.value;
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            });

            document.getElementById('btn_close').addEventListener('click', function () {
                var modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });
        }
    });
</script> --}}

@endsection
