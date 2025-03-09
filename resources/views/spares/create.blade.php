@extends('layouts.app')

@section('title', 'Register Spare Part')

@section('content')
<div class="container">
    <h1>Register Spare Part for {{ $equipment->registration_number ?? $equipment->asset_code ??  'Equipment' }}-{{$equipment->equipment_name }}</h1>

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
    
    <small class="text-danger">Inputs marked with an asterisk (<span class="text-danger"> * </span>) are mandatory</small>

    <form action="{{ route('equipment_spares.store') }}" method="POST">
        @csrf
        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

        <div class="card mb-4">
            <div class="card-header text-white" style="background-color:#510404">
                <h5 class="mb-0">Spare Part Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Spare Part Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="e.g., Brake Pad" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Price (ZMW) </label>
                            <input type="number" step="0.01" id="price" name="price" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}" placeholder="e.g., 450.99">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity">Quantity <span class="text-danger">*</span></label>
                            <input type="number" step="1" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                   value="{{ old('quantity') }}" placeholder="e.g., 5" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Register Spare</button>
            <a href="{{ route('equipments.show', $equipment->id) }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>
@endsection
