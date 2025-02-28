@extends('layouts.app')

@section('title', 'Equipment Details')

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

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div id="successMessage" class="alert alert-success" style="display: none;"></div>

    <h2 class="mb-4">
        @if ($equipment->registration_number)
            Registration Number: {{ $equipment->registration_number }} |
        @else
            Asset Code: {{ $equipment->asset_code ?? 'N/A' }} |
        @endif
        Type: {{ $equipment->type }} |
        Name: {{ $equipment->equipment_name }}
    </h2>

    <div class="d-flex flex-column flex-md-row gap-2 mb-3">
        <button type="button" class="btn add-trip-btn" style="background-color:#510404; color: #fff;" data-bs-toggle="modal" data-bs-target="#addTripModal" data-equipment-id="{{ $equipment->id }}">
            <i class="fas fa-plus-circle"></i> Add Trip
        </button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reportModal">
            <i class="fas fa-file-alt"></i> Generate Equipment Report
        </button>
        <a href="{{ route('equipments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <h2 class="mt-4">Equipment Trips</h2>

    @if ($equipment->trips->isEmpty())
        <div class="alert alert-warning">No trips available for this equipment.</div>
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
                        <th>Driver</th>
                        <th>Material Delivered</th>
                        <th>Material Qty (tonnes)</th>
                        <th>Fuel Records</th>
                        <th>Total Fuel Used</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipment->trips as $trip)
                        <tr>
                            <td>{{ $trip->departure_date->format('Y-m-d') }}</td>
                            <td>{{ $trip->return_date ? $trip->return_date->format('Y-m-d') : '-' }}</td>
                            <td>{{ number_format($trip->start_kilometers) }}</td>
                            <td>{{ $trip->end_kilometers ? number_format($trip->end_kilometers) : '-' }}</td>
                            <td>{{ $trip->end_kilometers && $trip->start_kilometers ? number_format($trip->end_kilometers - $trip->start_kilometers) : '-' }} km</td>
                            <td>{{ $trip->location }}</td>
                            <td>{{ $trip->driver->employee_full_name ?? '-' }}</td>
                            <td>{{ $trip->material_delivered ?? '-' }}</td>
                            <td>{{ $trip->quantity ? number_format($trip->quantity, 2) : '-' }}</td>
                            <td>
                                @if ($trip->fuels->isEmpty())
                                    <span class="text-muted">No fuel data</span>
                                @else
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($trip->fuels as $fuel)
                                            <li>{{ number_format($fuel->litres_added, 2) }} Litres at {{ $fuel->refuel_location ?? '-' }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>{{ number_format($trip->fuels->sum('litres_added'), 2) }} Litres</td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <button class="btn btn-sm btn-warning updateTripBtn" data-bs-toggle="modal" data-bs-target="#updateTripModal" data-trip-id="{{ $trip->id }}">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Add Trip Modal -->
    <div class="modal fade" id="addTripModal" tabindex="-1" aria-labelledby="addTripModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTripModalLabel">Add New Trip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-3">
                        <small>
                            <strong>Note:</strong> If the driver is not listed in the dropdown below, please ensure they are registered as an employee with the designation "Driver" in the employee management section.
                        </small>
                    </div>
                    <form id="addTripForm">
                        @csrf
                        <input type="hidden" name="equipment_id" id="addEquipmentId" value="{{ $equipment->id }}">

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="add_driver_id" class="form-label">Driver <span class="text-danger">*</span></label>
                                <select name="driver_id" id="add_driver_id" class="form-select @error('driver_id') is-invalid @enderror" required>
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
                                <label for="add_location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" id="add_location" class="form-control @error('location') is-invalid @enderror"
                                       value="{{ old('location') }}" placeholder="example: Kasempa, Serenje, Ndola, Solwezi..." required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="add_departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                                <input type="date" name="departure_date" id="add_departure_date" class="form-control @error('departure_date') is-invalid @enderror"
                                       value="{{ old('departure_date') }}" required>
                                @error('departure_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="add_return_date" class="form-label">Return Date</label>
                                <input type="date" name="return_date" id="add_return_date" class="form-control @error('return_date') is-invalid @enderror"
                                       value="{{ old('return_date') }}">
                                @error('return_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="add_start_kilometers" class="form-label">Start Kilometers <span class="text-danger">*</span></label>
                                <input type="number" name="start_kilometers" id="add_start_kilometers"
                                       class="form-control @error('start_kilometers') is-invalid @enderror"
                                       value="{{ old('start_kilometers') }}" placeholder="example: 54666" required>
                                @error('start_kilometers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="add_end_kilometers" class="form-label">Closing Kilometers</label>
                                <input type="number" name="end_kilometers" id="add_end_kilometers" class="form-control @error('end_kilometers') is-invalid @enderror"
                                       value="{{ old('end_kilometers') }}" placeholder="example: 54777">
                                @error('end_kilometers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="add_material_delivered" class="form-label">Material Delivered</label>
                                <input type="text" name="material_delivered" id="add_material_delivered" class="form-control @error('material_delivered') is-invalid @enderror"
                                       value="{{ old('material_delivered') }}" placeholder="example: copper ore, quarry, blocks...">
                                @error('material_delivered')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="add_quantity" class="form-label">Quantity (tonnes)</label>
                                <input type="number" step="0.01" name="quantity" id="add_quantity" class="form-control @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity') }}" placeholder="example: 60, 25 ...">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h4 class="mt-4">Fuel Information</h4>
                        <div id="add-fuel-entries">
                            <div class="fuel-entry row mb-3">
                                <div class="col-12 col-md-5">
                                    <label for="add_litres_added[]" class="form-label">Litres Added <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="fuels[0][litres_added]" class="form-control @error('fuels.0.litres_added') is-invalid @enderror"
                                           value="{{ old('fuels.0.litres_added') }}" placeholder="example: 60" required>
                                    @error('fuels.0.litres_added')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-5">
                                    <label for="add_refuel_location[]" class="form-label">Refuel Location</label>
                                    <input type="text" name="fuels[0][refuel_location]" class="form-control @error('fuels.0.refuel_location') is-invalid @enderror"
                                           value="{{ old('fuels.0.refuel_location') }}" placeholder="example: Site, Chimwemwe Meru Station, Kalulushi Meru Station">
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
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Trip & Fuel</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Trip Modal -->
    <div class="modal fade" id="updateTripModal" tabindex="-1" aria-labelledby="updateTripModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTripModalLabel">Edit Trip Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-3">
                        <small>
                            <strong>Note:</strong> If the driver is not listed in the dropdown below, please ensure they are registered as an employee with the designation "Driver" in the employee management section.
                        </small>
                    </div>
                    <form id="updateTripForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="equipment_id" id="updateEquipmentId">
                        <input type="hidden" name="trip_id" id="updateTripId">

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
                                <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror"
                                    value="{{ old('location') }}" placeholder="example: Kasempa, Serenje, Ndola, Solwezi..." required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="departure_date" class="form-label">Departure Date <span class="text-danger">*</span></label>
                                <input type="date" name="departure_date" id="departure_date" class="form-control @error('departure_date') is-invalid @enderror"
                                    value="{{ old('departure_date') }}" required>
                                @error('departure_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="return_date" class="form-label">Return Date</label>
                                <input type="date" name="return_date" id="return_date" class="form-control @error('return_date') is-invalid @enderror"
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
                                <input type="number" name="end_kilometers" id="end_kilometers" class="form-control @error('end_kilometers') is-invalid @enderror"
                                    value="{{ old('end_kilometers') }}" placeholder="example: 54777">
                                @error('end_kilometers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="material_delivered" class="form-label">Material Delivered</label>
                                <input type="text" name="material_delivered" id="material_delivered" class="form-control @error('material_delivered') is-invalid @enderror"
                                    value="{{ old('material_delivered') }}" placeholder="example: copper ore, quarry, blocks...">
                                @error('material_delivered')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="quantity" class="form-label">Quantity (tonnes)</label>
                                <input type="number" step="0.01" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
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
                                        value="{{ old('fuels.0.refuel_location') }}" placeholder="example: Site, Chimwemwe Meru Station, Kalulushi Meru Station">
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
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Trip & Fuel</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
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
                    <h5 class="modal-title" id="reportModalLabel">Generate Equipment Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reports.generate') }}" method="POST">
                        @csrf
                        <input type="hidden" id="equipment_id" name="equipment_id" value="{{ $equipment->id }}">
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

    <!-- JavaScript for AJAX and dynamic fuel entries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        var addFuelEntryCount = 1;

        // Add Trip Modal Trigger
        $('.add-trip-btn').on('click', function() {
            let equipmentId = $(this).data('equipment-id');
            $('#addEquipmentId').val(equipmentId);

            // Fetch last trip's end kilometers
            fetch(`/trips/last-trip/${equipmentId}`)
                .then(response => response.json())
                .then(data => {
                    $('#add_start_kilometers').val(data.end_kilometers !== null ? data.end_kilometers : (data.start_kilometers || 0));
                })
                .catch(error => {
                    console.error('Error fetching last trip details:', error);
                    $('#add_start_kilometers').val(0);
                });
        });

        // Add new fuel entry
        $('#add-fuel-entry').on('click', function() {
            var newEntry = `
                <div class="fuel-entry row mb-3">
                    <div class="col-12 col-md-5">
                        <label for="add_litres_added[]" class="form-label">Litres Added <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="fuels[${addFuelEntryCount}][litres_added]" class="form-control" placeholder="example: 60" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="add_refuel_location[]" class="form-label">Refuel Location</label>
                        <input type="text" name="fuels[${addFuelEntryCount}][refuel_location]" class="form-control" placeholder="example: Site, Chimwemwe Meru Station, Kalulushi Meru Station">
                    </div>
                    <div class="col-12 col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-fuel-entry"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `;
            $('#add-fuel-entries').append(newEntry);
            addFuelEntryCount++;
            updateAddRemoveButtons();
        });

        // Remove fuel entry
        $('#add-fuel-entries').on('click', '.remove-fuel-entry', function() {
            $(this).closest('.fuel-entry').remove();
            updateAddRemoveButtons();
        });

        function updateAddRemoveButtons() {
            var entries = $('#add-fuel-entries .fuel-entry');
            var removeButtons = $('#add-fuel-entries .remove-fuel-entry');
            removeButtons.prop('disabled', entries.length === 1);
        }

        // Add Trip Form Submission
        $('#addTripForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serializeArray();
            let jsonData = {};

            $.each(formData, function() {
                if (this.name.includes('[')) {
                    let [mainKey, index, subKey] = this.name.match(/([^[\]]+)/g);
                    if (!jsonData[mainKey]) jsonData[mainKey] = [];
                    if (!jsonData[mainKey][index]) jsonData[mainKey][index] = {};
                    jsonData[mainKey][index][subKey] = this.value || null;
                } else {
                    jsonData[this.name] = this.value || null;
                }
            });

            $.ajax({
                url: '{{ route('trips.store') }}',
                type: 'POST',
                data: JSON.stringify(jsonData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#successMessage').text(response.message).fadeIn().delay(3000).fadeOut();
                        $('#addTripModal').modal('hide');
                        setTimeout(() => location.reload(), 3000);
                    } else {
                        $('#successMessage').removeClass('alert-success').addClass('alert-danger')
                            .text('Failed to add trip.').fadeIn();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '<ul>';
                        $.each(errors, function(key, messages) {
                            errorMessage += `<li>${messages[0]}</li>`;
                        });
                        errorMessage += '</ul>';
                        $('#successMessage').removeClass('alert-success').addClass('alert-danger')
                            .html(errorMessage).fadeIn();
                    } else {
                        $('#successMessage').removeClass('alert-success').addClass('alert-danger')
                            .text('An error occurred. Please try again.').fadeIn();
                    }
                }
            });
        });

        // Existing updateTripForm JavaScript remains unchanged
        // ... your existing updateTripForm script ...
    });
    </script>
</div>
@endsection
