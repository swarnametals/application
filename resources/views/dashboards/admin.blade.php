@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-users"></i>  Employees
                        </h5>
                        <p class="card-text h4">{{ $employeesTotal }}</p>
                        {{-- <a href="{{ route('employees.index') }}" class="btn btn-light btn-sm">View Details</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white" style="background-color:brown;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-truck"></i> Equipment
                        </h5>
                        <p class="card-text h4">{{ $equipmentsTotal }}</p>
                        {{-- <a href="{{ route('equipments.index') }}" class="btn btn-light btn-sm">View Details</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-file-alt"></i> Job Applications
                        </h5>
                        <p class="card-text h4">{{ $applicationsTotal }}</p>
                        {{-- <a href="{{ route('applications.index') }}" class="btn btn-light btn-sm">View Details</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-warehouse"></i> Warehouse/Inventory
                        </h5>
                        <p class="card-text h4">1345</p>
                        {{-- <a href="{{ route('not-implemented-yet') }}" class="btn btn-light btn-sm">View Details</a> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        {{-- <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Production (Tons)</h5>
                        <canvas id="productionChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Production Breakdown</h5>
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}
</div>

<!-- Add ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const productionCtx = document.getElementById('productionChart').getContext('2d');
    new Chart(productionCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Production (Tons)',
                data: [120, 150, 170, 130, 180, 200, 210],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                fill: true
            }]
        },
        options: { responsive: true }
    });

    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'pie',
        data: {
            labels: ['Copper Cathodes', 'Copper Concentrate'],
            datasets: [{
                label: 'Revenue',
                data: [60, 40],
                backgroundColor: ['#ffcd56', '#4bc0c0'],
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
