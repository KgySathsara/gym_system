<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gym Management System') - FitLife Pro</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --header-bg: #ffffff;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            line-height: 1.6;
        }

        /* Layout */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #334155;
            background: var(--sidebar-bg);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            text-decoration: none;
        }

        .brand-icon {
            background: var(--primary);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            font-weight: 600;
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: var(--header-bg);
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .page-title p {
            color: var(--secondary);
            margin: 0;
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .user-menu:hover {
            background: #f1f5f9;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
        }

        .user-role {
            font-size: 0.8rem;
            color: var(--secondary);
        }

        /* Content Area */
        .content-wrapper {
            padding: 2rem;
            flex: 1;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            background: white;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-title {
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Tables */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            color: var(--dark);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f1f5f9;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Badges */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 1.5rem 2rem;
            margin-top: auto;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .header {
                padding: 1rem;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .footer-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--dark);
            cursor: pointer;
        }

        /* Quick Stats in Sidebar */
        .quick-stats {
            background: rgba(255, 255, 255, 0.1);
            margin: 1rem;
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        .stat-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success);
        }

        .stat-dot.warning {
            background: var(--warning);
        }

        /* Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
            z-index: 100;
            display: none;
        }

        .back-to-top:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
        }

        .back-to-top.show {
            display: flex;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="brand">
                    <div class="brand-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <span>FitLife Pro</span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main Navigation</div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Management</div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}" href="{{ route('members.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Members</span>
                            <span class="nav-badge">{{ \App\Models\Member::count() }}</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('trainers.*') ? 'active' : '' }}" href="{{ route('trainers.index') }}">
                            <i class="fas fa-user-tie"></i>
                            <span>Trainers</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('plans.*') ? 'active' : '' }}" href="{{ route('plans.index') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Plans</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                            <i class="fas fa-credit-card"></i>
                            <span>Payments</span>
                            <span class="nav-badge">{{ \App\Models\Payment::where('status', 'pending')->count() }}</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                            <i class="fas fa-calendar-check"></i>
                            <span>Attendance</span>
                            <span class="nav-badge">{{ \App\Models\Attendance::whereDate('date', today())->count() }}</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="quick-stats">
                    <div class="stat-item">
                        <div class="stat-dot"></div>
                        <span>{{ \App\Models\Member::where('status', 'active')->count() }} Active Members</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-dot warning"></div>
                        <span>{{ \App\Models\Payment::where('status', 'pending')->count() }} Pending Payments</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-dot" style="background: var(--primary);"></div>
                        <span>{{ \App\Models\Attendance::whereDate('date', today())->count() }} Today's Check-ins</span>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <div class="d-flex align-items-center gap-3">
                        <button class="mobile-menu-btn" id="mobileMenuBtn">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="page-title">
                            <h1>@yield('title', 'Dashboard')</h1>
                            <p>@yield('subtitle', 'Welcome to FitLife Gym Management System')</p>
                        </div>
                    </div>

                    <div class="header-actions">
                        @auth
                        <div class="dropdown">
                            <div class="user-menu" data-bs-toggle="dropdown">
                                <div class="user-avatar">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ auth()->user()->name }}</span>
                                    <span class="user-role">Administrator</span>
                                </div>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('settings.edit') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @else
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Main Content -->
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="footer-content">
                    <div>
                        <p class="mb-0">&copy; 2024 FitLife Pro Gym Management System. All rights reserved.</p>
                    </div>
                    <div>
                        <p class="mb-0">v2.0.0 | Premium Edition</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Bootstrap & JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('mobile-open');
        });

        // Back to Top
        const backToTop = document.getElementById('backToTop');

        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Show/hide back to top button
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !mobileMenuBtn.contains(event.target) &&
                sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
