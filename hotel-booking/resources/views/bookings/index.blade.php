@extends('layouts.app')

@section('title', 'Bookings - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-calendar-event"></i> Booking Management</h2>
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> New Booking
                </a>
            </div>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Total Bookings</h5>
                                    <h3 id="totalBookings">0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-calendar-event fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Active Bookings</h5>
                                    <h3 id="activeBookings">0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-calendar-check fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Check-ins Today</h5>
                                    <h3 id="todayCheckins">0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-door-open fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Check-outs Today</h5>
                                    <h3 id="todayCheckouts">0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-door-closed fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filters and Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="searchBookings" class="form-label">Search Bookings</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchBookings" placeholder="Search by guest name or booking ID">
                                <button class="btn btn-outline-secondary" type="button" onclick="searchBookings()">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="filterStatus" class="form-label">Status</label>
                            <select class="form-select" id="filterStatus" onchange="applyFilters()">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="checked-in">Checked In</option>
                                <option value="checked-out">Checked Out</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filterDateRange" class="form-label">Date Range</label>
                            <select class="form-select" id="filterDateRange" onchange="applyFilters()">
                                <option value="">All Dates</option>
                                <option value="today">Today</option>
                                <option value="tomorrow">Tomorrow</option>
                                <option value="this_week">This Week</option>
                                <option value="this_month">This Month</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filterRoom" class="form-label">Room</label>
                            <select class="form-select" id="filterRoom" onchange="applyFilters()">
                                <option value="">All Rooms</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sortBy" class="form-label">Sort By</label>
                            <select class="form-select" id="sortBy" onchange="applyFilters()">
                                <option value="created_at">Booking Date</option>
                                <option value="check_in_date">Check-in Date</option>
                                <option value="check_out_date">Check-out Date</option>
                                <option value="total_amount">Total Amount</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Custom Date Range -->
                    <div class="row mt-3" id="customDateRange" style="display: none;">
                        <div class="col-md-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" onchange="applyFilters()">
                        </div>
                        <div class="col-md-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" onchange="applyFilters()">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bookings Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-list"></i> Booking List
                        <span class="badge bg-secondary ms-2" id="bookingCount">0</span>
                    </h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary" onclick="exportBookings('excel')">
                            <i class="bi bi-file-earmark-excel"></i> Excel
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="exportBookings('pdf')">
                            <i class="bi bi-file-earmark-pdf"></i> PDF
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="loadingBookings" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Loading bookings...</div>
                    </div>
                    
                    <div id="bookingsContainer" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Guest</th>
                                        <th>Room</th>
                                        <th>Dates</th>
                                        <th>Duration</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="bookingsTableBody"></tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <nav id="paginationContainer" class="mt-3"></nav>
                    </div>
                    
                    <div id="noBookings" class="text-center p-4" style="display: none;">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-2">No bookings found</h5>
                        <p class="text-muted">Start by creating your first booking.</p>
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Create First Booking
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Modals -->
<!-- Check-in Modal -->
<div class="modal fade" id="checkinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Check-in Guest</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to check in this guest?</p>
                <div id="checkinDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmCheckin">Check In</button>
            </div>
        </div>
    </div>
</div>

<!-- Check-out Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Check-out Guest</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to check out this guest?</p>
                <div id="checkoutDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="confirmCheckout">Check Out</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;
let currentFilters = {};
let allBookings = [];

document.addEventListener('DOMContentLoaded', function() {
    loadBookingStatistics();
    loadBookings();
    loadRoomsForFilter();
    
    // Add search on Enter key
    document.getElementById('searchBookings').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchBookings();
        }
    });
    
    // Handle custom date range toggle
    document.getElementById('filterDateRange').addEventListener('change', function() {
        const customRange = document.getElementById('customDateRange');
        if (this.value === 'custom') {
            customRange.style.display = 'block';
        } else {
            customRange.style.display = 'none';
        }
    });
});

async function loadBookingStatistics() {
    try {
        const stats = await api.get('/bookings/statistics');
        
        document.getElementById('totalBookings').textContent = stats.total_bookings || 0;
        document.getElementById('activeBookings').textContent = stats.active_bookings || 0;
        document.getElementById('todayCheckins').textContent = stats.today_checkins || 0;
        document.getElementById('todayCheckouts').textContent = stats.today_checkouts || 0;
        
    } catch (error) {
        console.error('Error loading booking statistics:', error);
    }
}

async function loadBookings(page = 1, filters = {}) {
    try {
        currentPage = page;
        currentFilters = filters;
        
        const params = new URLSearchParams({
            page: page,
            per_page: 10,
            ...filters
        });
        
        const response = await api.get(`/bookings?${params}`);
        allBookings = response.data;
        
        displayBookings(response);
        document.getElementById('bookingCount').textContent = response.total;
        
        // Hide loading and show content
        document.getElementById('loadingBookings').style.display = 'none';
        
        if (response.data.length > 0) {
            document.getElementById('bookingsContainer').style.display = 'block';
            document.getElementById('noBookings').style.display = 'none';
        } else {
            document.getElementById('bookingsContainer').style.display = 'none';
            document.getElementById('noBookings').style.display = 'block';
        }
        
    } catch (error) {
        console.error('Error loading bookings:', error);
        document.getElementById('loadingBookings').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Error loading bookings. Please try again.
            </div>
        `;
    }
}

function displayBookings(response) {
    const tbody = document.getElementById('bookingsTableBody');
    
    tbody.innerHTML = response.data.map(booking => `
        <tr>
            <td>
                <strong>#${booking.id}</strong>
                <div class="text-muted small">${formatDate(booking.created_at)}</div>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="avatar-circle me-2">
                        ${booking.guest.first_name.charAt(0)}${booking.guest.last_name.charAt(0)}
                    </div>
                    <div>
                        <strong>${booking.guest.first_name} ${booking.guest.last_name}</strong>
                        ${booking.guest.is_vip ? '<span class="badge bg-warning text-dark ms-1">VIP</span>' : ''}
                        <div class="text-muted small">${booking.guest.email}</div>
                    </div>
                </div>
            </td>
            <td>
                <strong>Room ${booking.room.room_number}</strong>
                <div class="text-muted small">${booking.room.room_type.charAt(0).toUpperCase() + booking.room.room_type.slice(1)}</div>
            </td>
            <td>
                <div class="date-range">
                    <div><i class="bi bi-calendar-check text-success"></i> ${formatDate(booking.check_in_date)}</div>
                    <div><i class="bi bi-calendar-x text-danger"></i> ${formatDate(booking.check_out_date)}</div>
                </div>
            </td>
            <td>
                <span class="badge bg-light text-dark">${booking.total_nights} ${booking.total_nights === 1 ? 'night' : 'nights'}</span>
            </td>
            <td>
                <strong class="text-success">$${parseFloat(booking.total_amount).toFixed(2)}</strong>
                <div class="text-muted small">$${parseFloat(booking.room.price_per_night).toFixed(2)}/night</div>
            </td>
            <td>
                ${getStatusBadge(booking.status)}
            </td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <a href="/bookings/${booking.id}" class="btn btn-outline-info" title="View Details">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/bookings/${booking.id}/edit" class="btn btn-outline-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    ${getQuickActionButton(booking)}
                    <button type="button" class="btn btn-outline-danger" onclick="cancelBooking(${booking.id})" title="Cancel">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
    
    // Update pagination
    updatePagination(response);
}

function getStatusBadge(status) {
    const badges = {
        'pending': '<span class="badge bg-warning">Pending</span>',
        'confirmed': '<span class="badge bg-success">Confirmed</span>',
        'checked-in': '<span class="badge bg-primary">Checked In</span>',
        'checked-out': '<span class="badge bg-secondary">Checked Out</span>',
        'cancelled': '<span class="badge bg-danger">Cancelled</span>'
    };
    return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
}

function getQuickActionButton(booking) {
    if (booking.status === 'confirmed') {
        return `<button type="button" class="btn btn-outline-success" onclick="checkInGuest(${booking.id})" title="Check In">
                    <i class="bi bi-door-open"></i>
                </button>`;
    } else if (booking.status === 'checked-in') {
        return `<button type="button" class="btn btn-outline-warning" onclick="checkOutGuest(${booking.id})" title="Check Out">
                    <i class="bi bi-door-closed"></i>
                </button>`;
    }
    return '';
}

async function loadRoomsForFilter() {
    try {
        const rooms = await api.get('/rooms?per_page=1000');
        const select = document.getElementById('filterRoom');
        
        rooms.data.forEach(room => {
            const option = document.createElement('option');
            option.value = room.id;
            option.textContent = `Room ${room.room_number} (${room.room_type})`;
            select.appendChild(option);
        });
        
    } catch (error) {
        console.error('Error loading rooms:', error);
    }
}

function searchBookings() {
    const searchTerm = document.getElementById('searchBookings').value.trim();
    const filters = { ...currentFilters };
    
    if (searchTerm) {
        filters.search = searchTerm;
    } else {
        delete filters.search;
    }
    
    loadBookings(1, filters);
}

function applyFilters() {
    const filters = {};
    
    const status = document.getElementById('filterStatus').value;
    const dateRange = document.getElementById('filterDateRange').value;
    const room = document.getElementById('filterRoom').value;
    const sortBy = document.getElementById('sortBy').value;
    const searchTerm = document.getElementById('searchBookings').value.trim();
    
    if (status) filters.status = status;
    if (dateRange) filters.date_range = dateRange;
    if (room) filters.room_id = room;
    if (sortBy) filters.sort_by = sortBy;
    if (searchTerm) filters.search = searchTerm;
    
    // Handle custom date range
    if (dateRange === 'custom') {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        if (startDate) filters.start_date = startDate;
        if (endDate) filters.end_date = endDate;
    }
    
    loadBookings(1, filters);
}

function updatePagination(response) {
    const container = document.getElementById('paginationContainer');
    
    if (response.last_page <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let paginationHTML = '<ul class="pagination justify-content-center">';
    
    // Previous page
    paginationHTML += `
        <li class="page-item ${response.current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadBookings(${response.current_page - 1}, currentFilters)">Previous</a>
        </li>
    `;
    
    // Page numbers
    for (let i = 1; i <= response.last_page; i++) {
        if (i === 1 || i === response.last_page || (i >= response.current_page - 2 && i <= response.current_page + 2)) {
            paginationHTML += `
                <li class="page-item ${i === response.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadBookings(${i}, currentFilters)">${i}</a>
                </li>
            `;
        } else if (i === response.current_page - 3 || i === response.current_page + 3) {
            paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    // Next page
    paginationHTML += `
        <li class="page-item ${response.current_page === response.last_page ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadBookings(${response.current_page + 1}, currentFilters)">Next</a>
        </li>
    `;
    
    paginationHTML += '</ul>';
    container.innerHTML = paginationHTML;
}

async function checkInGuest(bookingId) {
    try {
        const booking = allBookings.find(b => b.id === bookingId);
        document.getElementById('checkinDetails').innerHTML = `
            <strong>Guest:</strong> ${booking.guest.first_name} ${booking.guest.last_name}<br>
            <strong>Room:</strong> ${booking.room.room_number}<br>
            <strong>Check-in Date:</strong> ${formatDate(booking.check_in_date)}
        `;
        
        document.getElementById('confirmCheckin').onclick = async function() {
            try {
                showLoading();
                await api.put(`/bookings/${bookingId}/checkin`);
                hideLoading();
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('checkinModal'));
                modal.hide();
                
                showToast('Guest checked in successfully!');
                loadBookings(currentPage, currentFilters);
                loadBookingStatistics();
                
            } catch (error) {
                hideLoading();
                console.error('Error checking in guest:', error);
                showToast('Error checking in guest. Please try again.', 'error');
            }
        };
        
        const modal = new bootstrap.Modal(document.getElementById('checkinModal'));
        modal.show();
        
    } catch (error) {
        console.error('Error preparing check-in:', error);
    }
}

async function checkOutGuest(bookingId) {
    try {
        const booking = allBookings.find(b => b.id === bookingId);
        document.getElementById('checkoutDetails').innerHTML = `
            <strong>Guest:</strong> ${booking.guest.first_name} ${booking.guest.last_name}<br>
            <strong>Room:</strong> ${booking.room.room_number}<br>
            <strong>Check-out Date:</strong> ${formatDate(booking.check_out_date)}
        `;
        
        document.getElementById('confirmCheckout').onclick = async function() {
            try {
                showLoading();
                await api.put(`/bookings/${bookingId}/checkout`);
                hideLoading();
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
                modal.hide();
                
                showToast('Guest checked out successfully!');
                loadBookings(currentPage, currentFilters);
                loadBookingStatistics();
                
            } catch (error) {
                hideLoading();
                console.error('Error checking out guest:', error);
                showToast('Error checking out guest. Please try again.', 'error');
            }
        };
        
        const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
        modal.show();
        
    } catch (error) {
        console.error('Error preparing check-out:', error);
    }
}

async function cancelBooking(bookingId) {
    if (!confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
        return;
    }
    
    try {
        showLoading();
        await api.put(`/bookings/${bookingId}/cancel`);
        hideLoading();
        
        showToast('Booking cancelled successfully!');
        loadBookings(currentPage, currentFilters);
        loadBookingStatistics();
        
    } catch (error) {
        hideLoading();
        console.error('Error cancelling booking:', error);
        showToast('Error cancelling booking. Please try again.', 'error');
    }
}

function exportBookings(format) {
    const params = new URLSearchParams(currentFilters);
    window.open(`/api/bookings/export?format=${format}&${params}`, '_blank');
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString();
}
</script>
@endpush

@push('styles')
<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 12px;
}

.date-range div {
    font-size: 0.9em;
    margin-bottom: 2px;
}

.date-range i {
    width: 16px;
    margin-right: 5px;
}

.table td {
    vertical-align: middle;
}
</style>
@endpush