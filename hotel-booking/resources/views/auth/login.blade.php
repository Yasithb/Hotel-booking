@extends('layouts.app')

@section('title', 'Login - Hotel Booking System')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Login to Your Account
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

                    <!-- Display success messages -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display status messages -->
                    @if (session('status'))
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        
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
                                   autofocus
                                   placeholder="Enter your email address">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
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
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="remember" 
                                           id="remember" 
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        <i class="bi bi-bookmark"></i> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    <i class="bi bi-question-circle"></i> Forgot Password?
                                </a>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="loginBtn">
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span id="loginBtnText">Sign In</span>
                                <span id="loginSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">
                            Don't have an account yet?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                <i class="bi bi-person-plus"></i> Create Account
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Demo Credentials -->
            <div class="card mt-3 border-info">
                <div class="card-header bg-info text-white text-center">
                    <small><i class="bi bi-info-circle"></i> Demo Credentials</small>
                </div>
                <div class="card-body py-2">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Admin:</strong><br>
                                admin@hotel.com<br>
                                password123
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Staff:</strong><br>
                                staff@hotel.com<br>
                                password123
                            </small>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="fillDemoCredentials('admin')">
                            Use Admin Demo
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="fillDemoCredentials('staff')">
                            Use Staff Demo
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
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        if (type === 'password') {
            toggleIcon.className = 'bi bi-eye';
        } else {
            toggleIcon.className = 'bi bi-eye-slash';
        }
    });

    // Form submission handling
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const loginBtnText = document.getElementById('loginBtnText');
    const loginSpinner = document.getElementById('loginSpinner');

    loginForm.addEventListener('submit', function() {
        loginBtn.disabled = true;
        loginBtnText.textContent = 'Signing In...';
        loginSpinner.classList.remove('d-none');
    });

    // Auto-focus email field if empty
    const emailField = document.getElementById('email');
    if (!emailField.value) {
        emailField.focus();
    }
});

function fillDemoCredentials(type) {
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    
    if (type === 'admin') {
        emailField.value = 'admin@hotel.com';
        passwordField.value = 'password123';
    } else if (type === 'staff') {
        emailField.value = 'staff@hotel.com';
        passwordField.value = 'password123';
    }
    
    // Focus password field
    passwordField.focus();
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

.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.container {
    padding-top: 50px;
    padding-bottom: 50px;
}

.shadow-sm {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

/* Animation for form elements */
.form-control, .btn {
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

/* Demo credentials card styling */
.border-info {
    border-color: #0dcaf0 !important;
}

.bg-info {
    background-color: #0dcaf0 !important;
}
</style>
@endpush