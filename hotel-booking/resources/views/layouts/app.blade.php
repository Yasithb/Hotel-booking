<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hotel Booking System')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #0d6efd !important;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .room-card {
            margin-bottom: 20px;
        }
        .room-type-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }
        .status-badge {
            font-size: 0.8rem;
        }
        .sidebar {
            background-color: #f8f9fa;
            min-height: calc(100vh - 56px);
        }
        .nav-link {
            color: #495057;
            border-radius: 5px;
            margin: 2px 0;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .stats-card {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            border-radius: 10px;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .amenity-tag {
            background-color: #e9ecef;
            color: #495057;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            margin: 2px;
            display: inline-block;
        }
        .loading {
            display: none;
        }
        .search-container {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            backdrop-filter: blur(10px);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-building"></i> Hotel Booking System
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">
                                <i class="bi bi-door-open"></i> Rooms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('guests.*') ? 'active' : '' }}" href="{{ route('guests.index') }}">
                                <i class="bi bi-people"></i> Guests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="{{ route('bookings.index') }}">
                                <i class="bi bi-calendar-check"></i> Bookings
                            </a>
                        </li>
                    </ul>
                @endauth
                
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> 
                                {{ Auth::user()->first_name }} 
                                @if(Auth::user()->role === 'admin')
                                    <span class="badge bg-danger ms-1">Admin</span>
                                @elseif(Auth::user()->role === 'staff')
                                    <span class="badge bg-warning ms-1">Staff</span>
                                @else
                                    <span class="badge bg-success ms-1">Guest</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="bi bi-person"></i> {{ Auth::user()->full_name }}
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="showProfile()">
                                        <i class="bi bi-person-gear"></i> My Profile
                                    </a>
                                </li>
                                @if(Auth::user()->isStaff())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('settings') }}">
                                            <i class="bi bi-gear"></i> Settings
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to logout?')">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-building"></i> Hotel Booking System</h5>
                    <p class="mb-0">Efficient hotel management solution</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} Hotel Booking System. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-2">Processing...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="alertToast" class="toast" role="alert">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Common JavaScript -->
    <script>
        // CSRF Token Setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // API Base URL
        const API_BASE = '/api';
        
        // Common HTTP methods
        const api = {
            get: async (url) => {
                const response = await fetch(`${API_BASE}${url}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                return response.json();
            },
            
            post: async (url, data) => {
                const response = await fetch(`${API_BASE}${url}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });
                return response.json();
            },
            
            put: async (url, data) => {
                const response = await fetch(`${API_BASE}${url}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });
                return response.json();
            },
            
            delete: async (url) => {
                const response = await fetch(`${API_BASE}${url}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                return response.json();
            }
        };
        
        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('alertToast');
            const toastBody = toast.querySelector('.toast-body');
            const toastHeader = toast.querySelector('.toast-header');
            
            toastBody.textContent = message;
            toastHeader.className = `toast-header ${type === 'success' ? 'bg-success text-white' : 'bg-danger text-white'}`;
            
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }
        
        // Show/Hide loading modal
        function showLoading() {
            const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
            modal.show();
        }
        
        function hideLoading() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
            if (modal) modal.hide();
        }
        
        // Format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        }
        
        // Format date
        function formatDate(date) {
            return new Intl.DateTimeFormat('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }).format(new Date(date));
        }
        
        // Status badge helper
        function getStatusBadge(status) {
            const badges = {
                'pending': 'bg-warning text-dark',
                'confirmed': 'bg-info text-white',
                'checked_in': 'bg-success text-white',
                'checked_out': 'bg-secondary text-white',
                'cancelled': 'bg-danger text-white'
            };
            return badges[status] || 'bg-secondary text-white';
        }
        
        // Room type badge helper
        function getRoomTypeBadge(type) {
            const badges = {
                'single': 'bg-light text-dark',
                'double': 'bg-primary text-white',
                'suite': 'bg-warning text-dark',
                'deluxe': 'bg-info text-white',
                'presidential': 'bg-danger text-white'
            };
            return badges[type] || 'bg-secondary text-white';
        }
        
        // Show user profile (future implementation)
        function showProfile() {
            showToast('Profile management coming soon!', 'info');
        }
    </script>
    
    @stack('scripts')
</body>
</html>