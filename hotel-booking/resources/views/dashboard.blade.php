@extends('layouts.app')

@section('title', 'Dashboard - Hotel Booking System')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Hotel Management Dashboard</h1>
                <p class="lead mb-4">Welcome to your comprehensive hotel booking management system. Monitor bookings, manage rooms, and track your hotel's performance.</p>
            </div>
            <div class="col-lg-4">
                <div class="search-container">
                    <h5 class="mb-3"><i class="bi bi-search"></i> Quick Search</h5>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search guests, rooms, bookings..." id="quickSearch">
                        <button class="btn btn-light" type="button" onclick="performQuickSearch()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-door-open display-4 mb-3"></i>
                    <h3 class="card-title" id="totalRooms">0</h3>
                    <p class="card-text">Total Rooms</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-people display-4 mb-3"></i>
                    <h3 class="card-title" id="totalGuests">0</h3>
                    <p class="card-text">Total Guests</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-calendar-check display-4 mb-3"></i>
                    <h3 class="card-title" id="activeBookings">0</h3>
                    <p class="card-text">Active Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card stats-card text-center p-4">
                <div class="card-body">
                    <i class="bi bi-check-circle display-4 mb-3"></i>
                    <h3 class="card-title" id="availableRooms">0</h3>
                    <p class="card-text">Available Rooms</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Activities -->
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-plus"></i> Today's Check-ins
                    </h5>
                </div>
                <div class="card-body">
                    <div id="todayCheckins" class="list-group list-group-flush">
                        <div class="text-center p-3">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-minus"></i> Today's Check-outs
                    </h5>
                </div>
                <div class="card-body">
                    <div id="todayCheckouts" class="list-group list-group-flush">
                        <div class="text-center p-3">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings and Quick Actions -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history"></i> Recent Bookings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Guest</th>
                                    <th>Room</th>
                                    <th>Check-in</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="recentBookings">
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> New Booking
                        </a>
                        <a href="{{ route('guests.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus"></i> Add Guest
                        </a>
                        <a href="{{ route('rooms.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-door-closed"></i> Add Room
                        </a>
                        <button class="btn btn-outline-success" onclick="checkAvailability()">
                            <i class="bi bi-search"></i> Check Availability
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pending Actions -->
            <div class="card mt-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle"></i> Pending Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div id="pendingActions">
                        <div class="text-center">
                            <div class="spinner-border text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Availability Check Modal -->
<div class="modal fade" id="availabilityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Check Room Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="availabilityForm">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="checkInDate" class="form-label">Check-in Date</label>
                            <input type="date" class="form-control" id="checkInDate" required>
                        </div>
                        <div class="col-md-6">
                            <label for="checkOutDate" class="form-label">Check-out Date</label>
                            <input type="date" class="form-control" id="checkOutDate" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="roomType" class="form-label">Room Type (Optional)</label>
                            <select class="form-select" id="roomType">
                                <option value="">All Types</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                                <option value="deluxe">Deluxe</option>
                                <option value="presidential">Presidential</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="maxOccupancy" class="form-label">Guests</label>
                            <input type="number" class="form-control" id="maxOccupancy" min="1" max="10">
                        </div>
                    </div>
                </form>
                <div id="availabilityResults" class="mt-4"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="searchAvailableRooms()">Search Rooms</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('checkInDate').min = today;
    
    // Update check-out date minimum when check-in changes
    document.getElementById('checkInDate').addEventListener('change', function() {
        const checkInDate = new Date(this.value);
        checkInDate.setDate(checkInDate.getDate() + 1);
        document.getElementById('checkOutDate').min = checkInDate.toISOString().split('T')[0];
    });
});

async function loadDashboardData() {
    try {
        // Load dashboard statistics
        const dashboardData = await api.get('/dashboard');
        
        document.getElementById('totalRooms').textContent = dashboardData.total_rooms;
        document.getElementById('totalGuests').textContent = dashboardData.total_guests;
        document.getElementById('activeBookings').textContent = dashboardData.active_bookings;
        document.getElementById('availableRooms').textContent = dashboardData.available_rooms;
        
        // Load today's check-ins
        loadTodayCheckins();
        
        // Load today's check-outs
        loadTodayCheckouts();
        
        // Load recent bookings
        loadRecentBookings();
        
        // Load pending actions
        loadPendingActions();
        
    } catch (error) {
        console.error('Error loading dashboard data:', error);
        showToast('Error loading dashboard data', 'error');
    }
}

async function loadTodayCheckins() {
    try {
        const checkins = await api.get('/today/check-ins');
        const container = document.getElementById('todayCheckins');
        
        if (checkins.length === 0) {
            container.innerHTML = '<div class="text-center p-3 text-muted">No check-ins scheduled for today</div>';
            return;
        }
        
        container.innerHTML = checkins.map(booking => `
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">${booking.guest.first_name} ${booking.guest.last_name}</h6>
                    <p class="mb-1 text-muted">Room ${booking.room.room_number}</p>
                    <small>Guests: ${booking.number_of_guests}</small>
                </div>
                <div>
                    <span class="badge ${getStatusBadge(booking.status)} status-badge">${booking.status.replace('_', ' ').toUpperCase()}</span>
                    ${booking.status === 'confirmed' ? `
                        <button class="btn btn-sm btn-success ms-2" onclick="checkinGuest(${booking.id})">
                            <i class="bi bi-check"></i> Check In
                        </button>
                    ` : ''}
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading check-ins:', error);
        document.getElementById('todayCheckins').innerHTML = '<div class="text-center p-3 text-danger">Error loading check-ins</div>';
    }
}

async function loadTodayCheckouts() {
    try {
        const checkouts = await api.get('/today/check-outs');
        const container = document.getElementById('todayCheckouts');
        
        if (checkouts.length === 0) {
            container.innerHTML = '<div class="text-center p-3 text-muted">No check-outs scheduled for today</div>';
            return;
        }
        
        container.innerHTML = checkouts.map(booking => `
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">${booking.guest.first_name} ${booking.guest.last_name}</h6>
                    <p class="mb-1 text-muted">Room ${booking.room.room_number}</p>
                    <small>Total: ${formatCurrency(booking.total_amount)}</small>
                </div>
                <div>
                    <span class="badge ${getStatusBadge(booking.status)} status-badge">${booking.status.replace('_', ' ').toUpperCase()}</span>
                    ${booking.status === 'checked_in' ? `
                        <button class="btn btn-sm btn-warning ms-2" onclick="checkoutGuest(${booking.id})">
                            <i class="bi bi-box-arrow-right"></i> Check Out
                        </button>
                    ` : ''}
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error loading check-outs:', error);
        document.getElementById('todayCheckouts').innerHTML = '<div class="text-center p-3 text-danger">Error loading check-outs</div>';
    }
}

async function loadRecentBookings() {
    try {
        const response = await api.get('/bookings?per_page=10');
        const bookings = response.data;
        const tbody = document.getElementById('recentBookings');
        
        if (bookings.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No recent bookings</td></tr>';
            return;
        }
        
        tbody.innerHTML = bookings.map(booking => `
            <tr>
                <td>#${booking.id}</td>
                <td>${booking.guest.first_name} ${booking.guest.last_name}</td>
                <td>Room ${booking.room.room_number}</td>
                <td>${formatDate(booking.check_in_date)}</td>
                <td><span class="badge ${getStatusBadge(booking.status)} status-badge">${booking.status.replace('_', ' ').toUpperCase()}</span></td>
                <td>
                    <a href="/bookings/${booking.id}" class="btn btn-sm btn-outline-primary btn-icon" title="View Details">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        console.error('Error loading recent bookings:', error);
        document.getElementById('recentBookings').innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading bookings</td></tr>';
    }
}

async function loadPendingActions() {
    try {
        const pendingBookings = await api.get('/bookings?status=pending');
        const container = document.getElementById('pendingActions');
        
        if (pendingBookings.data.length === 0) {
            container.innerHTML = '<div class="text-center text-muted">No pending actions</div>';
            return;
        }
        
        container.innerHTML = `
            <div class="alert alert-warning">
                <strong>${pendingBookings.data.length}</strong> booking(s) pending confirmation
            </div>
            <div class="d-grid">
                <a href="/bookings?status=pending" class="btn btn-warning">
                    <i class="bi bi-list-check"></i> Review Pending Bookings
                </a>
            </div>
        `;
    } catch (error) {
        console.error('Error loading pending actions:', error);
        document.getElementById('pendingActions').innerHTML = '<div class="text-center text-danger">Error loading pending actions</div>';
    }
}

async function checkinGuest(bookingId) {
    try {
        showLoading();
        await api.post(`/bookings/${bookingId}/check-in`, {});
        hideLoading();
        showToast('Guest checked in successfully!');
        loadTodayCheckins();
        loadDashboardData();
    } catch (error) {
        hideLoading();
        showToast('Error checking in guest', 'error');
    }
}

async function checkoutGuest(bookingId) {
    try {
        showLoading();
        await api.post(`/bookings/${bookingId}/check-out`, {});
        hideLoading();
        showToast('Guest checked out successfully!');
        loadTodayCheckouts();
        loadDashboardData();
    } catch (error) {
        hideLoading();
        showToast('Error checking out guest', 'error');
    }
}

function checkAvailability() {
    const modal = new bootstrap.Modal(document.getElementById('availabilityModal'));
    modal.show();
}

async function searchAvailableRooms() {
    const checkIn = document.getElementById('checkInDate').value;
    const checkOut = document.getElementById('checkOutDate').value;
    const roomType = document.getElementById('roomType').value;
    const maxOccupancy = document.getElementById('maxOccupancy').value;
    
    if (!checkIn || !checkOut) {
        showToast('Please select check-in and check-out dates', 'error');
        return;
    }
    
    try {
        let url = `/available-rooms?check_in_date=${checkIn}&check_out_date=${checkOut}`;
        if (roomType) url += `&room_type=${roomType}`;
        if (maxOccupancy) url += `&max_occupancy=${maxOccupancy}`;
        
        const response = await api.get(url);
        const rooms = response.available_rooms;
        
        const resultsContainer = document.getElementById('availabilityResults');
        
        if (rooms.length === 0) {
            resultsContainer.innerHTML = '<div class="alert alert-info">No rooms available for the selected dates and criteria.</div>';
            return;
        }
        
        resultsContainer.innerHTML = `
            <h6>Available Rooms (${rooms.length} found):</h6>
            <div class="row">
                ${rooms.map(room => `
                    <div class="col-md-6 mb-2">
                        <div class="card">
                            <div class="card-body p-3">
                                <h6 class="card-title">Room ${room.room_number}</h6>
                                <p class="card-text mb-1">
                                    <span class="badge ${getRoomTypeBadge(room.room_type)}">${room.room_type.toUpperCase()}</span>
                                </p>
                                <p class="card-text mb-2">${formatCurrency(room.price_per_night)}/night</p>
                                <button class="btn btn-sm btn-primary" onclick="createBookingForRoom(${room.id})">
                                    <i class="bi bi-plus"></i> Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    } catch (error) {
        console.error('Error searching rooms:', error);
        showToast('Error searching for available rooms', 'error');
    }
}

function createBookingForRoom(roomId) {
    const checkIn = document.getElementById('checkInDate').value;
    const checkOut = document.getElementById('checkOutDate').value;
    
    // Redirect to booking creation page with pre-filled data
    window.location.href = `/bookings/create?room_id=${roomId}&check_in=${checkIn}&check_out=${checkOut}`;
}

async function performQuickSearch() {
    const query = document.getElementById('quickSearch').value;
    if (!query) return;
    
    // For now, redirect to guests search page
    window.location.href = `/guests?search=${encodeURIComponent(query)}`;
}

// Handle enter key in quick search
document.getElementById('quickSearch').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        performQuickSearch();
    }
});
</script>
@endpush