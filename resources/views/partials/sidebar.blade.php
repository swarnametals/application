<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 bg-dark text-white sidebar py-4">
            <h4 class="text-center mb-4">Swarna Metals</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('employees.index') }}">
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
                        <i class="fas fa-chart-line"></i> Production Rate
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('not-implemented-yet') }}">
                        <i class="fas fa-warehouse"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('not-implemented-yet') }}">
                        <i class="fas fa-shipping-fast"></i> Shipments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('not-implemented-yet') }}">
                        <i class="fas fa-chart-bar"></i> Reports
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
        <main class="col-md-9 col-lg-10 ml-sm-auto px-4">
