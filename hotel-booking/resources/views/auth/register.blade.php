@extends('layouts.app')

@section('title', 'Register - Hotel Booking System')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus"></i>
                        Create Your Account
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Oops!</strong> There were some problems with your input:
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">
                                    <i class="bi bi-person"></i> First Name
                                </label>
                                <input type="text" 
                                       class="form-control @error('first_name') is-invalid @enderror" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="{{ old('first_name') }}" 
                                       required 
                                       autofocus
                                       placeholder="Enter your first name">
                                @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">
                                    <i class="bi bi-person"></i> Last Name
                                </label>
                                <input type="text" 
                                       class="form-control @error('last_name') is-invalid @enderror" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="{{ old('last_name') }}" 
                                       required
                                       placeholder="Enter your last name">
                                @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   placeholder="Enter your email address">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">
                                    <i class="bi bi-telephone"></i> Phone Number
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" 
                                       name="phone_number" 
                                       value="{{ old('phone_number') }}" 
                                       placeholder="Enter your phone number">
                                @error('phone_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nationality" class="form-label">
                                    <i class="bi bi-geo-alt"></i> Nationality
                                </label>
                                <select class="form-select @error('nationality') is-invalid @enderror" 
                                        id="nationality" 
                                        name="nationality">
                                    <option value="">Select your nationality</option>
                                    <option value="United States" {{ old('nationality') == 'United States' ? 'selected' : '' }}>United States</option>
                                    <option value="United Kingdom" {{ old('nationality') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="Canada" {{ old('nationality') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="Australia" {{ old('nationality') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="Germany" {{ old('nationality') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="France" {{ old('nationality') == 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Italy" {{ old('nationality') == 'Italy' ? 'selected' : '' }}>Italy</option>
                                    <option value="Spain" {{ old('nationality') == 'Spain' ? 'selected' : '' }}>Spain</option>
                                    <option value="Japan" {{ old('nationality') == 'Japan' ? 'selected' : '' }}>Japan</option>
                                    <option value="China" {{ old('nationality') == 'China' ? 'selected' : '' }}>China</option>
                                    <option value="India" {{ old('nationality') == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="Brazil" {{ old('nationality') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                    <option value="South Africa" {{ old('nationality') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                    <option value="Other" {{ old('nationality') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('nationality')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock"></i> Password
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required
                                           placeholder="Enter your password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> Password must be at least 8 characters long
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="bi bi-lock-fill"></i> Confirm Password
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required
                                           placeholder="Confirm your password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="bi bi-eye" id="toggleIconConfirm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">
                                <i class="bi bi-shield-check"></i> Account Type
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Select account type</option>
                                <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>Guest (Customer)</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff Member</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Choose "Guest" for regular hotel bookings
                            </div>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('terms') is-invalid @enderror" 
                                       type="checkbox" 
                                       name="terms" 
                                       id="terms" 
                                       required
                                       {{ old('terms') ? 'checked' : '' }}>
                                <label class="form-check-label" for="terms">
                                    <i class="bi bi-file-text"></i> I agree to the 
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a> 
                                    and 
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="newsletter" 
                                       id="newsletter" 
                                       {{ old('newsletter') ? 'checked' : '' }}>
                                <label class="form-check-label" for="newsletter">
                                    <i class="bi bi-envelope-heart"></i> Subscribe to our newsletter for special offers and updates
                                </label>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="mb-3" id="passwordStrength" style="display: none;">
                            <label class="form-label">Password Strength:</label>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" id="strengthBar"></div>
                            </div>
                            <small class="form-text" id="strengthText"></small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg" id="registerBtn">
                                <i class="bi bi-person-plus"></i>
                                <span id="registerBtnText">Create Account</span>
                                <span id="registerSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                <i class="bi bi-box-arrow-in-right"></i> Sign In
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms of Service Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms of Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>1. Acceptance of Terms</h6>
                <p>By creating an account, you agree to be bound by these Terms of Service.</p>
                
                <h6>2. Account Responsibilities</h6>
                <p>You are responsible for maintaining the confidentiality of your account information.</p>
                
                <h6>3. Booking Policies</h6>
                <p>All bookings are subject to availability and hotel policies.</p>
                
                <h6>4. Cancellation Policy</h6>
                <p>Cancellations must be made at least 24 hours before check-in.</p>
                
                <h6>5. Privacy</h6>
                <p>We respect your privacy and handle your data according to our Privacy Policy.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Information We Collect</h6>
                <p>We collect information you provide when creating an account and making bookings.</p>
                
                <h6>How We Use Your Information</h6>
                <p>Your information is used to provide hotel services and improve our offerings.</p>
                
                <h6>Data Security</h6>
                <p>We implement appropriate security measures to protect your personal information.</p>
                
                <h6>Information Sharing</h6>
                <p>We do not sell or share your personal information with third parties without consent.</p>
                
                <h6>Contact Us</h6>
                <p>If you have questions about this Privacy Policy, please contact us.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    setupPasswordToggle('password', 'togglePassword', 'toggleIcon');
    setupPasswordToggle('password_confirmation', 'togglePasswordConfirm', 'toggleIconConfirm');

    // Password strength checker
    const passwordField = document.getElementById('password');
    const strengthIndicator = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');

    passwordField.addEventListener('input', function() {
        const password = this.value;
        if (password.length > 0) {
            strengthIndicator.style.display = 'block';
            const strength = calculatePasswordStrength(password);
            updateStrengthIndicator(strength);
        } else {
            strengthIndicator.style.display = 'none';
        }
    });

    // Form submission handling
    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');
    const registerBtnText = document.getElementById('registerBtnText');
    const registerSpinner = document.getElementById('registerSpinner');

    registerForm.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return;
        }
        
        registerBtn.disabled = true;
        registerBtnText.textContent = 'Creating Account...';
        registerSpinner.classList.remove('d-none');
    });

    // Real-time password confirmation validation
    const passwordConfirmField = document.getElementById('password_confirmation');
    passwordConfirmField.addEventListener('input', function() {
        const password = passwordField.value;
        const confirmPassword = this.value;
        
        if (confirmPassword.length > 0) {
            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
                this.classList.add('is-invalid');
            } else {
                this.setCustomValidity('');
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        }
    });
});

function setupPasswordToggle(passwordId, toggleId, iconId) {
    const toggleButton = document.getElementById(toggleId);
    const passwordField = document.getElementById(passwordId);
    const toggleIcon = document.getElementById(iconId);

    toggleButton.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        if (type === 'password') {
            toggleIcon.className = 'bi bi-eye';
        } else {
            toggleIcon.className = 'bi bi-eye-slash';
        }
    });
}

function calculatePasswordStrength(password) {
    let strength = 0;
    
    // Length check
    if (password.length >= 8) strength += 1;
    if (password.length >= 12) strength += 1;
    
    // Character variety checks
    if (/[a-z]/.test(password)) strength += 1;
    if (/[A-Z]/.test(password)) strength += 1;
    if (/[0-9]/.test(password)) strength += 1;
    if (/[^A-Za-z0-9]/.test(password)) strength += 1;
    
    return strength;
}

function updateStrengthIndicator(strength) {
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    const percentage = (strength / 6) * 100;
    strengthBar.style.width = percentage + '%';
    
    if (strength < 2) {
        strengthBar.className = 'progress-bar bg-danger';
        strengthText.textContent = 'Weak';
        strengthText.className = 'form-text text-danger';
    } else if (strength < 4) {
        strengthBar.className = 'progress-bar bg-warning';
        strengthText.textContent = 'Fair';
        strengthText.className = 'form-text text-warning';
    } else if (strength < 5) {
        strengthBar.className = 'progress-bar bg-info';
        strengthText.textContent = 'Good';
        strengthText.className = 'form-text text-info';
    } else {
        strengthBar.className = 'progress-bar bg-success';
        strengthText.textContent = 'Strong';
        strengthText.className = 'form-text text-success';
    }
}

function validateForm() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const terms = document.getElementById('terms').checked;
    
    if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return false;
    }
    
    if (password.length < 8) {
        alert('Password must be at least 8 characters long!');
        return false;
    }
    
    if (!terms) {
        alert('You must agree to the Terms of Service!');
        return false;
    }
    
    return true;
}
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: none;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-control.is-valid {
    border-color: #28a745;
}

.btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.btn-outline-secondary {
    border-radius: 0 10px 10px 0;
}

.alert {
    border-radius: 10px;
    border: none;
}

.input-group .form-control {
    border-radius: 10px 0 0 10px;
}

.text-decoration-none:hover {
    text-decoration: underline !important;
}

body {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.container {
    padding-top: 30px;
    padding-bottom: 30px;
}

.shadow-sm {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

/* Animation for form elements */
.form-control, .form-select, .btn {
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
    transition: all 0.3s ease;
}

.modal-content {
    border-radius: 15px;
    border: none;
}

.modal-header {
    border-bottom: 1px solid #e9ecef;
    border-radius: 15px 15px 0 0;
}

.form-text {
    font-size: 0.85rem;
}
</style>
@endpush