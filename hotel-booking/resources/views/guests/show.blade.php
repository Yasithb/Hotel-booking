@extends('layouts.app')

@section('title', 'Guest Details - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-person"></i> Guest Details
                    </h4>
                </div>
                <div class="card-body">
                    <div id="loadingContainer" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Loading guest details...</div>
                    </div>
                    
                    <div id="guestDetails" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3" id="guestAvatar"></div>
                                    <div>
                                        <h5 class="text-primary mb-1" id="guestName"></h5>
                                        <div id="guestStatus"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="btn-group" role="group">
                                    <a href="#" id="editBtn" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-outline-success" onclick="createBooking()">
                                        <i class="bi bi-calendar-plus"></i> New Booking
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteGuest()">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Personal Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="bi bi-person-badge"></i> Personal Information</h6>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <div class="info-value" id="fullName"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <div class="info-value" id="email"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <div class="info-value" id="phoneNumber"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Date of Birth</label>
                                    <div class="info-value" id="dateOfBirth"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Nationality</label>
                                    <div class="info-value" id="nationality"></div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"><i class="bi bi-card-text"></i> Additional Information</h6>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Gender</label>
                                    <div class="info-value" id="gender"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Passport/ID Number</label>
                                    <div class="info-value" id="passportNumber"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <div class="info-value" id="address"></div>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="form-label fw-bold">Registration Date</label>
                                    <div class="info-value" id="registrationDate"></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Emergency Contact -->
                        <div class="row mt-4" id="emergencyContactSection" style="display: none;">
                            <div class="col-12">
                                <h6 class="text-primary mb-3"><i class="bi bi-exclamation-triangle"></i> Emergency Contact</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-group mb-3">
                                            <label class="form-label fw-bold">Contact Name</label>
                                            <div class="info-value" id="emergencyContactName"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-group mb-3">
                                            <label class="form-label fw-bold">Contact Phone</label>
                                            <div class="info-value" id="emergencyContactPhone"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Special Requests -->
                        <div class="row mt-4" id="specialRequestsSection" style="display: none;">
                            <div class="col-12">
                                <h6 class="text-primary mb-3"><i class="bi bi-chat-left-text"></i> Special Requests & Notes</h6>
                                <div class="info-group mb-3">
                                    <div class="info-value" id="specialRequests"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('guests.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Guests
                            </a>
                            <button type="button" class="btn btn-primary" onclick="printGuestInfo()">
                                <i class="bi bi-printer"></i> Print Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Guest Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-bar-chart"></i> Guest Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-primary mb-1" id="totalBookings">0</h4>
                                <small class="text-muted">Total Bookings</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-success mb-1" id="totalNights">0</h4>
                                <small class="text-muted">Total Nights</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-info mb-1" id="totalSpent">$0</h4>
                                <small class="text-muted">Total Spent</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-warning mb-1" id="avgStay">0</h4>
                                <small class="text-muted">Avg Stay (days)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Bookings -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="bi bi-calendar-event"></i> Recent Bookings
                    </h6>
                    <a href="#" onclick="viewAllBookings()" class="text-decoration-none small">View All</a>
                </div>
                <div class="card-body">
                    <div id="recentBookings">
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
                            <i class="bi bi-calendar-plus"></i> New Booking
                        </button>
                        <button type="button" class="btn btn-outline-info" onclick="sendEmail()">
                            <i class="bi bi-envelope"></i> Send Email
                        </button>
                        <button type="button" class="btn btn-outline-success" onclick="toggleVipStatus()">
                            <i class="bi bi-star"></i> <span id="vipToggleText">Make VIP</span>
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="viewBookingHistory()">
                            <i class="bi bi-clock-history"></i> Booking History
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const guestId = {{ $guestId }};
let currentGuest = null;

document.addEventListener('DOMContentLoaded', function() {
    loadGuestDetails();
    loadGuestStatistics();
    loadRecentBookings();
});

async function loadGuestDetails() {
    try {
        const guest = await api.get(`/guests/${guestId}`);
        currentGuest = guest;
        
        // Update avatar
        document.getElementById('guestAvatar').textContent = 
            `${guest.first_name.charAt(0)}${guest.last_name.charAt(0)}`;
        
        // Update header
        document.getElementById('guestName').textContent = 
            `${guest.first_name} ${guest.last_name}`;
        
        // Guest status
        let statusHtml = '';
        if (guest.is_vip) {
            statusHtml += '<span class="badge bg-warning text-dark me-2">VIP Guest</span>';
        }
        if (guest.marketing_consent) {
            statusHtml += '<span class="badge bg-info">Marketing Consent</span>';
        }
        document.getElementById('guestStatus').innerHTML = statusHtml || '<span class="text-muted">Regular Guest</span>';
        
        // Personal information
        document.getElementById('fullName').textContent = `${guest.first_name} ${guest.last_name}`;
        document.getElementById('email').innerHTML = `<a href="mailto:${guest.email}">${guest.email}</a>`;
        document.getElementById('phoneNumber').innerHTML = guest.phone_number ? 
            `<a href="tel:${guest.phone_number}">${guest.phone_number}</a>` : 'Not provided';
        document.getElementById('dateOfBirth').textContent = guest.date_of_birth ? 
            formatDate(guest.date_of_birth) + ` (${calculateAge(guest.date_of_birth)} years old)` : 'Not provided';
        document.getElementById('nationality').innerHTML = `<span class="badge bg-light text-dark">${guest.nationality}</span>`;
        
        // Additional information
        document.getElementById('gender').textContent = guest.gender ? 
            guest.gender.charAt(0).toUpperCase() + guest.gender.slice(1) : 'Not specified';
        document.getElementById('passportNumber').textContent = guest.passport_number || 'Not provided';
        document.getElementById('address').textContent = guest.address || 'Not provided';
        document.getElementById('registrationDate').textContent = formatDateTime(guest.created_at);
        
        // Emergency contact
        if (guest.emergency_contact_name || guest.emergency_contact_phone) {
            document.getElementById('emergencyContactName').textContent = guest.emergency_contact_name || 'Not provided';
            document.getElementById('emergencyContactPhone').innerHTML = guest.emergency_contact_phone ? 
                `<a href="tel:${guest.emergency_contact_phone}">${guest.emergency_contact_phone}</a>` : 'Not provided';
            document.getElementById('emergencyContactSection').style.display = 'block';
        }
        
        // Special requests
        if (guest.special_requests) {
            document.getElementById('specialRequests').textContent = guest.special_requests;
            document.getElementById('specialRequestsSection').style.display = 'block';
        }
        
        // Update edit button link
        document.getElementById('editBtn').href = `/guests/${guestId}/edit`;
        
        // Update VIP toggle text
        document.getElementById('vipToggleText').textContent = guest.is_vip ? 'Remove VIP' : 'Make VIP';
        
        // Hide loading and show content
        document.getElementById('loadingContainer').style.display = 'none';
        document.getElementById('guestDetails').style.display = 'block';
        
    } catch (error) {
        console.error('Error loading guest details:', error);
        document.getElementById('loadingContainer').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Error loading guest details. Please try again.
                <div class="mt-2">
                    <a href="{{ route('guests.index') }}" class="btn btn-secondary">Back to Guests</a>
                </div>
            </div>
        `;
    }
}

async function loadGuestStatistics() {
    try {
        const stats = await api.get(`/guests/${guestId}/statistics`);
        
        document.getElementById('totalBookings').textContent = stats.total_bookings || 0;
        document.getElementById('totalNights').textContent = stats.total_nights || 0;
        document.getElementById('totalSpent').textContent = `$${(stats.total_spent || 0).toFixed(0)}`;
        document.getElementById('avgStay').textContent = (stats.average_stay || 0).toFixed(1);
        
    } catch (error) {
        console.error('Error loading guest statistics:', error);
    }
}

async function loadRecentBookings() {
    try {
        const bookings = await api.get(`/guests/${guestId}/bookings?limit=5`);
        const container = document.getElementById('recentBookings');
        
        if (bookings.length > 0) {
            container.innerHTML = bookings.map(booking => `
                <div class="booking-item border-bottom pb-2 mb-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Booking #${booking.id}</strong>
                            <div class="text-muted small">
                                Room ${booking.room.room_number} - ${booking.room.room_type}
                            </div>
                            <div class="text-muted small">
                                ${formatDate(booking.check_in_date)} - ${formatDate(booking.check_out_date)}
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-${getStatusColor(booking.status)}">${booking.status}</span>
                            <div class="text-muted small">$${parseFloat(booking.total_amount).toFixed(2)}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<div class="text-muted text-center">No bookings yet</div>';
        }
    } catch (error) {
        console.error('Error loading bookings:', error);
        document.getElementById('recentBookings').innerHTML = '<div class="text-danger text-center">Error loading bookings</div>';
    }
}

async function deleteGuest() {
    if (!confirm('Are you sure you want to delete this guest? This action cannot be undone and will also remove all associated bookings.')) {
        return;
    }
    
    try {
        showLoading();
        await api.delete(`/guests/${guestId}`);
        hideLoading();
        
        showToast('Guest deleted successfully!');
        setTimeout(() => {
            window.location.href = '{{ route("guests.index") }}';
        }, 1500);
        
    } catch (error) {
        hideLoading();
        console.error('Error deleting guest:', error);
        showToast('Error deleting guest. Please try again.', 'error');
    }
}

async function toggleVipStatus() {
    if (!currentGuest) return;
    
    const newStatus = !currentGuest.is_vip;
    const action = newStatus ? 'grant VIP status to' : 'remove VIP status from';
    
    if (!confirm(`Are you sure you want to ${action} this guest?`)) {
        return;
    }
    
    try {
        showLoading();
        await api.put(`/guests/${guestId}`, { is_vip: newStatus });
        hideLoading();
        
        currentGuest.is_vip = newStatus;
        
        // Update UI
        document.getElementById('vipToggleText').textContent = newStatus ? 'Remove VIP' : 'Make VIP';
        
        // Update status display
        let statusHtml = '';
        if (newStatus) {
            statusHtml += '<span class="badge bg-warning text-dark me-2">VIP Guest</span>';
        }
        if (currentGuest.marketing_consent) {
            statusHtml += '<span class="badge bg-info">Marketing Consent</span>';
        }
        document.getElementById('guestStatus').innerHTML = statusHtml || '<span class="text-muted">Regular Guest</span>';
        
        showToast(`Guest ${newStatus ? 'promoted to VIP' : 'VIP status removed'} successfully!`);
        
    } catch (error) {
        hideLoading();
        console.error('Error updating VIP status:', error);
        showToast('Error updating VIP status. Please try again.', 'error');
    }
}

function createBooking() {
    window.location.href = `/bookings/create?guest_id=${guestId}`;
}

function viewAllBookings() {
    window.location.href = `/bookings?guest_id=${guestId}`;
}

function viewBookingHistory() {
    window.location.href = `/bookings?guest_id=${guestId}`;
}

function sendEmail() {
    if (currentGuest && currentGuest.email) {
        window.location.href = `mailto:${currentGuest.email}`;
    }
}

function printGuestInfo() {
    window.print();
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

function formatDateTime(dateString) {
    return new Date(dateString).toLocaleString();
}

function calculateAge(birthDate) {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    
    return age;
}
</script>
@endpush

@push('styles')
<style>
.avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 18px;
}

.info-group {
    margin-bottom: 1rem;
}

.info-value {
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.stat-item {
    padding: 0.5rem;
}

.booking-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}

@media print {
    .btn, .card-header, #recentBookings, .quick-actions {
        display: none !important;
    }
}
</style>
@endpush