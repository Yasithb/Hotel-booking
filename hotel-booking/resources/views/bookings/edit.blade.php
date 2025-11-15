@extends('layouts.app')

@section('title', 'Edit Booking - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Booking
                    </h4>
                </div>
                <div class="card-body">
                    <div id="loadingContainer" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Loading booking details...</div>
                    </div>
                    
                    <form id="editBookingForm" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="guest_id" class="form-label">Guest *</label>
                                <select class="form-select" id="guest_id" name="guest_id" required>
                                    <option value="">Select a guest...</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="room_id" class="form-label">Room *</label>
                                <select class="form-select" id="room_id" name="room_id" required>
                                    <option value="">Select a room...</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="check_in_date" class="form-label">Check-in Date *</label>
                                <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="check_out_date" class="form-label">Check-out Date *</label>
                                <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="number_of_guests" class="form-label">Number of Guests *</label>
                                <input type="number" class="form-control" id="number_of_guests" name="number_of_guests" min="1" max="10" required>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="checked-in">Checked In</option>
                                    <option value="checked-out">Checked Out</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Special Requests</label>
                            <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Any special requests or notes..."></textarea>
                        </div>
                        
                        <!-- Booking Summary -->
                        <div class="card bg-light mb-3" id="bookingSummary" style="display: none;">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-calculator"></i> Booking Summary</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td>Room Rate (per night):</td>
                                        <td class="text-end" id="summaryRoomRate">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Number of Nights:</td>
                                        <td class="text-end" id="summaryNights">0</td>
                                    </tr>
                                    <tr>
                                        <td>Subtotal:</td>
                                        <td class="text-end" id="summarySubtotal">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td>Tax (10%):</td>
                                        <td class="text-end" id="summaryTax">$0.00</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><strong>Total Amount:</strong></td>
                                        <td class="text-end"><strong id="summaryTotal">$0.00</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="#" id="backBtn" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update Booking
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card" id="roomInfoCard" style="display: none;">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-door-open"></i> Room Information
                    </h6>
                </div>
                <div class="card-body" id="roomInfo">
                    <!-- Room info will be loaded here -->
                </div>
            </div>
            
            <div class="card mt-3" id="guestInfoCard" style="display: none;">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-person"></i> Guest Information
                    </h6>
                </div>
                <div class="card-body" id="guestInfo">
                    <!-- Guest info will be loaded here -->
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
let guests = [];
let rooms = [];

document.addEventListener('DOMContentLoaded', function() {
    loadData();
    setupEventListeners();
});

async function loadData() {
    try {
        // Load guests, rooms, and current booking in parallel
        const [guestsData, roomsData, bookingData] = await Promise.all([
            api.get('/guests'),
            api.get('/rooms'),
            api.get(`/bookings/${bookingId}`)
        ]);
        
        guests = guestsData;
        rooms = roomsData;
        currentBooking = bookingData;
        
        populateSelects();
        populateForm();
        
        // Hide loading and show form
        document.getElementById('loadingContainer').style.display = 'none';
        document.getElementById('editBookingForm').style.display = 'block';
        
        // Set back button link
        document.getElementById('backBtn').href = `/bookings/${bookingId}`;
        
    } catch (error) {
        console.error('Error loading data:', error);
        document.getElementById('loadingContainer').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Error loading booking data. Please try again.
                <div class="mt-2">
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
                </div>
            </div>
        `;
    }
}

function populateSelects() {
    // Populate guests select
    const guestSelect = document.getElementById('guest_id');
    guests.forEach(guest => {
        const option = document.createElement('option');
        option.value = guest.id;
        option.textContent = `${guest.first_name} ${guest.last_name} (${guest.email})`;
        guestSelect.appendChild(option);
    });
    
    // Populate rooms select
    const roomSelect = document.getElementById('room_id');
    rooms.forEach(room => {
        const option = document.createElement('option');
        option.value = room.id;
        option.textContent = `Room ${room.room_number} - ${room.room_type.charAt(0).toUpperCase() + room.room_type.slice(1)} ($${parseFloat(room.price_per_night).toFixed(2)}/night)`;
        if (room.status !== 'available' && room.id !== currentBooking.room_id) {
            option.disabled = true;
            option.textContent += ' (Unavailable)';
        }
        roomSelect.appendChild(option);
    });
}

function populateForm() {
    document.getElementById('guest_id').value = currentBooking.guest_id;
    document.getElementById('room_id').value = currentBooking.room_id;
    document.getElementById('check_in_date').value = currentBooking.check_in_date;
    document.getElementById('check_out_date').value = currentBooking.check_out_date;
    document.getElementById('number_of_guests').value = currentBooking.number_of_guests;
    document.getElementById('status').value = currentBooking.status;
    document.getElementById('special_requests').value = currentBooking.special_requests || '';
    
    // Trigger events to update room/guest info and summary
    updateRoomInfo();
    updateGuestInfo();
    updateBookingSummary();
}

function setupEventListeners() {
    document.getElementById('guest_id').addEventListener('change', updateGuestInfo);
    document.getElementById('room_id').addEventListener('change', updateRoomInfo);
    document.getElementById('check_in_date').addEventListener('change', updateBookingSummary);
    document.getElementById('check_out_date').addEventListener('change', updateBookingSummary);
    document.getElementById('number_of_guests').addEventListener('change', validateOccupancy);
    
    document.getElementById('editBookingForm').addEventListener('submit', handleSubmit);
}

function updateGuestInfo() {
    const guestId = document.getElementById('guest_id').value;
    const guest = guests.find(g => g.id == guestId);
    
    if (guest) {
        document.getElementById('guestInfo').innerHTML = `
            <div class="d-flex align-items-center mb-3">
                <div class="avatar-circle me-3">${guest.first_name.charAt(0)}${guest.last_name.charAt(0)}</div>
                <div>
                    <h6 class="mb-1">${guest.first_name} ${guest.last_name}</h6>
                    <div class="text-muted">${guest.email}</div>
                </div>
            </div>
            <div class="guest-details">
                <div class="info-item">
                    <i class="bi bi-telephone"></i> ${guest.phone_number || 'Not provided'}
                </div>
                <div class="info-item">
                    <i class="bi bi-geo-alt"></i> ${guest.nationality}
                </div>
                <div class="info-item">
                    <i class="bi bi-calendar"></i> Joined ${formatDate(guest.created_at)}
                </div>
            </div>
        `;
        document.getElementById('guestInfoCard').style.display = 'block';
    } else {
        document.getElementById('guestInfoCard').style.display = 'none';
    }
}

function updateRoomInfo() {
    const roomId = document.getElementById('room_id').value;
    const room = rooms.find(r => r.id == roomId);
    
    if (room) {
        document.getElementById('roomInfo').innerHTML = `
            <h6 class="mb-2">Room ${room.room_number}</h6>
            <div class="room-details">
                <div class="info-item">
                    <i class="bi bi-house"></i> ${room.room_type.charAt(0).toUpperCase() + room.room_type.slice(1)}
                </div>
                <div class="info-item">
                    <i class="bi bi-people"></i> Max ${room.max_occupancy} guests
                </div>
                <div class="info-item">
                    <i class="bi bi-currency-dollar"></i> $${parseFloat(room.price_per_night).toFixed(2)}/night
                </div>
                <div class="info-item">
                    <i class="bi bi-circle-fill text-${room.status === 'available' ? 'success' : 'warning'}"></i> 
                    ${room.status.charAt(0).toUpperCase() + room.status.slice(1)}
                </div>
            </div>
        `;
        document.getElementById('roomInfoCard').style.display = 'block';
        updateBookingSummary();
        validateOccupancy();
    } else {
        document.getElementById('roomInfoCard').style.display = 'none';
    }
}

function updateBookingSummary() {
    const roomId = document.getElementById('room_id').value;
    const checkinDate = document.getElementById('check_in_date').value;
    const checkoutDate = document.getElementById('check_out_date').value;
    
    if (roomId && checkinDate && checkoutDate) {
        const room = rooms.find(r => r.id == roomId);
        if (room) {
            const nights = calculateNights(checkinDate, checkoutDate);
            if (nights > 0) {
                const roomRate = parseFloat(room.price_per_night);
                const subtotal = roomRate * nights;
                const tax = subtotal * 0.1;
                const total = subtotal + tax;
                
                document.getElementById('summaryRoomRate').textContent = `$${roomRate.toFixed(2)}`;
                document.getElementById('summaryNights').textContent = nights;
                document.getElementById('summarySubtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('summaryTax').textContent = `$${tax.toFixed(2)}`;
                document.getElementById('summaryTotal').textContent = `$${total.toFixed(2)}`;
                
                document.getElementById('bookingSummary').style.display = 'block';
            } else {
                document.getElementById('bookingSummary').style.display = 'none';
            }
        }
    } else {
        document.getElementById('bookingSummary').style.display = 'none';
    }
}

function validateOccupancy() {
    const roomId = document.getElementById('room_id').value;
    const numberOfGuests = parseInt(document.getElementById('number_of_guests').value);
    
    if (roomId && numberOfGuests) {
        const room = rooms.find(r => r.id == roomId);
        if (room && numberOfGuests > room.max_occupancy) {
            document.getElementById('number_of_guests').setCustomValidity(
                `This room can accommodate maximum ${room.max_occupancy} guests.`
            );
        } else {
            document.getElementById('number_of_guests').setCustomValidity('');
        }
    }
}

function calculateNights(checkinDate, checkoutDate) {
    const checkin = new Date(checkinDate);
    const checkout = new Date(checkoutDate);
    const diffTime = checkout - checkin;
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
}

async function handleSubmit(event) {
    event.preventDefault();
    
    if (!validateForm()) {
        return;
    }
    
    try {
        showLoading();
        
        const formData = {
            guest_id: parseInt(document.getElementById('guest_id').value),
            room_id: parseInt(document.getElementById('room_id').value),
            check_in_date: document.getElementById('check_in_date').value,
            check_out_date: document.getElementById('check_out_date').value,
            number_of_guests: parseInt(document.getElementById('number_of_guests').value),
            status: document.getElementById('status').value,
            special_requests: document.getElementById('special_requests').value
        };
        
        await api.put(`/bookings/${bookingId}`, formData);
        
        hideLoading();
        showToast('Booking updated successfully!');
        
        // Redirect to booking details
        setTimeout(() => {
            window.location.href = `/bookings/${bookingId}`;
        }, 1000);
        
    } catch (error) {
        hideLoading();
        console.error('Error updating booking:', error);
        
        if (error.response && error.response.data && error.response.data.errors) {
            showValidationErrors(error.response.data.errors);
        } else {
            showToast('Error updating booking. Please try again.', 'error');
        }
    }
}

function validateForm() {
    const checkinDate = new Date(document.getElementById('check_in_date').value);
    const checkoutDate = new Date(document.getElementById('check_out_date').value);
    
    if (checkinDate >= checkoutDate) {
        showToast('Check-out date must be after check-in date.', 'error');
        return false;
    }
    
    const nights = calculateNights(document.getElementById('check_in_date').value, document.getElementById('check_out_date').value);
    if (nights <= 0) {
        showToast('Invalid date range.', 'error');
        return false;
    }
    
    return true;
}

function showValidationErrors(errors) {
    Object.keys(errors).forEach(field => {
        const element = document.getElementById(field);
        if (element) {
            element.classList.add('is-invalid');
            
            // Remove existing error message
            const existingError = element.parentNode.querySelector('.invalid-feedback');
            if (existingError) {
                existingError.remove();
            }
            
            // Add new error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = errors[field][0];
            element.parentNode.appendChild(errorDiv);
        }
    });
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
        populateForm();
        // Clear validation errors
        document.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(element => {
            element.remove();
        });
    }
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString();
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

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
}
</style>
@endpush