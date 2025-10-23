@extends('layouts.app')

@section('title', 'Rooms - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-door-open"></i> Room Management</h2>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Room
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <div class="col-md-3">
                    <label for="roomTypeFilter" class="form-label">Room Type</label>
                    <select class="form-select" id="roomTypeFilter">
                        <option value="">All Types</option>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="suite">Suite</option>
                        <option value="deluxe">Deluxe</option>
                        <option value="presidential">Presidential</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="availabilityFilter" class="form-label">Availability</label>
                    <select class="form-select" id="availabilityFilter">
                        <option value="">All Rooms</option>
                        <option value="1">Available Only</option>
                        <option value="0">Unavailable Only</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="minPrice" class="form-label">Min Price</label>
                    <input type="number" class="form-control" id="minPrice" placeholder="0" min="0">
                </div>
                <div class="col-md-2">
                    <label for="maxPrice" class="form-label">Max Price</label>
                    <input type="number" class="form-control" id="maxPrice" placeholder="1000" min="0">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i> Clear
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rooms Grid -->
    <div id="roomsContainer">
        <div class="text-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-2">Loading rooms...</div>
        </div>
    </div>

    <!-- Pagination -->
    <nav id="paginationContainer" class="d-flex justify-content-center mt-4">
    </nav>
</div>

<!-- Room Details Modal -->
<div class="modal fade" id="roomModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Room Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="roomModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editRoomBtn">Edit Room</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this room? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Room</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;
let currentRoomId = null;

document.addEventListener('DOMContentLoaded', function() {
    loadRooms();
    
    // Add event listeners for filters
    document.getElementById('roomTypeFilter').addEventListener('change', loadRooms);
    document.getElementById('availabilityFilter').addEventListener('change', loadRooms);
    document.getElementById('minPrice').addEventListener('input', debounce(loadRooms, 500));
    document.getElementById('maxPrice').addEventListener('input', debounce(loadRooms, 500));
});

async function loadRooms(page = 1) {
    try {
        currentPage = page;
        
        // Build query parameters
        const params = new URLSearchParams();
        params.append('page', page);
        
        const roomType = document.getElementById('roomTypeFilter').value;
        const availability = document.getElementById('availabilityFilter').value;
        const minPrice = document.getElementById('minPrice').value;
        const maxPrice = document.getElementById('maxPrice').value;
        
        if (roomType) params.append('room_type', roomType);
        if (availability) params.append('is_available', availability);
        if (minPrice) params.append('min_price', minPrice);
        if (maxPrice) params.append('max_price', maxPrice);
        
        const response = await api.get(`/rooms?${params.toString()}`);
        
        displayRooms(response.data);
        displayPagination(response);
        
    } catch (error) {
        console.error('Error loading rooms:', error);
        document.getElementById('roomsContainer').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Error loading rooms. Please try again.
            </div>
        `;
    }
}

function displayRooms(rooms) {
    const container = document.getElementById('roomsContainer');
    
    if (rooms.length === 0) {
        container.innerHTML = `
            <div class="text-center p-5">
                <i class="bi bi-door-closed display-1 text-muted"></i>
                <h3 class="mt-3 text-muted">No rooms found</h3>
                <p>Try adjusting your filters or add a new room.</p>
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Room
                </a>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <div class="row">
            ${rooms.map(room => `
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card room-card h-100">
                        <div class="position-relative">
                            <span class="badge ${getRoomTypeBadge(room.room_type)} room-type-badge">
                                ${room.room_type.toUpperCase()}
                            </span>
                            ${room.is_available 
                                ? '<span class="badge bg-success position-absolute top-0 start-0 m-2">Available</span>'
                                : '<span class="badge bg-danger position-absolute top-0 start-0 m-2">Unavailable</span>'
                            }
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <i class="bi bi-door-open"></i> Room ${room.room_number}
                            </h5>
                            <p class="card-text flex-grow-1">${room.description || 'No description available'}</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Price per night:</span>
                                    <strong class="text-primary">${formatCurrency(room.price_per_night)}</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Max occupancy:</span>
                                    <span><i class="bi bi-people"></i> ${room.max_occupancy}</span>
                                </div>
                            </div>
                            ${room.amenities && room.amenities.length > 0 ? `
                                <div class="mb-3">
                                    <small class="text-muted">Amenities:</small>
                                    <div class="mt-1">
                                        ${room.amenities.map(amenity => `
                                            <span class="amenity-tag">${amenity}</span>
                                        `).join('')}
                                    </div>
                                </div>
                            ` : ''}
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-primary" onclick="viewRoom(${room.id})">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <a href="/rooms/${room.id}/edit" class="btn btn-outline-secondary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(${room.id})">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

function displayPagination(response) {
    const container = document.getElementById('paginationContainer');
    
    if (response.last_page <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let paginationHtml = '<ul class="pagination">';
    
    // Previous button
    if (response.current_page > 1) {
        paginationHtml += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="loadRooms(${response.current_page - 1})">Previous</a>
            </li>
        `;
    }
    
    // Page numbers
    const startPage = Math.max(1, response.current_page - 2);
    const endPage = Math.min(response.last_page, response.current_page + 2);
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHtml += `
            <li class="page-item ${i === response.current_page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="loadRooms(${i})">${i}</a>
            </li>
        `;
    }
    
    // Next button
    if (response.current_page < response.last_page) {
        paginationHtml += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="loadRooms(${response.current_page + 1})">Next</a>
            </li>
        `;
    }
    
    paginationHtml += '</ul>';
    container.innerHTML = paginationHtml;
}

async function viewRoom(roomId) {
    try {
        const room = await api.get(`/rooms/${roomId}`);
        
        const modalBody = document.getElementById('roomModalBody');
        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Room Information</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Room Number:</strong></td>
                            <td>${room.room_number}</td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong></td>
                            <td><span class="badge ${getRoomTypeBadge(room.room_type)}">${room.room_type.toUpperCase()}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Price per Night:</strong></td>
                            <td>${formatCurrency(room.price_per_night)}</td>
                        </tr>
                        <tr>
                            <td><strong>Max Occupancy:</strong></td>
                            <td><i class="bi bi-people"></i> ${room.max_occupancy}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>${room.is_available 
                                ? '<span class="badge bg-success">Available</span>'
                                : '<span class="badge bg-danger">Unavailable</span>'
                            }</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Description</h6>
                    <p>${room.description || 'No description available'}</p>
                    
                    ${room.amenities && room.amenities.length > 0 ? `
                        <h6>Amenities</h6>
                        <div>
                            ${room.amenities.map(amenity => `
                                <span class="amenity-tag">${amenity}</span>
                            `).join('')}
                        </div>
                    ` : ''}
                </div>
            </div>
            
            ${room.bookings && room.bookings.length > 0 ? `
                <hr>
                <h6>Current Bookings</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${room.bookings.map(booking => `
                                <tr>
                                    <td>${booking.guest.first_name} ${booking.guest.last_name}</td>
                                    <td>${formatDate(booking.check_in_date)}</td>
                                    <td>${formatDate(booking.check_out_date)}</td>
                                    <td><span class="badge ${getStatusBadge(booking.status)} status-badge">${booking.status.replace('_', ' ').toUpperCase()}</span></td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            ` : '<hr><p class="text-muted">No current bookings for this room.</p>'}
        `;
        
        currentRoomId = roomId;
        document.getElementById('editRoomBtn').onclick = () => {
            window.location.href = `/rooms/${roomId}/edit`;
        };
        
        const modal = new bootstrap.Modal(document.getElementById('roomModal'));
        modal.show();
        
    } catch (error) {
        console.error('Error loading room details:', error);
        showToast('Error loading room details', 'error');
    }
}

function confirmDelete(roomId) {
    currentRoomId = roomId;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
    
    document.getElementById('confirmDeleteBtn').onclick = deleteRoom;
}

async function deleteRoom() {
    try {
        showLoading();
        await api.delete(`/rooms/${currentRoomId}`);
        hideLoading();
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        modal.hide();
        
        showToast('Room deleted successfully!');
        loadRooms(currentPage);
        
    } catch (error) {
        hideLoading();
        console.error('Error deleting room:', error);
        showToast('Error deleting room. It may have active bookings.', 'error');
    }
}

function clearFilters() {
    document.getElementById('roomTypeFilter').value = '';
    document.getElementById('availabilityFilter').value = '';
    document.getElementById('minPrice').value = '';
    document.getElementById('maxPrice').value = '';
    loadRooms(1);
}

// Debounce function for input events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endpush