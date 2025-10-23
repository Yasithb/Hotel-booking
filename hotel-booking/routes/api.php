<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Room routes
Route::apiResource('rooms', RoomController::class);
Route::get('rooms/{room}/availability', [RoomController::class, 'checkAvailability']);
Route::get('available-rooms', [RoomController::class, 'availableRooms']);

// Guest routes
Route::apiResource('guests', GuestController::class);
Route::get('guests/{guest}/bookings', [GuestController::class, 'bookingHistory']);
Route::get('guests/{guest}/current-bookings', [GuestController::class, 'currentBookings']);
Route::get('search/guests', [GuestController::class, 'search']);

// Booking routes
Route::apiResource('bookings', BookingController::class);
Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel']);
Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm']);
Route::post('bookings/{booking}/check-in', [BookingController::class, 'checkIn']);
Route::post('bookings/{booking}/check-out', [BookingController::class, 'checkOut']);
Route::get('today/check-ins', [BookingController::class, 'todayCheckIns']);
Route::get('today/check-outs', [BookingController::class, 'todayCheckOuts']);
Route::get('bookings-statistics', [BookingController::class, 'statistics']);

// Dashboard / Summary routes
Route::get('dashboard', function () {
    return response()->json([
        'total_rooms' => \App\Models\Room::count(),
        'available_rooms' => \App\Models\Room::where('is_available', true)->count(),
        'total_guests' => \App\Models\Guest::count(),
        'active_bookings' => \App\Models\Booking::active()->count(),
        'todays_checkins' => \App\Models\Booking::where('check_in_date', now()->toDateString())
                                                ->whereIn('status', ['confirmed', 'checked_in'])
                                                ->count(),
        'todays_checkouts' => \App\Models\Booking::where('check_out_date', now()->toDateString())
                                                 ->where('status', 'checked_in')
                                                 ->count(),
        'pending_bookings' => \App\Models\Booking::where('status', 'pending')->count(),
    ]);
});