@extends('layouts.app')

@section('title', 'Booking Details - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-event"></i> Booking Details
                    </h4>
                </div>
                <div class="card-body">
                    <div id="loadingContainer" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Loading booking details...</div>
                    </div>
                    
                    <div id="bookingDetails" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-1" id="bookingTitle"></h5>
                                <div id="bookingStatus"></div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="btn-group" role="group">
                                    <a href="#" id="editBtn" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="printBooking()"><i class="bi bi-printer"></i> Print Details</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="emailConfirmation()"><i class="bi bi-envelope"></i> Email Confirmation</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="cancelBooking()"><i class="bi bi-x-circle"></i> Cancel Booking</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Guest and Room Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="bi bi-person"></i> Guest Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-circle me-3" id="guestAvatar"></div>
                                            <div>
                                                <h6 class="mb-1" id="guestName"></h6>
                                                <div class="text-muted" id="guestEmail"></div>
                                            </div>
                                        </div>
                                        <div class="guest-details">
                                            <div class="info-item">
                                                <i class="bi bi-telephone"></i> <span id="guestPhone"></span>
                                            </div>
                                            <div class="info-item">
                                                <i class="bi bi-geo-alt"></i> <span id="guestNationality"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="bi bi-door-open"></i> Room Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-2" id="roomNumber"></h6>
                                        <div class="room-details">
                                            <div class="info-item">
                                                <i class="bi bi-house"></i> <span id="roomType"></span>
                                            </div>
                                            <div class="info-item">
                                                <i class="bi bi-people"></i> <span id="roomOccupancy"></span>
                                            </div>
                                            <div class="info-item">
                                                <i class="bi bi-currency-dollar"></i> <span id="roomRate"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Timeline -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-calendar-range"></i> Booking Timeline</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="timeline-item">
                                            <div class="timeline-icon bg-primary">
                                                <i class="bi bi-calendar-plus"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h6>Booking Created</h6>
                                                <div class="text-muted" id="bookingCreated"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="timeline-item">
                                            <div class="timeline-icon bg-success">
                                                <i class="bi bi-door-open"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h6>Check-in</h6>
                                                <div class="text-muted" id="checkinDate"></div>
                                                <div class="small text-info">3:00 PM</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="timeline-item">
                                            <div class="timeline-icon bg-warning">
                                                <i class="bi bi-door-closed"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h6>Check-out</h6>
                                                <div class="text-muted" id="checkoutDate"></div>
                                                <div class="small text-info">11:00 AM</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="timeline-item">
                                            <div class="timeline-icon bg-info">
                                                <i class="bi bi-moon"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h6>Total Stay</h6>
                                                <div class="text-muted" id="totalNights"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="bi bi-info-circle"></i> Booking Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td><strong>Number of Guests:</strong></td>
                                                <td id="numberOfGuests"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Booking Status:</strong></td>
                                                <td id="currentStatus"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Created On:</strong></td>
                                                <td id="createdDate"></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Updated:</strong></td>
                                                <td id="updatedDate"></td>
                                            </tr>
                                        </table>
                                        
                                        <div id="specialRequestsSection" style="display: none;">
                                            <hr>
                                            <h6><i class="bi bi-chat-left-text"></i> Special Requests</h6>
                                            <div class="bg-light p-3 rounded" id="specialRequests"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="bi bi-calculator"></i> Payment Summary</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td>Room Rate (per night):</td>
                                                <td class="text-end" id="roomRateDisplay"></td>
                                            </tr>
                                            <tr>
                                                <td>Number of Nights:</td>
                                                <td class="text-end" id="nightsDisplay"></td>
                                            </tr>
                                            <tr>
                                                <td>Subtotal:</td>
                                                <td class="text-end" id="subtotalDisplay"></td>
                                            </tr>
                                            <tr>
                                                <td>Tax (10%):</td>
                                                <td class="text-end" id="taxDisplay"></td>
                                            </tr>
                                            <tr class="table-success">
                                                <td><strong>Total Amount:</strong></td>
                                                <td class="text-end"><strong id="totalAmountDisplay"></strong></td>
                                            </tr>
                                        </table>
                                        
                                        <div class="mt-3" id="paymentActions">
                                            <!-- Payment action buttons will be inserted here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Bookings
                            </a>
                            <div id="statusActions">
                                <!-- Status action buttons will be inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2" id="quickActions">
                        <!-- Quick action buttons will be inserted here -->
                    </div>
                </div>
            </div>
            
            <!-- Activity Log -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-clock-history"></i> Activity Log
                    </h6>
                </div>
                <div class="card-body">
                    <div id="activityLog">
                        <div class="text-center p-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const bookingId = {{ $bookingId }};
let currentBooking = null;

document.addEventListener('DOMContentLoaded', function() {
    loadBookingDetails();
});

async function loadBookingDetails() {
    try {
        const booking = await api.get(`/bookings/${bookingId}`);
        currentBooking = booking;
        
        // Update header
        document.getElementById('bookingTitle').textContent = `Booking #${booking.id}`;
        document.getElementById('bookingStatus').innerHTML = getStatusBadge(booking.status);
        
        // Guest information
        document.getElementById('guestAvatar').textContent = 
            `${booking.guest.first_name.charAt(0)}${booking.guest.last_name.charAt(0)}`;
        document.getElementById('guestName').textContent = 
            `${booking.guest.first_name} ${booking.guest.last_name}`;
        document.getElementById('guestEmail').innerHTML = 
            `<a href="mailto:${booking.guest.email}">${booking.guest.email}</a>`;
        document.getElementById('guestPhone').textContent = booking.guest.phone_number || 'Not provided';
        document.getElementById('guestNationality').textContent = booking.guest.nationality;
        
        // Room information
        document.getElementById('roomNumber').textContent = `Room ${booking.room.room_number}`;
        document.getElementById('roomType').textContent = booking.room.room_type.charAt(0).toUpperCase() + booking.room.room_type.slice(1);
        document.getElementById('roomOccupancy').textContent = `Max ${booking.room.max_occupancy} guests`;
        document.getElementById('roomRate').textContent = `$${parseFloat(booking.room.price_per_night).toFixed(2)}/night`;
        
        // Timeline
        document.getElementById('bookingCreated').textContent = formatDate(booking.created_at);
        document.getElementById('checkinDate').textContent = formatDate(booking.check_in_date);
        document.getElementById('checkoutDate').textContent = formatDate(booking.check_out_date);
        document.getElementById('totalNights').textContent = `${booking.total_nights} ${booking.total_nights === 1 ? 'night' : 'nights'}`;
        
        // Booking details
        document.getElementById('numberOfGuests').textContent = booking.number_of_guests;
        document.getElementById('currentStatus').innerHTML = getStatusBadge(booking.status);
        document.getElementById('createdDate').textContent = formatDateTime(booking.created_at);
        document.getElementById('updatedDate').textContent = formatDateTime(booking.updated_at);
        
        // Special requests
        if (booking.special_requests) {
            document.getElementById('specialRequests').textContent = booking.special_requests;
            document.getElementById('specialRequestsSection').style.display = 'block';
        }
        
        // Payment summary
        const roomRate = parseFloat(booking.room.price_per_night);
        const nights = booking.total_nights;
        const subtotal = roomRate * nights;
        const tax = subtotal * 0.1;
        
        document.getElementById('roomRateDisplay').textContent = `$${roomRate.toFixed(2)}`;
        document.getElementById('nightsDisplay').textContent = nights;
        document.getElementById('subtotalDisplay').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('taxDisplay').textContent = `$${tax.toFixed(2)}`;
        document.getElementById('totalAmountDisplay').textContent = `$${parseFloat(booking.total_amount).toFixed(2)}`;
        
        // Update edit button link
        document.getElementById('editBtn').href = `/bookings/${bookingId}/edit`;
        
        // Setup action buttons
        setupActionButtons(booking);
        
        // Hide loading and show content
        document.getElementById('loadingContainer').style.display = 'none';
        document.getElementById('bookingDetails').style.display = 'block';
        
        // Load activity log
        loadActivityLog();
        
    } catch (error) {
        console.error('Error loading booking details:', error);
        document.getElementById('loadingContainer').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Error loading booking details. Please try again.
                <div class="mt-2">
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
                </div>
            </div>
        `;
    }
}

function setupActionButtons(booking) {
    const statusActionsContainer = document.getElementById('statusActions');
    const quickActionsContainer = document.getElementById('quickActions');
    
    let statusButtons = '';
    let quickButtons = '';
    
    // Status-specific actions
    switch (booking.status) {
        case 'pending':
            statusButtons += '<button type="button" class="btn btn-success me-2" onclick="confirmBooking()"><i class="bi bi-check-circle"></i> Confirm</button>';
            break;
        case 'confirmed':
            statusButtons += '<button type="button" class="btn btn-primary me-2" onclick="checkInGuest()"><i class="bi bi-door-open"></i> Check In</button>';
            break;
        case 'checked-in':
            statusButtons += '<button type="button" class="btn btn-warning me-2" onclick="checkOutGuest()"><i class="bi bi-door-closed"></i> Check Out</button>';
            break;
    }
    
    if (booking.status !== 'cancelled' && booking.status !== 'checked-out') {
        statusButtons += '<button type="button" class="btn btn-outline-danger" onclick="cancelBooking()"><i class="bi bi-x-circle"></i> Cancel</button>';
    }
    
    // Quick actions
    quickButtons += `
        <button type="button" class="btn btn-outline-primary" onclick="viewGuest()">
            <i class="bi bi-person"></i> View Guest
        </button>
        <button type="button" class="btn btn-outline-info" onclick="viewRoom()">
            <i class="bi bi-door-open"></i> View Room
        </button>
        <button type="button" class="btn btn-outline-success" onclick="emailConfirmation()">
            <i class="bi bi-envelope"></i> Email Guest
        </button>
        <button type="button" class="btn btn-outline-secondary" onclick="printBooking()">
            <i class="bi bi-printer"></i> Print Details
        </button>
    `;
    
    statusActionsContainer.innerHTML = statusButtons;
    quickActionsContainer.innerHTML = quickButtons;
}

async function loadActivityLog() {
    try {
        // Simulate activity log
        const activities = [
            { action: 'Booking Created', date: currentBooking.created_at, user: 'Admin' },
            { action: 'Payment Pending', date: currentBooking.created_at, user: 'System' }
        ];
        
        if (currentBooking.status === 'confirmed') {
            activities.push({ action: 'Booking Confirmed', date: currentBooking.updated_at, user: 'Admin' });
        }
        
        const container = document.getElementById('activityLog');
        container.innerHTML = activities.map(activity => `
            <div class="activity-item border-bottom pb-2 mb-2">
                <div class="d-flex justify-content-between">
                    <strong>${activity.action}</strong>
                    <small class="text-muted">${formatTime(activity.date)}</small>
                </div>
                <small class="text-muted">by ${activity.user}</small>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading activity log:', error);
    }
}

async function confirmBooking() {
    if (!confirm('Are you sure you want to confirm this booking?')) {
        return;
    }
    
    try {
        showLoading();
        await api.put(`/bookings/${bookingId}/confirm`);
        hideLoading();
        
        showToast('Booking confirmed successfully!');
        loadBookingDetails();
        
    } catch (error) {
        hideLoading();
        console.error('Error confirming booking:', error);
        showToast('Error confirming booking. Please try again.', 'error');
    }
}

async function checkInGuest() {
    if (!confirm('Are you sure you want to check in this guest?')) {
        return;
    }
    
    try {
        showLoading();
        await api.put(`/bookings/${bookingId}/checkin`);
        hideLoading();
        
        showToast('Guest checked in successfully!');
        loadBookingDetails();
        
    } catch (error) {
        hideLoading();
        console.error('Error checking in guest:', error);
        showToast('Error checking in guest. Please try again.', 'error');
    }
}

async function checkOutGuest() {
    if (!confirm('Are you sure you want to check out this guest?')) {
        return;
    }
    
    try {
        showLoading();
        await api.put(`/bookings/${bookingId}/checkout`);
        hideLoading();
        
        showToast('Guest checked out successfully!');
        loadBookingDetails();
        
    } catch (error) {
        hideLoading();
        console.error('Error checking out guest:', error);
        showToast('Error checking out guest. Please try again.', 'error');
    }
}

async function cancelBooking() {
    if (!confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
        return;
    }
    
    try {
        showLoading();
        await api.put(`/bookings/${bookingId}/cancel`);
        hideLoading();
        
        showToast('Booking cancelled successfully!');
        loadBookingDetails();
        
    } catch (error) {
        hideLoading();
        console.error('Error cancelling booking:', error);
        showToast('Error cancelling booking. Please try again.', 'error');
    }
}

function viewGuest() {
    window.location.href = `/guests/${currentBooking.guest.id}`;
}

function viewRoom() {
    window.location.href = `/rooms/${currentBooking.room.id}`;
}

function emailConfirmation() {
    if (currentBooking && currentBooking.guest.email) {
        const subject = `Booking Confirmation - Booking #${currentBooking.id}`;
        const body = `Dear ${currentBooking.guest.first_name},\n\nYour booking has been confirmed.\n\nBooking Details:\n- Check-in: ${formatDate(currentBooking.check_in_date)}\n- Check-out: ${formatDate(currentBooking.check_out_date)}\n- Room: ${currentBooking.room.room_number}\n- Total: $${parseFloat(currentBooking.total_amount).toFixed(2)}\n\nThank you for choosing our hotel!`;
        
        window.location.href = `mailto:${currentBooking.guest.email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    }
}

function printBooking() {
    window.print();
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

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString();
}

function formatDateTime(dateString) {
    return new Date(dateString).toLocaleString();
}

function formatTime(dateString) {
    return new Date(dateString).toLocaleTimeString();
}
</script>
@endpush

@push('styles')
<style>
.avatar-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

.info-item {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.info-item i {
    width: 16px;
    margin-right: 5px;
    color: #6c757d;
}

.timeline-item {
    text-align: center;
    position: relative;
}

.timeline-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto 10px;
}

.timeline-content h6 {
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.activity-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

@media print {
    .btn, .card-header, #quickActions, #activityLog {
        display: none !important;
    }
}
</style>
@endpush