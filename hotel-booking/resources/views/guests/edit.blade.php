@extends('layouts.app')

@section('title', 'Edit Guest - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Guest
                    </h4>
                </div>
                <div class="card-body">
                    <div id="loadingContainer" class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2">Loading guest data...</div>
                    </div>
                    
                    <form id="guestForm" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback"></div>
                                    <div class="form-text">We'll use this for booking confirmations and updates.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="+1 (555) 123-4567">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nationality" class="form-label">Nationality *</label>
                                    <select class="form-select" id="nationality" name="nationality" required>
                                        <option value="">Select nationality</option>
                                        <option value="United States">United States</option>
                                        <option value="Canada">Canada</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Germany">Germany</option>
                                        <option value="France">France</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Japan">Japan</option>
                                        <option value="China">China</option>
                                        <option value="India">India</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Russia">Russia</option>
                                        <option value="South Korea">South Korea</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="passport_number" class="form-label">Passport/ID Number</label>
                                    <input type="text" class="form-control" id="passport_number" name="passport_number" placeholder="e.g., A12345678">
                                    <div class="invalid-feedback"></div>
                                    <div class="form-text">Required for international guests.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="">Prefer not to say</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Complete address including city, state/province, and postal code"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_name" class="form-label">Emergency Contact Name</label>
                                    <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" placeholder="Full name">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone</label>
                                    <input type="tel" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" placeholder="+1 (555) 123-4567">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Special Requests/Notes</label>
                            <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Dietary restrictions, accessibility needs, preferences, etc."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_vip" name="is_vip">
                                        <label class="form-check-label" for="is_vip">
                                            <i class="bi bi-star text-warning"></i> VIP Guest
                                        </label>
                                        <div class="form-text">VIP guests receive priority service and special amenities.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="marketing_consent" name="marketing_consent">
                                        <label class="form-check-label" for="marketing_consent">
                                            Marketing Consent
                                        </label>
                                        <div class="form-text">Guest agrees to receive promotional emails and offers.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Data Protection:</strong> Guest information is updated securely and changes are logged for audit purposes.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('guests.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Guests
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Guest
                            </button>
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
const guestId = {{ $guestId }};
let originalEmail = '';

document.addEventListener('DOMContentLoaded', function() {
    loadGuestData();
    
    document.getElementById('guestForm').addEventListener('submit', handleSubmit);
    
    // Set max date for date of birth (must be at least 18 years old)
    const today = new Date();
    const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    document.getElementById('date_of_birth').max = maxDate.toISOString().split('T')[0];
    
    // Auto-format phone numbers
    document.getElementById('phone_number').addEventListener('input', formatPhoneNumber);
    document.getElementById('emergency_contact_phone').addEventListener('input', formatPhoneNumber);
    
    // Validate email in real-time (but only if changed)
    document.getElementById('email').addEventListener('blur', validateEmail);
});

async function loadGuestData() {
    try {
        const guest = await api.get(`/guests/${guestId}`);
        
        // Populate form fields
        document.getElementById('first_name').value = guest.first_name || '';
        document.getElementById('last_name').value = guest.last_name || '';
        document.getElementById('email').value = guest.email || '';
        originalEmail = guest.email || '';
        document.getElementById('phone_number').value = guest.phone_number || '';
        document.getElementById('date_of_birth').value = guest.date_of_birth || '';
        document.getElementById('nationality').value = guest.nationality || '';
        document.getElementById('passport_number').value = guest.passport_number || '';
        document.getElementById('gender').value = guest.gender || '';
        document.getElementById('address').value = guest.address || '';
        document.getElementById('emergency_contact_name').value = guest.emergency_contact_name || '';
        document.getElementById('emergency_contact_phone').value = guest.emergency_contact_phone || '';
        document.getElementById('special_requests').value = guest.special_requests || '';
        document.getElementById('is_vip').checked = guest.is_vip || false;
        document.getElementById('marketing_consent').checked = guest.marketing_consent || false;
        
        // Hide loading and show form
        document.getElementById('loadingContainer').style.display = 'none';
        document.getElementById('guestForm').style.display = 'block';
        
    } catch (error) {
        console.error('Error loading guest data:', error);
        document.getElementById('loadingContainer').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle"></i>
                Error loading guest data. Please try again.
                <div class="mt-2">
                    <a href="{{ route('guests.index') }}" class="btn btn-secondary">Back to Guests</a>
                </div>
            </div>
        `;
    }
}

async function handleSubmit(e) {
    e.preventDefault();
    
    // Clear previous validation errors
    clearValidationErrors();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    
    // Convert boolean values
    data.is_vip = document.getElementById('is_vip').checked;
    data.marketing_consent = document.getElementById('marketing_consent').checked;
    
    // Client-side validation
    if (!validateForm(data)) {
        return;
    }
    
    try {
        showLoading();
        const response = await api.put(`/guests/${guestId}`, data);
        hideLoading();
        
        showToast('Guest updated successfully!');
        setTimeout(() => {
            window.location.href = '{{ route("guests.index") }}';
        }, 1500);
        
    } catch (error) {
        hideLoading();
        console.error('Error updating guest:', error);
        
        if (error.errors) {
            displayValidationErrors(error.errors);
        } else {
            showToast('Error updating guest. Please try again.', 'error');
        }
    }
}

function validateForm(data) {
    let isValid = true;
    
    // Required fields validation
    const requiredFields = ['first_name', 'last_name', 'email', 'nationality'];
    requiredFields.forEach(field => {
        if (!data[field] || data[field].trim() === '') {
            markFieldInvalid(field, 'This field is required.');
            isValid = false;
        }
    });
    
    // Email validation
    if (data.email && !isValidEmail(data.email)) {
        markFieldInvalid('email', 'Please enter a valid email address.');
        isValid = false;
    }
    
    // Phone number validation
    if (data.phone_number && data.phone_number.length < 10) {
        markFieldInvalid('phone_number', 'Please enter a valid phone number.');
        isValid = false;
    }
    
    // Date of birth validation (must be at least 18 years old)
    if (data.date_of_birth) {
        const birthDate = new Date(data.date_of_birth);
        const today = new Date();
        const age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (age < 18 || (age === 18 && monthDiff < 0) || (age === 18 && monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            markFieldInvalid('date_of_birth', 'Guest must be at least 18 years old.');
            isValid = false;
        }
    }
    
    return isValid;
}

async function validateEmail() {
    const email = document.getElementById('email').value.trim();
    if (!email || email === originalEmail) return;
    
    if (!isValidEmail(email)) {
        markFieldInvalid('email', 'Please enter a valid email address.');
        return;
    }
    
    try {
        // Check if email already exists (excluding current guest)
        const response = await api.get(`/guests/check-email?email=${encodeURIComponent(email)}&exclude=${guestId}`);
        if (response.exists) {
            markFieldInvalid('email', 'This email address is already registered.');
        } else {
            clearFieldError('email');
        }
    } catch (error) {
        console.error('Error checking email:', error);
    }
}

function formatPhoneNumber(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    if (value.length >= 10) {
        if (value.startsWith('1') && value.length === 11) {
            // US number with country code
            value = `+1 (${value.substr(1, 3)}) ${value.substr(4, 3)}-${value.substr(7, 4)}`;
        } else if (value.length === 10) {
            // US number without country code
            value = `(${value.substr(0, 3)}) ${value.substr(3, 3)}-${value.substr(6, 4)}`;
        }
    }
    
    e.target.value = value;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function markFieldInvalid(fieldName, message) {
    const field = document.getElementById(fieldName);
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    
    field.classList.add('is-invalid');
    if (feedback) {
        feedback.textContent = message;
    }
}

function clearFieldError(fieldName) {
    const field = document.getElementById(fieldName);
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    
    field.classList.remove('is-invalid');
    if (feedback) {
        feedback.textContent = '';
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

@push('styles')
<style>
.form-text {
    font-size: 0.875em;
}

.alert {
    border-left: 4px solid;
}

.alert-info {
    border-left-color: #0dcaf0;
}

.form-check-label i {
    margin-right: 5px;
}
</style>
@endpush