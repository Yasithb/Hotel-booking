@extends('layouts.app')

@section('title', 'Forgot Password - Hotel Booking System')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-key"></i>
                        Forgot Password
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-lock-fill text-warning" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">
                            Enter your email address and we'll send you a link to reset your password.
                        </p>
                    </div>

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

                    <!-- Display status messages -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="#" id="forgotPasswordForm">
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

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg" id="resetBtn">
                                <i class="bi bi-envelope"></i>
                                <span id="resetBtnText">Send Reset Link</span>
                                <span id="resetSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">
                            Remember your password?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                <i class="bi bi-box-arrow-in-right"></i> Back to Login
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Help Information -->
            <div class="card mt-3 border-info">
                <div class="card-header bg-info text-white text-center">
                    <small><i class="bi bi-info-circle"></i> Need Help?</small>
                </div>
                <div class="card-body py-3">
                    <div class="text-center">
                        <small class="text-muted">
                            If you don't receive the reset email within a few minutes, please check your spam folder or contact support.
                        </small>
                        <div class="mt-2">
                            <a href="mailto:support@hotel.com" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-envelope"></i> Contact Support
                            </a>
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
document.addEventListener('DOMContentLoaded', function() {
    // Form submission handling
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const resetBtn = document.getElementById('resetBtn');
    const resetBtnText = document.getElementById('resetBtnText');
    const resetSpinner = document.getElementById('resetSpinner');

    forgotPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        resetBtn.disabled = true;
        resetBtnText.textContent = 'Sending...';
        resetSpinner.classList.remove('d-none');
        
        // Simulate sending reset link
        setTimeout(() => {
            resetBtn.disabled = false;
            resetBtnText.textContent = 'Send Reset Link';
            resetSpinner.classList.add('d-none');
            
            // Show success message
            showToast('Password reset feature is not implemented yet. Please contact support.', 'info');
        }, 2000);
    });

    // Auto-focus email field
    const emailField = document.getElementById('email');
    emailField.focus();
});
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
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    border: none;
    color: #000;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #e0a800 0%, #e67e00 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    color: #000;
}

.alert {
    border-radius: 10px;
    border: none;
}

.text-decoration-none:hover {
    text-decoration: underline !important;
}

body {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
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
</style>
@endpush