@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
<div class="container">
    <a href="{{ route('dashboards.admin') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
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

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('equipments.create') }}" class="btn" style="background-color:#510404; color: #fff;">
            <i class="fas fa-truck"></i> Register Vehicle
        </a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="fas fa-file-alt"></i> Generate Report For All Vehicles
        </button>
    </div>

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
        <label for="vehicleSelect" class="form-label">Select a Vehicle to Register a Trip:</label>
        <select id="vehicleSelect" class="form-select">
            <option value="">Select a Vehicle to Register a Trip</option>
            @foreach($equipments as $equipment)
                <option value="{{ $equipment->id }}">
                    {{ $equipment->registration_number ?? 'N/A' }} - {{ $equipment->equipment_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Asset Code</th>
                    <th>Registration Number</th>
                    <th>Equipment Name</th>
                    <th>Type</th>
                    <th>Ownership</th>
                    <th>Value (USD)</th>
                    <th>Mileage (Km)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipments as $equipment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $equipment->asset_code ?? 'N/A' }}</td>
                    <td>{{ $equipment->registration_number ?? 'N/A' }}</td>
                    <td>{{ $equipment->equipment_name }}</td>
                    <td>{{ $equipment->type }}</td>
                    <td>{{ $equipment->ownership }}</td>
                    <td>{{ number_format($equipment->value, 2) }}</td>
                    <td>
                        @if($equipment->trips->last())
                            {{ number_format($equipment->trips->last()->end_kilometers ?? $equipment->trips->last()->start_kilometers, 0, '.', ',') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('equipments.show', $equipment) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                        <a href="{{ route('equipments.edit', $equipment) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No vehicles found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{ $equipments->links() }}
</div>

<!-- Modal for Equipment Trip Form -->
<div class="modal fade" id="logTripModal" tabindex="-1" aria-labelledby="logTripModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#510404">
                <h5 class="modal-title text-light" id="logTripModalLabel" >Register a Trip</h5>
                <button type="button" class="btn-close" style="color: #fff;" id="btn_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning mb-3">
                    <small>
                        <strong>Note:</strong> If the driver is not listed in the dropdown below, please ensure they are registered as an employee with the designation "Driver" in the employee management section.
                    </small>
                </div>
                <form action="{{ route('trips.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="equipment_id" id="selectedVehicleId">
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="driver_id" class="form-label">Driver <span class="text-danger">*</span></label>
                            <select name="driver_id" id="driver_id" class="form-select @error('driver_id') is-invalid @enderror" required>
                                <option value="">Select Driver</option>
                                @foreach (\App\Models\Employee::where('designation', 'driver')->get() as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->employee_full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location') }}" placeholder="example: Kasempa, Serenje, Ndola, Solwezi..." required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                            <input type="date" name="departure_date" class="form-control @error('departure_date') is-invalid @enderror"
                                   value="{{ old('departure_date') }}" required>
                            @error('departure_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="return_date" class="form-label">Return Date</label>
                            <input type="date" name="return_date" class="form-control @error('return_date') is-invalid @enderror"
                                   value="{{ old('return_date') }}">
                            @error('return_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="start_kilometers" class="form-label">Start Kilometers <span class="text-danger">*</span></label>
                            <input type="number" name="start_kilometers" id="start_kilometers"
                                   class="form-control @error('start_kilometers') is-invalid @enderror"
                                   value="{{ old('start_kilometers') }}" placeholder="example: 54666" required>
                            @error('start_kilometers')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="end_kilometers" class="form-label">Closing Kilometers</label>
                            <input type="number" name="end_kilometers" class="form-control @error('end_kilometers') is-invalid @enderror"
                                   value="{{ old('end_kilometers') }}" placeholder="example: 54777">
                            @error('end_kilometers')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="material_delivered" class="form-label">Material Delivered</label>
                            <input type="text" name="material_delivered" class="form-control @error('material_delivered') is-invalid @enderror"
                                   value="{{ old('material_delivered') }}" placeholder="example: copper ore, quarry, blocks...">
                            @error('material_delivered')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="quantity" class="form-label">Quantity (tonnes)</label>
                            <input type="number" step="0.01" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                   value="{{ old('quantity') }}" placeholder="example: 60, 25 ...">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h4 class="mt-4">Fuel Information</h4>
                    <div id="fuel-entries">
                        <div class="fuel-entry row mb-3">
                            <div class="col-12 col-md-5">
                                <label for="litres_added[]" class="form-label">Litres Added <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="fuels[0][litres_added]" class="form-control @error('fuels.0.litres_added') is-invalid @enderror"
                                       value="{{ old('fuels.0.litres_added') }}" placeholder="example: 60" required>
                                @error('fuels.0.litres_added')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-5">
                                <label for="refuel_location[]" class="form-label">Refuel Location</label>
                                <input type="text" name="fuels[0][refuel_location]" class="form-control @error('fuels.0.refuel_location') is-invalid @enderror"
                                       value="{{ old('fuels.0.refuel_location') }}" placeholder="example:Site,Chimwemwe Meru Station, Kalulushi Meru Station">
                                @error('fuels.0.refuel_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-fuel-entry" disabled><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mb-3" id="add-fuel-entry"><i class="fas fa-plus"></i> Add Another Fuel Entry</button>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn_close" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Trip & Fuel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Equipment Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Generate Report For All Vehicles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reports.generate_all') }}" method="POST">
                    @csrf
                    <input type="hidden" id="format" name="format" value="csv">

                    <div class="mb-3">
                        <label for="month" class="form-label">Select Month</label>
                        <select class="form-control @error('month') is-invalid @enderror" id="month" name="month" required>
                            <option value="">Select Month</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endfor
                        </select>
                        @error('month')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year</label>
                        <select class="form-control @error('year') is-invalid @enderror" id="year" name="year" required>
                            <option value="">Select Year</option>
                            @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-download"></i> Generate Report</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
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
        var fuelEntriesContainer = document.getElementById('fuel-entries');
        var addFuelEntryButton = document.getElementById('add-fuel-entry');
        var fuelEntryCount = 1;

        if (vehicleSelect && vehicleIdField && modalElement && startKilometersField) {
            vehicleSelect.addEventListener('change', function() {
                if (this.value) {
                    vehicleIdField.value = this.value;

                    // Fetch the last trip's end_kilometers for the selected equipment
                    fetch(`/trips/last-trip/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            startKilometersField.value = data.end_kilometers !== null ? data.end_kilometers : (data.start_kilometers || 0);
                        })
                        .catch(error => {
                            console.error('Error fetching last trip details:', error);
                            startKilometersField.value = 0; // Default to 0 on error
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

        // Add new fuel entry
        addFuelEntryButton.addEventListener('click', function() {
            var newEntry = `
                <div class="fuel-entry row mb-3">
                    <div class="col-12 col-md-5">
                        <label for="litres_added[]" class="form-label">Litres Added <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="fuels[${fuelEntryCount}][litres_added]" class="form-control" placeholder="example: 60" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="refuel_location[]" class="form-label">Refuel Location</label>
                        <input type="text" name="fuels[${fuelEntryCount}][refuel_location]" class="form-control" placeholder="example: Site, Solwezi, Kasempa">
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-fuel-entry"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            fuelEntriesContainer.insertAdjacentHTML('beforeend', newEntry);
            fuelEntryCount++;
            updateRemoveButtons();
        });

        // Remove fuel entry
        fuelEntriesContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-fuel-entry') || e.target.parentElement.classList.contains('remove-fuel-entry')) {
                e.target.closest('.fuel-entry').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            var entries = fuelEntriesContainer.getElementsByClassName('fuel-entry');
            var removeButtons = fuelEntriesContainer.getElementsByClassName('remove-fuel-entry');
            for (var i = 0; i < removeButtons.length; i++) {
                removeButtons[i].disabled = (entries.length === 1); // Disable if only one entry remains
            }
        }
    });
</script>

@endsection
