<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/demo-login', [LoginController::class, 'demoLogin'])->name('demo.login');
    
    // Registration routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/quick-register', [RegisterController::class, 'quickRegister'])->name('quick.register');
    Route::post('/check-email', [RegisterController::class, 'checkEmail'])->name('check.email');
});

// Logout route (requires authentication)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Password reset routes (future implementation)
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request')->middleware('guest');

// Redirect root to login if not authenticated, dashboard if authenticated
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Room management routes
    Route::prefix('rooms')->name('rooms.')->group(function () {
        Route::get('/', function () {
            return view('rooms.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('rooms.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('rooms.show', ['roomId' => $id]);
        })->name('show');
        
        Route::get('/{id}/edit', function ($id) {
            return view('rooms.edit', ['roomId' => $id]);
        })->name('edit');
    });

    // Guest management routes
    Route::prefix('guests')->name('guests.')->group(function () {
        Route::get('/', function () {
            return view('guests.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('guests.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('guests.show', ['guestId' => $id]);
        })->name('show');
        
        Route::get('/{id}/edit', function ($id) {
            return view('guests.edit', ['guestId' => $id]);
        })->name('edit');
    });

    // Booking management routes
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', function () {
            return view('bookings.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('bookings.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('bookings.show', ['bookingId' => $id]);
        })->name('show');
        
        Route::get('/{id}/edit', function ($id) {
            return view('bookings.edit', ['bookingId' => $id]);
        })->name('edit');
    });

    // Admin routes (require staff/admin role)
    Route::middleware('role:staff,admin')->group(function () {
        Route::get('/settings', function () {
            return view('settings');
        })->name('settings');
    });
});
