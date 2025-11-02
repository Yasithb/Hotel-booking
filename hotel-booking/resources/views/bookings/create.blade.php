@extends('layouts.app')

@section('title', 'Create Booking - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-plus"></i> Create New Booking
                    </h4>
                </div>
                <div class="card-body">
                    <form id="bookingForm">
                        <div class="row">
                            <!-- Guest Selection -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="bi bi-person"></i> Guest Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="guest_selection" class="form-label">Select Guest *</label>
                                            <div class="input-group">
                                                <select class="form-select" id="guest_id" name="guest_id" required>
                                                    <option value="">Choose existing guest...</option>
                                                </select>
                                                <button type="button" class="btn btn-outline-primary" onclick="showNewGuestForm()">
                                                    <i class="bi bi-person-plus"></i> New
                                                </button>
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div id="selectedGuestInfo" class="alert alert-info" style="display: none;">
                                            <h6><i class="bi bi-info-circle"></i> Selected Guest</h6>
                                            <div id="guestDetails"></div>
                                        </div>
                                        
                                        <!-- Quick Guest Creation Form -->
                                        <div id="newGuestForm" style="display: none;">
                                            <div class="border rounded p-3 bg-light">
                                                <h6><i class="bi bi-person-plus"></i> Quick Guest Registration</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="new_first_name" class="form-label">First Name *</label>
                                                            <input type="text" class="form-control" id="new_first_name" name="new_first_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="new_last_name" class="form-label">Last Name *</label>
                                                            <input type="text" class="form-control" id="new_last_name" name="new_last_name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="new_email" class="form-label">Email *</label>
                                                            <input type="email" class="form-control" id="new_email" name="new_email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="new_phone" class="form-label">Phone</label>
                                                            <input type="tel" class="form-control" id="new_phone" name="new_phone">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="new_nationality" class="form-label">Nationality *</label>
                                                    <select class="form-select" id="new_nationality" name="new_nationality">
                                                        <option value="">Select nationality</option>
                                                        <option value="United States">United States</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="France">France</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-success btn-sm" onclick="createQuickGuest()">
                                                        <i class="bi bi-check"></i> Create Guest
                                                    </button>
                                                    <button type="button" class="btn btn-secondary btn-sm" onclick="hideNewGuestForm()">
                                                        <i class="bi bi-x"></i> Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Room Selection -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="bi bi-door-open"></i> Room Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="room_id" class="form-label">Select Room *</label>
                                            <select class="form-select" id="room_id" name="room_id" required onchange="updateRoomInfo()">
                                                <option value="">Choose available room...</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div id="selectedRoomInfo" class="alert alert-success" style="display: none;">
                                            <h6><i class="bi bi-info-circle"></i> Selected Room</h6>
                                            <div id="roomDetails"></div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="number_of_guests" class="form-label">Number of Guests *</label>
                                            <input type="number" class="form-control" id="number_of_guests" name="number_of_guests" min="1" max="10" value="1" required>
                                            <div class="invalid-feedback"></div>
                                            <div class="form-text">Maximum occupancy will be shown after room selection.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Details -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-calendar"></i> Booking Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="check_in_date" class="form-label">Check-in Date *</label>
                                            <input type="date" class="form-control" id="check_in_date" name="check_in_date" required onchange="calculateTotal()">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="check_out_date" class="form-label">Check-out Date *</label>
                                            <input type="date" class="form-control" id="check_out_date" name="check_out_date" required onchange="calculateTotal()">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Booking Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="pending">Pending</option>
                                                <option value="confirmed" selected>Confirmed</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="total_nights" class="form-label">Total Nights</label>
                                            <input type="number" class="form-control" id="total_nights" name="total_nights" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="special_requests" class="form-label">Special Requests</label>
                                    <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Any special requests or notes for this booking..."></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pricing Summary -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-calculator"></i> Pricing Summary</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-sm">
                                            <tr>
                                                <td>Room Rate per Night:</td>
                                                <td class="text-end" id="room_rate">$0.00</td>
                                            </tr>
                                            <tr>
                                                <td>Number of Nights:</td>
                                                <td class="text-end" id="nights_display">0</td>
                                            </tr>
                                            <tr>
                                                <td>Subtotal:</td>
                                                <td class="text-end" id="subtotal">$0.00</td>
                                            </tr>
                                            <tr>
                                                <td>Tax (10%):</td>
                                                <td class="text-end" id="tax_amount">$0.00</td>
                                            </tr>
                                            <tr class="table-primary">
                                                <td><strong>Total Amount:</strong></td>
                                                <td class="text-end"><strong id="total_amount_display">$0.00</strong></td>
                                            </tr>
                                        </table>
                                        <input type="hidden" id="total_amount" name="total_amount" value="0">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            <h6><i class="bi bi-info-circle"></i> Pricing Notes</h6>
                                            <ul class="mb-0 small">
                                                <li>Prices include all applicable taxes</li>
                                                <li>Check-in: 3:00 PM</li>
                                                <li>Check-out: 11:00 AM</li>
                                                <li>Cancellation policy applies</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Bookings
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" onclick="resetForm()">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-calendar-plus"></i> Create Booking
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let availableRooms = [];
let selectedRoom = null;

document.addEventListener('DOMContentLoaded', function() {
    loadGuests();
    loadAvailableRooms();
    
    document.getElementById('bookingForm').addEventListener('submit', handleSubmit);
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('check_in_date').min = today;
    document.getElementById('check_out_date').min = today;
    
    // Update check-out min date when check-in changes
    document.getElementById('check_in_date').addEventListener('change', function() {
        const checkInDate = new Date(this.value);
        const nextDay = new Date(checkInDate);
        nextDay.setDate(nextDay.getDate() + 1);
        document.getElementById('check_out_date').min = nextDay.toISOString().split('T')[0];
        
        // Clear check-out if it's before check-in
        const checkOutDate = new Date(document.getElementById('check_out_date').value);
        if (checkOutDate <= checkInDate) {
            document.getElementById('check_out_date').value = '';
        }
    });
    
    // Pre-select guest and room if provided in URL
    const urlParams = new URLSearchParams(window.location.search);
    const guestId = urlParams.get('guest_id');
    const roomId = urlParams.get('room_id');
    
    if (guestId) {
        setTimeout(() => {
            document.getElementById('guest_id').value = guestId;
            updateGuestInfo();
        }, 500);
    }
    
    if (roomId) {
        setTimeout(() => {
            document.getElementById('room_id').value = roomId;
            updateRoomInfo();
        }, 500);
    }
});

async function loadGuests() {
    try {
        const guests = await api.get('/guests?per_page=1000');
        const select = document.getElementById('guest_id');
        
        guests.data.forEach(guest => {
            const option = document.createElement('option');
            option.value = guest.id;
            option.textContent = `${guest.first_name} ${guest.last_name} (${guest.email})`;
            if (guest.is_vip) {
                option.textContent += ' - VIP';
            }
            select.appendChild(option);
        });
        
        // Add change event listener
        select.addEventListener('change', updateGuestInfo);
        
    } catch (error) {
        console.error('Error loading guests:', error);
    }
}

async function loadAvailableRooms() {
    try {
        const rooms = await api.get('/rooms?status=available&per_page=1000');
        availableRooms = rooms.data;
        updateRoomDropdown();
        
    } catch (error) {
        console.error('Error loading rooms:', error);
    }
}

function updateRoomDropdown() {
    const select = document.getElementById('room_id');
    
    // Clear existing options except the first one
    while (select.children.length > 1) {
        select.removeChild(select.lastChild);
    }
    
    availableRooms.forEach(room => {
        const option = document.createElement('option');
        option.value = room.id;
        option.textContent = `Room ${room.room_number} - ${room.room_type.charAt(0).toUpperCase() + room.room_type.slice(1)} ($${parseFloat(room.price_per_night).toFixed(2)}/night)`;
        select.appendChild(option);
    });
}

function updateGuestInfo() {
    const guestId = document.getElementById('guest_id').value;
    const infoDiv = document.getElementById('selectedGuestInfo');
    const detailsDiv = document.getElementById('guestDetails');
    
    if (!guestId) {
        infoDiv.style.display = 'none';
        return;
    }
    
    // Get guest info from API (for demo, we'll use a simple approach)
    fetch(`/api/guests/${guestId}`)
        .then(response => response.json())
        .then(guest => {
            detailsDiv.innerHTML = `
                <strong>Name:</strong> ${guest.first_name} ${guest.last_name}<br>
                <strong>Email:</strong> ${guest.email}<br>
                <strong>Phone:</strong> ${guest.phone_number || 'N/A'}<br>
                <strong>Nationality:</strong> ${guest.nationality}
                ${guest.is_vip ? '<br><span class="badge bg-warning text-dark">VIP Guest</span>' : ''}
            `;
            infoDiv.style.display = 'block';
        })
        .catch(error => {
            console.error('Error loading guest info:', error);
            infoDiv.style.display = 'none';
        });
}

function updateRoomInfo() {
    const roomId = document.getElementById('room_id').value;
    const infoDiv = document.getElementById('selectedRoomInfo');
    const detailsDiv = document.getElementById('roomDetails');
    const guestsInput = document.getElementById('number_of_guests');
    
    if (!roomId) {
        infoDiv.style.display = 'none';
        return;
    }
    
    selectedRoom = availableRooms.find(room => room.id == roomId);
    
    if (selectedRoom) {
        detailsDiv.innerHTML = `
            <strong>Room:</strong> ${selectedRoom.room_number}<br>
            <strong>Type:</strong> ${selectedRoom.room_type.charAt(0).toUpperCase() + selectedRoom.room_type.slice(1)}<br>
            <strong>Price:</strong> $${parseFloat(selectedRoom.price_per_night).toFixed(2)} per night<br>
            <strong>Max Occupancy:</strong> ${selectedRoom.max_occupancy} guests
        `;
        
        // Update guest input constraints
        guestsInput.max = selectedRoom.max_occupancy;
        
        // Update pricing
        document.getElementById('room_rate').textContent = `$${parseFloat(selectedRoom.price_per_night).toFixed(2)}`;
        
        infoDiv.style.display = 'block';
        calculateTotal();
    }
}

function calculateTotal() {
    const checkInDate = document.getElementById('check_in_date').value;
    const checkOutDate = document.getElementById('check_out_date').value;
    
    if (!checkInDate || !checkOutDate || !selectedRoom) {
        return;
    }
    
    const checkIn = new Date(checkInDate);
    const checkOut = new Date(checkOutDate);
    
    if (checkOut <= checkIn) {
        return;
    }
    
    const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
    const roomRate = parseFloat(selectedRoom.price_per_night);
    const subtotal = nights * roomRate;
    const tax = subtotal * 0.1; // 10% tax
    const total = subtotal + tax;
    
    // Update display
    document.getElementById('total_nights').value = nights;
    document.getElementById('nights_display').textContent = nights;
    document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
    document.getElementById('tax_amount').textContent = `$${tax.toFixed(2)}`;
    document.getElementById('total_amount_display').textContent = `$${total.toFixed(2)}`;
    document.getElementById('total_amount').value = total.toFixed(2);
}

function showNewGuestForm() {
    document.getElementById('newGuestForm').style.display = 'block';
    document.getElementById('guest_id').disabled = true;
}

function hideNewGuestForm() {
    document.getElementById('newGuestForm').style.display = 'none';
    document.getElementById('guest_id').disabled = false;
    
    // Clear new guest form
    document.getElementById('new_first_name').value = '';
    document.getElementById('new_last_name').value = '';
    document.getElementById('new_email').value = '';
    document.getElementById('new_phone').value = '';
    document.getElementById('new_nationality').value = '';
}

async function createQuickGuest() {
    const formData = {
        first_name: document.getElementById('new_first_name').value,
        last_name: document.getElementById('new_last_name').value,
        email: document.getElementById('new_email').value,
        phone_number: document.getElementById('new_phone').value,
        nationality: document.getElementById('new_nationality').value
    };
    
    // Basic validation
    if (!formData.first_name || !formData.last_name || !formData.email || !formData.nationality) {
        showToast('Please fill in all required fields for the new guest.', 'error');
        return;
    }
    
    try {
        showLoading();
        const guest = await api.post('/guests', formData);
        hideLoading();
        
        // Add new guest to dropdown
        const select = document.getElementById('guest_id');
        const option = document.createElement('option');
        option.value = guest.id;
        option.textContent = `${guest.first_name} ${guest.last_name} (${guest.email})`;
        select.appendChild(option);
        
        // Select the new guest
        select.value = guest.id;
        updateGuestInfo();
        
        hideNewGuestForm();
        showToast('Guest created successfully!');
        
    } catch (error) {
        hideLoading();
        console.error('Error creating guest:', error);
        showToast('Error creating guest. Please try again.', 'error');
    }
}

async function handleSubmit(e) {
    e.preventDefault();
    
    // Clear previous validation errors
    clearValidationErrors();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    
    // Convert numeric values
    data.number_of_guests = parseInt(data.number_of_guests);
    data.total_nights = parseInt(data.total_nights);
    data.total_amount = parseFloat(data.total_amount);
    
    // Client-side validation
    if (!validateForm(data)) {
        return;
    }
    
    try {
        showLoading();
        const response = await api.post('/bookings', data);
        hideLoading();
        
        showToast('Booking created successfully!');
        setTimeout(() => {
            window.location.href = `/bookings/${response.id}`;
        }, 1500);
        
    } catch (error) {
        hideLoading();
        console.error('Error creating booking:', error);
        
        if (error.errors) {
            displayValidationErrors(error.errors);
        } else {
            showToast('Error creating booking. Please try again.', 'error');
        }
    }
}

function validateForm(data) {
    let isValid = true;
    
    // Required fields validation
    const requiredFields = ['guest_id', 'room_id', 'check_in_date', 'check_out_date', 'number_of_guests'];
    requiredFields.forEach(field => {
        if (!data[field]) {
            markFieldInvalid(field, 'This field is required.');
            isValid = false;
        }
    });
    
    // Date validation
    if (data.check_in_date && data.check_out_date) {
        const checkIn = new Date(data.check_in_date);
        const checkOut = new Date(data.check_out_date);
        
        if (checkOut <= checkIn) {
            markFieldInvalid('check_out_date', 'Check-out date must be after check-in date.');
            isValid = false;
        }
    }
    
    // Guest count validation
    if (selectedRoom && data.number_of_guests > selectedRoom.max_occupancy) {
        markFieldInvalid('number_of_guests', `Maximum ${selectedRoom.max_occupancy} guests allowed for this room.`);
        isValid = false;
    }
    
    return isValid;
}

function resetForm() {
    if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        document.getElementById('bookingForm').reset();
        clearValidationErrors();
        
        // Hide info panels
        document.getElementById('selectedGuestInfo').style.display = 'none';
        document.getElementById('selectedRoomInfo').style.display = 'none';
        hideNewGuestForm();
        
        // Reset pricing
        document.getElementById('room_rate').textContent = '$0.00';
        document.getElementById('nights_display').textContent = '0';
        document.getElementById('subtotal').textContent = '$0.00';
        document.getElementById('tax_amount').textContent = '$0.00';
        document.getElementById('total_amount_display').textContent = '$0.00';
        
        selectedRoom = null;
    }
}

function markFieldInvalid(fieldName, message) {
    const field = document.getElementById(fieldName);
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    
    field.classList.add('is-invalid');
    if (feedback) {
        feedback.textContent = message;
    }
}

function clearValidationErrors() {
    document.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(element => {
        element.textContent = '';
    });
}

function displayValidationErrors(errors) {
    for (const [field, messages] of Object.entries(errors)) {
        markFieldInvalid(field, messages[0]);
    }
}
</script>
@endpush