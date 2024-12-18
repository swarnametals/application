@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="container mt-5">

    <h2>Applications</h2>

    <!-- Filter Form -->
    <form action="{{ route('applications.index') }}" method="GET" class="mb-4">
        <div class="row">
            <!-- Years of Experience Filter -->
            <div class="col-md-3">
                <label for="years_of_experience" class="form-label">Years of Experience</label>
                <select class="form-control" id="years_of_experience" name="years_of_experience" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="1" {{ request('years_of_experience') == 1 ? 'selected' : '' }}>1 Year</option>
                    <option value="2" {{ request('years_of_experience') == 2 ? 'selected' : '' }}>2 Years</option>
                    <option value="3" {{ request('years_of_experience') == 3 ? 'selected' : '' }}>3 Years</option>
                    <option value="4" {{ request('years_of_experience') == 4 ? 'selected' : '' }}>4 Years</option>
                    <option value="5" {{ request('years_of_experience') == 5 ? 'selected' : '' }}>5 Years</option>
                    <option value="6" {{ request('years_of_experience') == 6 ? 'selected' : '' }}>6 Years</option>
                    <option value="7" {{ request('years_of_experience') == 7 ? 'selected' : '' }}>7 Years</option>
                    <option value="8" {{ request('years_of_experience') == 8 ? 'selected' : '' }}>8 Years</option>
                    <option value="9" {{ request('years_of_experience') == 9 ? 'selected' : '' }}>9 Years</option>
                    <option value="10" {{ request('years_of_experience') == 10 ? 'selected' : '' }}>10+ Years</option>
                </select>
            </div>

            <!-- Position Applied For Filter -->
            <div class="col-md-3">
                <label for="position_applied_for" class="form-label">Position Applied For</label>
                <select class="form-control" id="position_applied_for" name="position_applied_for" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="Crushing Section In-charge" {{ request('position_applied_for') == 'Crushing Section In-charge' ? 'selected' : '' }}>Crushing Section In-charge</option>
                    <option value="Milling and Concentrator Section In-charge" {{ request('position_applied_for') == 'Milling and Concentrator Section In-charge' ? 'selected' : '' }}>Milling and Concentrator Section In-charge</option>
                    <option value="Leaching and PLS Dam Section In-charge" {{ request('position_applied_for') == 'Leaching and PLS Dam Section In-charge' ? 'selected' : '' }}>Leaching and PLS Dam Section In-charge</option>
                    <option value="Solvent Extraction Section In-charge" {{ request('position_applied_for') == 'Solvent Extraction Section In-charge' ? 'selected' : '' }}>Solvent Extraction Section In-charge</option>
                    <option value="Electrowinning Section In-charge" {{ request('position_applied_for') == 'Electrowinning Section In-charge' ? 'selected' : '' }}>Electrowinning Section In-charge</option>
                    <option value="Electrical Maintenance In-charge" {{ request('position_applied_for') == 'Electrical Maintenance In-charge' ? 'selected' : '' }}>Electrical Maintenance In-charge</option>
                    <option value="Mechanical Maintenance In-charge" {{ request('position_applied_for') == 'Mechanical Maintenance In-charge' ? 'selected' : '' }}>Mechanical Maintenance In-charge</option>
                    <option value="Laboratory In-charge" {{ request('position_applied_for') == 'Laboratory In-charge' ? 'selected' : '' }}>Laboratory In-charge</option>
                    <option value="Garage In-charge" {{ request('position_applied_for') == 'Garage In-charge' ? 'selected' : '' }}>Garage In-charge</option>
                    <option value="HR Officer" {{ request('position_applied_for') == 'HR Officer' ? 'selected' : '' }}>HR Officer</option>
                    <option value="Safety Officer" {{ request('position_applied_for') == 'Safety Officer' ? 'selected' : '' }}>Safety Officer</option>
                    <option value="Stores Incharge" {{ request('position_applied_for') == 'Stores Incharge' ? 'selected' : '' }}>Stores Incharge</option>
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary mt-4">Filter</button>
            </div>
        </div>
    </form>

    <!-- Applications Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Years of Exprience</th>
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
@endsection
