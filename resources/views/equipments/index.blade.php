@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
<div class="container">
    <h2 class="mb-4">Equipments List</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex  mb-3">
        <a href="{{ route('equipments.create') }}" class="btn" style="background-color:#510404; margin-left:6px; color: #fff;">
            <i class="fas fa-truck"></i> Register Equipment
        </a>
        {{-- <a href="{{ route('equipments.upload') }}" class="btn btn-success"> <i class="fas fa-upload"></i> Add Equipments With An Excel Sheet</a> --}}
        {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="fas fa-file-alt"></i> Generate Report For All Vehicles
        </button> --}}
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
        <select class="form-control" id="vehicleSelect">
            <option value="">Select an Equipement to Register a Trip/ Machinery Usage</option>
            @foreach ($equipments as $equipment)
                <option value="{{ $equipment->id }}" data-equipment-type="{{ $equipment->type }}">
                    {{ $equipment->registration_number ?? $equipment->asset_code }} - {{ $equipment->equipment_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mt-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    {{-- <th>Asset Code</th> --}}
                    <th>Registration Number</th>
                    <th>Equipment Name</th>
                    <th>Type</th>
                    {{-- <th>Value (USD)</th> --}}
                    <th>Mileage (Km) /Hours</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipments as $equipment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    {{-- <td>{{ $equipment->asset_code ?? 'N/A' }}</td> --}}
                    <td>{{ $equipment->registration_number ?? 'N/A' }}</td>
                    <td>{{ $equipment->equipment_name }}</td>
                    <td>{{ $equipment->type }}</td>
                    {{-- <td>{{ number_format($equipment->value, 2) }}</td> --}}
                    <td>
                        @if($equipment->trips->last())
                            {{ number_format($equipment->trips->last()->end_kilometers ?? $equipment->trips->last()->start_kilometers, 0, '.', ',') }} Km
                        @elseif ($equipment->machineryUsages->last())
                            {{ number_format($equipment->machineryUsages->last()->closing_hours ?? $equipment->machineryUsages->last()->start_hours, 0, '.', ',') }} Hours
                        @else
                         -
                        @endif
                    </td>
                    <td>
                        @if ($equipment->status == 'Running')
                            <div class="btn btn-sm" style="background-color: #28a745; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $equipment->status }}</div>
                        @elseif ($equipment->status == 'Under Maintenance')
                            <div class="btn btn-sm" style="background-color: #6c757d; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $equipment->status }}</div>
                        @elseif ($equipment->status == 'Broken Down')
                            <div class="btn btn-sm" style="background-color: #ffc107; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $equipment->status }}</div>
                        @elseif ($equipment->status == 'Accident')
                            <div class="btn btn-sm" style="background-color: #dc3545; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $equipment->status }}</div>
                        @else
                            <div class="btn btn-sm" style="background-color: #6c757d; color: white; border-radius: 4px; padding: 0.25rem 0.5rem;">{{ $equipment->status ?? 'N/A' }}</div>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        <div class="d-flex flex-column flex-md-row gap-1">
                            <a href="{{ route('equipments.show', $equipment) }}" class="btn btn-info btn-sm mr-1">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('equipments.edit', $equipment) }}" class="btn btn-warning btn-sm mt-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No Equipment found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
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
                <form action="{{ route('trips.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="equipment_id" id="selectedVehicleId">
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="driver_id" class="form-label">Driver <span class="text-danger">*</span></label>
                            <select name="driver_id" id="driver_id" class="form-control @error('driver_id') is-invalid @enderror" required>
                                <option value="">Select Driver</option>
                                @foreach (\App\Models\Employee::whereIn('designation', [
                                    'DRIVER',
                                    'OPERATOR',
                                    'OPERATOR_LOADER',
                                    'DRIVER _ HILUX',
                                    'DRIVER_TIPPER',
                                    'OPERATOR_EXCAVATOR',
                                    'DRIVER_WATERBOWSER',
                                    'OPERATOR_ROLLER',
                                    'LOADER _ OPERATOR',
                                    'DRIVER _ CONTAINER'
                                ])->orderBy('employee_full_name', 'asc')->get() as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->employee_full_name }} ({{ $driver->designation }})
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

<!-- Modal for Machinery Usage Form -->
<div class="modal fade" id="logMachineryUsageModal" tabindex="-1" aria-labelledby="logMachineryUsageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#510404">
                <h5 class="modal-title text-light" id="logMachineryUsageModalLabel">Register Machinery Usage</h5>
                <button type="button" class="btn-close" style="color: #fff;" id="btn_close_machinery" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning mb-3">
                    <small>
                        <strong>Note:</strong> If the Driver/Operator is not listed in the dropdown below, please ensure they are registered as an employee with the designation "DRIVER" or "OPERATOR" in the employee management section.
                    </small>
                </div>
                <form action="{{ route('machinery_usages.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="equipment_id" id="selectedMachineryId">

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="operator_id" class="form-label">Operator <span class="text-danger">*</span></label>
                            <select name="operator_id" id="operator_id" class="form-select @error('operator_id') is-invalid @enderror" required>
                                <option value="">Select Operator</option>
                                @foreach (\App\Models\Employee::whereIn('designation', [
                                    'DRIVER',
                                    'OPERATOR',
                                    'OPERATOR_LOADER',
                                    'DRIVER _ HILUX',
                                    'DRIVER_TIPPER',
                                    'OPERATOR_EXCAVATOR',
                                    'DRIVER_WATERBOWSER',
                                    'OPERATOR_ROLLER',
                                    'LOADER _ OPERATOR',
                                    'DRIVER _ CONTAINER'
                                ])->orderBy('employee_full_name', 'asc')->get() as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->employee_full_name }} ({{ $driver->designation }})
                                    </option>
                                @endforeach
                            </select>
                            @error('operator_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location') }}" placeholder="example: Site,Kasempa,..." required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                   value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="start_hours" class="form-label">Start Hours <span class="text-danger">*</span></label>
                            <input type="number"  name="start_hours" id="start_hours" class="form-control @error('start_hours') is-invalid @enderror"
                                   value="{{ old('start_hours') }}" placeholder="example: 85670" required>
                            @error('start_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="closing_hours" class="form-label">Closing Hours <span class="text-danger">*</span></label>
                            <input type="number" name="closing_hours" class="form-control @error('closing_hours') is-invalid @enderror"
                                   value="{{ old('closing_hours') }}" placeholder="example: 85690" required>
                            @error('closing_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <h4 class="mt-4">Fuel Information</h4>
                    <div id="machinery-fuel-entries">
                        <div class="fuel-entry row mb-3">
                            <div class="col-12 col-md-5">
                                <label for="litres_added[]" class="form-label">Litres Added <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="fuels[0][litres_added]" class="form-control @error('fuels.0.litres_added') is-invalid @enderror"
                                       value="{{ old('fuels.0.litres_added') }}" placeholder="example: 230" required>
                                @error('fuels.0.litres_added')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-5">
                                <label for="refuel_location[]" class="form-label">Refuel Location</label>
                                <input type="text" name="fuels[0][refuel_location]" class="form-control @error('fuels.0.refuel_location') is-invalid @enderror"
                                       value="{{ old('fuels.0.refuel_location') }}" placeholder="example: Site">
                                @error('fuels.0.refuel_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-fuel-entry" disabled><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mb-3" id="add-machinery-fuel-entry"><i class="fas fa-plus"></i> Add Another Fuel Entry</button>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn_close_machinery" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Machinery Usage & Fuel</button>
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
        var machineryIdField = document.getElementById('selectedMachineryId');
        var tripModalElement = document.getElementById('logTripModal');
        var machineryModalElement = document.getElementById('logMachineryUsageModal');
        var startKilometersField = document.getElementById('start_kilometers');
        var startHoursField = document.getElementById('start_hours');
        var fuelEntriesContainer = document.getElementById('fuel-entries');
        var machineryFuelEntriesContainer = document.getElementById('machinery-fuel-entries');
        var addFuelEntryButton = document.getElementById('add-fuel-entry');
        var addMachineryFuelEntryButton = document.getElementById('add-machinery-fuel-entry');
        var fuelEntryCount = 1;
        var machineryFuelEntryCount = 1;

        if (vehicleSelect && vehicleIdField && machineryIdField && tripModalElement && machineryModalElement && startKilometersField) {
            vehicleSelect.addEventListener('change', function() {
                if (this.value) {
                    var selectedOption = this.options[this.selectedIndex];
                    var equipmentType = selectedOption.getAttribute('data-equipment-type');

                    if (equipmentType === 'Machinery') {
                        machineryIdField.value = this.value;

                        // Fetch the last Machinery Usage's closing_hours for the selected equipment
                        fetch(`/machinery-usages/last-usage/${this.value}`)
                            .then(response => response.json())
                            .then(data => {
                                startHoursField.value = data.closing_hours !== null ? data.closing_hours : (data.start_hours || 0);
                            })
                            .catch(error => {
                                console.error('Error fetching last trip details:', error);
                                startHoursField.value = 0; // Default to 0 on error
                            });
                        var modal = new bootstrap.Modal(machineryModalElement);
                        modal.show();
                    } else {
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

                        var modal = new bootstrap.Modal(tripModalElement);
                        modal.show();
                    }
                }
            });

            document.getElementById('btn_close').addEventListener('click', function () {
                var modalInstance = bootstrap.Modal.getInstance(tripModalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });

            document.getElementById('btn_close_machinery').addEventListener('click', function () {
                var modalInstance = bootstrap.Modal.getInstance(machineryModalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });
        }

        // Add new fuel entry for trip modal
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
            updateRemoveButtons(fuelEntriesContainer);
        });

        // Add new fuel entry for machinery modal
        addMachineryFuelEntryButton.addEventListener('click', function() {
            var newEntry = `
                <div class="fuel-entry row mb-3">
                    <div class="col-12 col-md-5">
                        <label for="litres_added[]" class="form-label">Litres Added <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="fuels[${machineryFuelEntryCount}][litres_added]" class="form-control" placeholder="example: 60" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="refuel_location[]" class="form-label">Refuel Location</label>
                        <input type="text" name="fuels[${machineryFuelEntryCount}][refuel_location]" class="form-control" placeholder="example: Site, Solwezi, Kasempa">
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-fuel-entry"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            machineryFuelEntriesContainer.insertAdjacentHTML('beforeend', newEntry);
            machineryFuelEntryCount++;
            updateRemoveButtons(machineryFuelEntriesContainer);
        });

        // Remove fuel entry
        function removeFuelEntry(e) {
            if (e.target.classList.contains('remove-fuel-entry') || e.target.parentElement.classList.contains('remove-fuel-entry')) {
                e.target.closest('.fuel-entry').remove();
                updateRemoveButtons(e.target.closest('.fuel-entry').parentElement);
            }
        }

        fuelEntriesContainer.addEventListener('click', removeFuelEntry);
        machineryFuelEntriesContainer.addEventListener('click', removeFuelEntry);

        function updateRemoveButtons(container) {
            var entries = container.getElementsByClassName('fuel-entry');
            var removeButtons = container.getElementsByClassName('remove-fuel-entry');
            for (var i = 0; i < removeButtons.length; i++) {
                removeButtons[i].disabled = (entries.length === 1); // Disable if only one entry remains
            }
        }
    });
</script>

@endsection
