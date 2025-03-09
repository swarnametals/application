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
