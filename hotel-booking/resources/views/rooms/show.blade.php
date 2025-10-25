@extends('layouts.app')

@section('title', 'Room Details - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-door-open"></i> Room Details
                    </h4>
                </div>
                <div class="card-body">
                    <div id="loadingContainer" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Loading room details...</div>
                    </div>
                    
                    <div id="roomDetails" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-primary" id="roomTitle"></h5>
                                <div class="room-status mb-3" id="roomStatus"></div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="btn-group" role="group">
                                    <a href="#" id="editBtn" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteRoom()">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Room Number</label>
                                    <div class="info-value" id="roomNumber"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Room Type</label>
                                    <div class="info-value" id="roomType"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Maximum Occupancy</label>
                                    <div class="info-value" id="maxOccupancy"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Price per Night</label>
                                    <div class="info-value text-success fs-4" id="pricePerNight"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Availability</label>
                                    <div class="info-value" id="availability"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-group mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <div class="info-value" id="description"></div>
                        </div>
                        
                        <div class="info-group mb-4">
                            <label class="form-label fw-bold">Amenities</label>
                            <div id="amenitiesList"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Rooms
                            </a>
                            <button type="button" class="btn btn-success" onclick="checkAvailability()">
                                <i class="bi bi-calendar-check"></i> Check Availability
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Current Bookings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-calendar-event"></i> Current Bookings
                    </h6>
                </div>
                <div class="card-body">
                    <div id="currentBookings">
                        <div class="text-center p-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" onclick="createBooking()">
                            <i class="bi bi-plus-circle"></i> Create Booking
                        </button>
                        <button type="button" class="btn btn-outline-info" onclick="viewBookingHistory()">
                            <i class="bi bi-clock-history"></i> Booking History
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="toggleAvailability()">
                            <i class="bi bi-toggle-on"></i> Toggle Availability
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Availability Modal -->
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
                            <div class="mb-3">
                                <label for="check_in" class="form-label">Check-in Date</label>
                                <input type="date" class="form-control" id="check_in" name="check_in" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="check_out" class="form-label">Check-out Date</label>
                                <input type="date" class="form-control" id="check_out" name="check_out" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="guests" class="form-label">Number of Guests</label>
                        <input type="number" class="form-control" id="guests" name="guests" min="1" value="1" required>
                    </div>
                </form>
                <div id="availabilityResult" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="performAvailabilityCheck()">Check Availability</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const roomId = {{ $roomId }};
let currentRoom = null;

document.addEventListener('DOMContentLoaded', function() {
    loadRoomDetails();
    loadCurrentBookings();
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('check_in').min = today;
    document.getElementById('check_out').min = today;
    
    // Update check-out min date when check-in changes
    document.getElementById('check_in').addEventListener('change', function() {
        document.getElementById('check_out').min = this.value;
    });
});

async function loadRoomDetails() {
    try {
        const room = await api.get(`/rooms/${roomId}`);
        currentRoom = room;
        
        // Update page content
        document.getElementById('roomTitle').textContent = `Room ${room.room_number} - ${room.room_type.charAt(0).toUpperCase() + room.room_type.slice(1)}`;
        document.getElementById('roomNumber').textContent = room.room_number;
        document.getElementById('roomType').innerHTML = `<span class="badge bg-info">${room.room_type.charAt(0).toUpperCase() + room.room_type.slice(1)}</span>`;
        document.getElementById('maxOccupancy').innerHTML = `<i class="bi bi-people"></i> ${room.max_occupancy} ${room.max_occupancy === 1 ? 'person' : 'people'}`;
        document.getElementById('pricePerNight').textContent = `$${parseFloat(room.price_per_night).toFixed(2)}`;
        document.getElementById('description').textContent = room.description || 'No description available.';
        
        // Room status
        const statusBadge = room.is_available 
            ? '<span class="badge bg-success">Available</span>' 
            : '<span class="badge bg-danger">Not Available</span>';
        document.getElementById('roomStatus').innerHTML = statusBadge;
        document.getElementById('availability').innerHTML = statusBadge;
        
        // Amenities
        const amenitiesContainer = document.getElementById('amenitiesList');
        if (room.amenities && room.amenities.length > 0) {
            amenitiesContainer.innerHTML = room.amenities.map(amenity => 
                `<span class="badge bg-light text-dark me-1 mb-1">${amenity}</span>`
            ).join('');
        } else {
            amenitiesContainer.innerHTML = '<span class="text-muted">No amenities listed</span>';
        }
        
        // Update edit button link
        document.getElementById('editBtn').href = `/rooms/${roomId}/edit`;
        
        // Set max guests for availability check
        document.getElementById('guests').max = room.max_occupancy;
        
        // Hide loading and show content
        document.getElementById('loadingContainer').style.display = 'none';
        document.getElementById('roomDetails').style.display = 'block';
        
    } catch (error) {
        console.error('Error loading room details:', error);
        document.getElementById('loadingContainer').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Error loading room details. Please try again.
                <div class="mt-2">
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back to Rooms</a>
                </div>
            </div>
        `;
    }
}

async function loadCurrentBookings() {
    try {
        const bookings = await api.get(`/rooms/${roomId}/bookings/current`);
        const container = document.getElementById('currentBookings');
        
        if (bookings.length > 0) {
            container.innerHTML = bookings.map(booking => `
                <div class="booking-item border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Booking #${booking.id}</strong>
                            <div class="text-muted small">
                                ${formatDate(booking.check_in_date)} - ${formatDate(booking.check_out_date)}
                            </div>
                            <div class="text-muted small">
                                Guest: ${booking.guest.first_name} ${booking.guest.last_name}
                            </div>
                        </div>
                        <span class="badge bg-${getStatusColor(booking.status)}">${booking.status}</span>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<div class="text-muted text-center">No current bookings</div>';
        }
    } catch (error) {
        console.error('Error loading bookings:', error);
        document.getElementById('currentBookings').innerHTML = '<div class="text-danger text-center">Error loading bookings</div>';
    }
}

async function deleteRoom() {
    if (!confirm('Are you sure you want to delete this room? This action cannot be undone.')) {
        return;
    }
    
    try {
        showLoading();
        await api.delete(`/rooms/${roomId}`);
        hideLoading();
        
        showToast('Room deleted successfully!');
        setTimeout(() => {
            window.location.href = '{{ route("rooms.index") }}';
        }, 1500);
        
    } catch (error) {
        hideLoading();
        console.error('Error deleting room:', error);
        showToast('Error deleting room. Please try again.', 'error');
    }
}

function checkAvailability() {
    const modal = new bootstrap.Modal(document.getElementById('availabilityModal'));
    modal.show();
    
    // Clear previous result
    document.getElementById('availabilityResult').innerHTML = '';
}

async function performAvailabilityCheck() {
    const formData = new FormData(document.getElementById('availabilityForm'));
    const data = Object.fromEntries(formData.entries());
    
    try {
        const result = await api.post(`/rooms/${roomId}/check-availability`, data);
        const resultContainer = document.getElementById('availabilityResult');
        
        if (result.available) {
            resultContainer.innerHTML = `
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    Room is available for the selected dates!
                    <div class="mt-2">
                        <strong>Total Cost:</strong> $${result.total_cost}
                        <small class="text-muted">(${result.nights} nights × $${result.price_per_night})</small>
                    </div>
                </div>
            `;
        } else {
            resultContainer.innerHTML = `
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    Room is not available for the selected dates.
                    ${result.reason ? `<div class="mt-1"><small>${result.reason}</small></div>` : ''}
                </div>
            `;
        }
    } catch (error) {
        console.error('Error checking availability:', error);
        document.getElementById('availabilityResult').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i>
                Error checking availability. Please try again.
            </div>
        `;
    }
}

async function toggleAvailability() {
    if (!currentRoom) return;
    
    const newStatus = !currentRoom.is_available;
    const action = newStatus ? 'enable' : 'disable';
    
    if (!confirm(`Are you sure you want to ${action} this room?`)) {
        return;
    }
    
    try {
        showLoading();
        await api.put(`/rooms/${roomId}`, { is_available: newStatus });
        hideLoading();
        
        currentRoom.is_available = newStatus;
        
        // Update UI
        const statusBadge = newStatus 
            ? '<span class="badge bg-success">Available</span>' 
            : '<span class="badge bg-danger">Not Available</span>';
        document.getElementById('roomStatus').innerHTML = statusBadge;
        document.getElementById('availability').innerHTML = statusBadge;
        
        showToast(`Room ${newStatus ? 'enabled' : 'disabled'} successfully!`);
        
    } catch (error) {
        hideLoading();
        console.error('Error toggling availability:', error);
        showToast('Error updating room status. Please try again.', 'error');
    }
}

function createBooking() {
    window.location.href = `/bookings/create?room_id=${roomId}`;
}

function viewBookingHistory() {
    window.location.href = `/bookings?room_id=${roomId}`;
}

function getStatusColor(status) {
    const colors = {
        'confirmed': 'success',
        'checked-in': 'primary',
        'checked-out': 'secondary',
        'cancelled': 'danger',
        'pending': 'warning'
    };
    return colors[status] || 'secondary';
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString();
}
</script>
@endpush