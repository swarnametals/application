@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="container mt-5">
    <a href="{{ route('dashboards.admin') }}" class="btn btn-secondary mb-4">Back to Dashboard</a>

    <h2 class="mb-4">Applications</h2>

    <!-- Filter Form -->
    <form action="{{ route('applications.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <!-- Years of Experience Filter -->
            <div class="col-12 col-md-4">
                <label for="years_of_experience" class="form-label">Years of Experience</label>
                <select class="form-control" id="years_of_experience" name="years_of_experience" onchange="this.form.submit()">
                    <option value="">All</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ request('years_of_experience') == $i ? 'selected' : '' }}>{{ $i }} Year{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10" {{ request('years_of_experience') == '10' ? 'selected' : '' }}>10+ Years</option>
                </select>
            </div>

            <!-- Position Applied For Filter -->
            <div class="col-12 col-md-4">
                <label for="position_applied_for" class="form-label">Position Applied For</label>
                <select class="form-control" id="position_applied_for" name="position_applied_for" onchange="this.form.submit()">
                    <option value="">All</option>
                    @foreach(['Crushing Section In-charge', 'Milling and Concentrator Section In-charge', 'Leaching and PLS Dam Section In-charge', 'Solvent Extraction Section In-charge', 'Electrowinning Section In-charge', 'Electrical Maintenance In-charge', 'Mechanical Maintenance In-charge', 'Laboratory In-charge', 'Garage In-charge', 'HR Officer', 'Safety Officer', 'Stores Incharge'] as $position)
                        <option value="{{ $position }}" {{ request('position_applied_for') == $position ? 'selected' : '' }}>{{ $position }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Applications Table -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Years of Experience</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->first_name }} {{ $application->last_name }}</td>
                        <td>{{ $application->email }}</td>
                        <td>{{ $application->phone }}</td>
                        <td>{{ $application->position_applied_for }}</td>
                        <td>{{ $application->years_of_experience }} Years</td>
                        <td>{{ $application->status }}</td>
                        <td>
                            <a href="{{ route('applications.show', $application->id) }}" class="btn btn-info btn-sm mb-1">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
