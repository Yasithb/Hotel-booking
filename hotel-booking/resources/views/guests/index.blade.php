@extends('layouts.app')

@section('title', 'Guests - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-people"></i> Guest Management</h2>
                <a href="{{ route('guests.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Guest
                </a>
            </div>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Total Guests</h5>
                                    <h3 id="totalGuests">0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-people fs-1"></i>
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
                                    <h3 id="activeGuests">0</h3>
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
                                    <h5 class="card-title">VIP Guests</h5>
                                    <h3 id="vipGuests">0</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-star fs-1"></i>
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
            </div>
            
            <!-- Filters and Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="searchGuests" class="form-label">Search Guests</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchGuests" placeholder="Search by name, email, or phone">
                                <button class="btn btn-outline-secondary" type="button" onclick="searchGuests()">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="filterNationality" class="form-label">Nationality</label>
                            <select class="form-select" id="filterNationality" onchange="applyFilters()">
                                <option value="">All Nationalities</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="filterStatus" class="form-label">Status</label>
                            <select class="form-select" id="filterStatus" onchange="applyFilters()">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="checked-in">Checked In</option>
                                <option value="vip">VIP</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="sortBy" class="form-label">Sort By</label>
                            <select class="form-select" id="sortBy" onchange="applyFilters()">
                                <option value="created_at">Registration Date</option>
                                <option value="last_name">Last Name</option>
                                <option value="first_name">First Name</option>
                                <option value="email">Email</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Guests Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-list"></i> Guest List
                        <span class="badge bg-secondary ms-2" id="guestCount">0</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div id="loadingGuests" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Loading guests...</div>
                    </div>
                    
                    <div id="guestsContainer" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Guest</th>
                                        <th>Contact</th>
                                        <th>Nationality</th>
                                        <th>Registration</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="guestsTableBody"></tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <nav id="paginationContainer" class="mt-3"></nav>
                    </div>
                    
                    <div id="noGuests" class="text-center p-4" style="display: none;">
                        <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-2">No guests found</h5>
                        <p class="text-muted">Start by adding your first guest to the system.</p>
                        <a href="{{ route('guests.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add First Guest
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;
let currentFilters = {};
let allGuests = [];

document.addEventListener('DOMContentLoaded', function() {
    loadGuestStatistics();
    loadGuests();
    loadNationalities();
    
    // Add search on Enter key
    document.getElementById('searchGuests').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchGuests();
        }
    });
});

async function loadGuestStatistics() {
    try {
        const stats = await api.get('/guests/statistics');
        
        document.getElementById('totalGuests').textContent = stats.total_guests || 0;
        document.getElementById('activeGuests').textContent = stats.active_bookings || 0;
        document.getElementById('vipGuests').textContent = stats.vip_guests || 0;
        document.getElementById('todayCheckins').textContent = stats.today_checkins || 0;
        
    } catch (error) {
        console.error('Error loading guest statistics:', error);
    }
}

async function loadGuests(page = 1, filters = {}) {
    try {
        currentPage = page;
        currentFilters = filters;
        
        const params = new URLSearchParams({
            page: page,
            per_page: 10,
            ...filters
        });
        
        const response = await api.get(`/guests?${params}`);
        allGuests = response.data;
        
        displayGuests(response);
        document.getElementById('guestCount').textContent = response.total;
        
        // Hide loading and show content
        document.getElementById('loadingGuests').style.display = 'none';
        
        if (response.data.length > 0) {
            document.getElementById('guestsContainer').style.display = 'block';
            document.getElementById('noGuests').style.display = 'none';
        } else {
            document.getElementById('guestsContainer').style.display = 'none';
            document.getElementById('noGuests').style.display = 'block';
        }
        
    } catch (error) {
        console.error('Error loading guests:', error);
        document.getElementById('loadingGuests').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Error loading guests. Please try again.
            </div>
        `;
    }
}

function displayGuests(response) {
    const tbody = document.getElementById('guestsTableBody');
    
    tbody.innerHTML = response.data.map(guest => `
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <div class="avatar-circle me-3">
                        ${guest.first_name.charAt(0)}${guest.last_name.charAt(0)}
                    </div>
                    <div>
                        <strong>${guest.first_name} ${guest.last_name}</strong>
                        ${guest.is_vip ? '<span class="badge bg-warning text-dark ms-2">VIP</span>' : ''}
                        <div class="text-muted small">ID: #${guest.id}</div>
                    </div>
                </div>
            </td>
            <td>
                <div class="contact-info">
                    <div><i class="bi bi-envelope"></i> ${guest.email}</div>
                    <div><i class="bi bi-telephone"></i> ${guest.phone_number || 'N/A'}</div>
                </div>
            </td>
            <td>
                <span class="badge bg-light text-dark">${guest.nationality}</span>
            </td>
            <td>
                <div class="date-info">
                    ${formatDate(guest.created_at)}
                    <div class="text-muted small">${formatTime(guest.created_at)}</div>
                </div>
            </td>
            <td>
                ${getGuestStatusBadge(guest)}
            </td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <a href="/guests/${guest.id}" class="btn btn-outline-info" title="View Details">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="/guests/${guest.id}/edit" class="btn btn-outline-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-outline-success" onclick="createBooking(${guest.id})" title="New Booking">
                        <i class="bi bi-calendar-plus"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="deleteGuest(${guest.id})" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
    
    // Update pagination
    updatePagination(response);
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
            <a class="page-link" href="#" onclick="loadGuests(${response.current_page - 1}, currentFilters)">Previous</a>
        </li>
    `;
    
    // Page numbers
    for (let i = 1; i <= response.last_page; i++) {
        if (i === 1 || i === response.last_page || (i >= response.current_page - 2 && i <= response.current_page + 2)) {
            paginationHTML += `
                <li class="page-item ${i === response.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadGuests(${i}, currentFilters)">${i}</a>
                </li>
            `;
        } else if (i === response.current_page - 3 || i === response.current_page + 3) {
            paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    // Next page
    paginationHTML += `
        <li class="page-item ${response.current_page === response.last_page ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="loadGuests(${response.current_page + 1}, currentFilters)">Next</a>
        </li>
    `;
    
    paginationHTML += '</ul>';
    container.innerHTML = paginationHTML;
}

async function loadNationalities() {
    try {
        const guests = await api.get('/guests?per_page=1000');
        const nationalities = [...new Set(guests.data.map(guest => guest.nationality))].sort();
        
        const select = document.getElementById('filterNationality');
        nationalities.forEach(nationality => {
            const option = document.createElement('option');
            option.value = nationality;
            option.textContent = nationality;
            select.appendChild(option);
        });
        
    } catch (error) {
        console.error('Error loading nationalities:', error);
    }
}

function searchGuests() {
    const searchTerm = document.getElementById('searchGuests').value.trim();
    const filters = { ...currentFilters };
    
    if (searchTerm) {
        filters.search = searchTerm;
    } else {
        delete filters.search;
    }
    
    loadGuests(1, filters);
}

function applyFilters() {
    const filters = {};
    
    const nationality = document.getElementById('filterNationality').value;
    const status = document.getElementById('filterStatus').value;
    const sortBy = document.getElementById('sortBy').value;
    const searchTerm = document.getElementById('searchGuests').value.trim();
    
    if (nationality) filters.nationality = nationality;
    if (status) filters.status = status;
    if (sortBy) filters.sort_by = sortBy;
    if (searchTerm) filters.search = searchTerm;
    
    loadGuests(1, filters);
}

function getGuestStatusBadge(guest) {
    // This would need to be enhanced based on current bookings
    if (guest.is_vip) {
        return '<span class="badge bg-warning text-dark">VIP</span>';
    }
    
    // Check if guest has active bookings (you'd need to include this in the API response)
    if (guest.active_bookings && guest.active_bookings > 0) {
        return '<span class="badge bg-success">Active</span>';
    }
    
    return '<span class="badge bg-secondary">Registered</span>';
}

async function deleteGuest(guestId) {
    if (!confirm('Are you sure you want to delete this guest? This action cannot be undone.')) {
        return;
    }
    
    try {
        showLoading();
        await api.delete(`/guests/${guestId}`);
        hideLoading();
        
        showToast('Guest deleted successfully!');
        loadGuests(currentPage, currentFilters);
        loadGuestStatistics();
        
    } catch (error) {
        hideLoading();
        console.error('Error deleting guest:', error);
        showToast('Error deleting guest. Please try again.', 'error');
    }
}

function createBooking(guestId) {
    window.location.href = `/bookings/create?guest_id=${guestId}`;
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString();
}

function formatTime(dateString) {
    return new Date(dateString).toLocaleTimeString();
}
</script>
@endpush

@push('styles')
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

.contact-info div {
    font-size: 0.9em;
    margin-bottom: 2px;
}

.contact-info i {
    width: 16px;
    margin-right: 5px;
}

.date-info {
    font-size: 0.9em;
}

.table td {
    vertical-align: middle;
}
</style>
@endpush