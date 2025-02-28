@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white sidebar collapse py-4" id="sidebarMenu">
            <div class="d-flex justify-content-between align-items-center px-3">
                <h4 class="text-center">Swarna Metals</h4>
                <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('not-implemented-yet') }}">
                        <i class="fas fa-users"></i> Employees
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('applications.index') }}">
                        <i class="fas fa-file-alt"></i> Applications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('not-implemented-yet') }}">
                        <i class="fas fa-truck"></i> Transportation and <i class="fas fa-gas-pump"></i> Fuel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('not-implemented-yet') }}">
                        <i class="fas fa-truck-loading"></i> Copper Ore Purchases
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('not-implemented-yet') }}">
                        <i class="fas fa-warehouse"></i> Warehouse/Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('not-implemented-yet') }}">
                        <i class="fas fa-shipping-fast"></i> Shipments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('users.show') }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('users.logout') }}">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>

        <button class="btn btn-dark d-md-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-expanded="false" aria-controls="sidebarMenu">
            <i class="fas fa-bars"></i> Menu
        </button>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 ml-sm-auto px-4">
            <h2 class="mb-4 text-center">Swarna Metals Admin Dashboard</h2>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-users"></i> Employees
                            </h5>
                            <p class="card-text h4">{{ $employeesTotal }}</p>
                            <a href="{{ route('not-implemented-yet') }}" class="btn btn-light btn-sm">View Details</a>
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
                            <a href="{{ route('applications.index') }}" class="btn btn-light btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white" style="background-color:brown;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-truck"></i> Transportation and <i class="fas fa-gas-pump"></i> Fuel
                            </h5>
                            <p class="card-text h4">{{ $vehiclesTotal }} Vehicles</p>
                            <a href="{{ route('not-implemented-yet') }}" class="btn btn-light btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white" style="background-color: #510404;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-truck-loading"></i> Copper Ore Purchases
                            </h5>
                            <p class="card-text h4">70 000 tonnes</p>
                            <a href="{{ route('not-implemented-yet') }}" class="btn btn-light btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-warehouse"></i> Warehouse/Inventory
                            </h5>
                            <p class="card-text h4">1345</p>
                            <a href="{{ route('not-implemented-yet') }}" class="btn btn-light btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row">
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
            </div>
        </main>
    </div>
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
