<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Booking::with(['guest', 'room']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by room
        if ($request->has('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        // Filter by guest
        if ($request->has('guest_id')) {
            $query->where('guest_id', $request->guest_id);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->where('check_in_date', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->where('check_out_date', '<=', $request->end_date);
        }

        // Filter by booking date
        if ($request->has('booking_date')) {
            $query->whereDate('booking_date', $request->booking_date);
        }

        $bookings = $query->orderBy('booking_date', 'desc')
                         ->paginate($request->get('per_page', 15));

        return response()->json($bookings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string'
        ]);

        // Check if room is available for the requested dates
        $room = Room::findOrFail($validated['room_id']);
        
        if (!$room->isAvailableForDates($validated['check_in_date'], $validated['check_out_date'])) {
            return response()->json([
                'message' => 'Room is not available for the selected dates'
            ], 422);
        }

        // Check if number of guests exceeds room capacity
        if ($validated['number_of_guests'] > $room->max_occupancy) {
            return response()->json([
                'message' => 'Number of guests exceeds room capacity'
            ], 422);
        }

        // Calculate total amount
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkOut->diffInDays($checkIn);
        $totalAmount = $room->price_per_night * $nights;

        $booking = Booking::create([
            ...$validated,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'booking_date' => now()
        ]);

        $booking->load(['guest', 'room']);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): JsonResponse
    {
        $booking->load(['guest', 'room']);
        
        // Add computed attributes
        $booking->number_of_nights = $booking->number_of_nights;
        $booking->is_active = $booking->isActive();
        $booking->can_be_cancelled = $booking->canBeCancelled();

        return response()->json($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking): JsonResponse
    {
        $validated = $request->validate([
            'check_in_date' => 'sometimes|date|after_or_equal:today',
            'check_out_date' => 'sometimes|date|after:check_in_date',
            'number_of_guests' => 'sometimes|integer|min:1',
            'special_requests' => 'nullable|string',
            'status' => ['sometimes', Rule::in(['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'])]
        ]);

        // If dates are being updated, check availability
        if (isset($validated['check_in_date']) || isset($validated['check_out_date'])) {
            $checkIn = $validated['check_in_date'] ?? $booking->check_in_date;
            $checkOut = $validated['check_out_date'] ?? $booking->check_out_date;
            
            // Check if room is available for the new dates (excluding current booking)
            $conflictingBookings = Booking::where('room_id', $booking->room_id)
                ->where('id', '!=', $booking->id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($checkIn, $checkOut) {
                    $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                          ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                          ->orWhere(function ($query) use ($checkIn, $checkOut) {
                              $query->where('check_in_date', '<=', $checkIn)
                                    ->where('check_out_date', '>=', $checkOut);
                          });
                })
                ->exists();

            if ($conflictingBookings) {
                return response()->json([
                    'message' => 'Room is not available for the selected dates'
                ], 422);
            }

            // Recalculate total amount if dates changed
            $checkInDate = Carbon::parse($checkIn);
            $checkOutDate = Carbon::parse($checkOut);
            $nights = $checkOutDate->diffInDays($checkInDate);
            $validated['total_amount'] = $booking->room->price_per_night * $nights;
        }

        // Check if number of guests exceeds room capacity
        if (isset($validated['number_of_guests']) && $validated['number_of_guests'] > $booking->room->max_occupancy) {
            return response()->json([
                'message' => 'Number of guests exceeds room capacity'
            ], 422);
        }

        $booking->update($validated);
        $booking->load(['guest', 'room']);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        // Only allow deletion of pending or cancelled bookings
        if (!in_array($booking->status, ['pending', 'cancelled'])) {
            return response()->json([
                'message' => 'Only pending or cancelled bookings can be deleted'
            ], 422);
        }

        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully'
        ]);
    }

    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking): JsonResponse
    {
        if (!$booking->canBeCancelled()) {
            return response()->json([
                'message' => 'Booking cannot be cancelled'
            ], 422);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'booking' => $booking
        ]);
    }

    /**
     * Confirm a booking
     */
    public function confirm(Booking $booking): JsonResponse
    {
        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending bookings can be confirmed'
            ], 422);
        }

        $booking->update(['status' => 'confirmed']);

        return response()->json([
            'message' => 'Booking confirmed successfully',
            'booking' => $booking
        ]);
    }

    /**
     * Check in a guest
     */
    public function checkIn(Booking $booking): JsonResponse
    {
        if ($booking->status !== 'confirmed') {
            return response()->json([
                'message' => 'Only confirmed bookings can be checked in'
            ], 422);
        }

        if ($booking->check_in_date > Carbon::now()->toDateString()) {
            return response()->json([
                'message' => 'Cannot check in before the check-in date'
            ], 422);
        }

        $booking->update(['status' => 'checked_in']);

        return response()->json([
            'message' => 'Guest checked in successfully',
            'booking' => $booking
        ]);
    }

    /**
     * Check out a guest
     */
    public function checkOut(Booking $booking): JsonResponse
    {
        if ($booking->status !== 'checked_in') {
            return response()->json([
                'message' => 'Only checked-in bookings can be checked out'
            ], 422);
        }

        $booking->update(['status' => 'checked_out']);

        return response()->json([
            'message' => 'Guest checked out successfully',
            'booking' => $booking
        ]);
    }

    /**
     * Get today's check-ins
     */
    public function todayCheckIns(): JsonResponse
    {
        $today = Carbon::now()->toDateString();
        
        $checkIns = Booking::with(['guest', 'room'])
            ->where('check_in_date', $today)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->orderBy('guest_id')
            ->get();

        return response()->json($checkIns);
    }

    /**
     * Get today's check-outs
     */
    public function todayCheckOuts(): JsonResponse
    {
        $today = Carbon::now()->toDateString();
        
        $checkOuts = Booking::with(['guest', 'room'])
            ->where('check_out_date', $today)
            ->where('status', 'checked_in')
            ->orderBy('guest_id')
            ->get();

        return response()->json($checkOuts);
    }

    /**
     * Get booking statistics
     */
    public function statistics(): JsonResponse
    {
        $today = Carbon::now()->toDateString();
        
        $stats = [
            'total_bookings' => Booking::count(),
            'active_bookings' => Booking::active()->count(),
            'upcoming_bookings' => Booking::upcoming()->count(),
            'todays_checkins' => Booking::where('check_in_date', $today)
                                       ->whereIn('status', ['confirmed', 'checked_in'])
                                       ->count(),
            'todays_checkouts' => Booking::where('check_out_date', $today)
                                        ->where('status', 'checked_in')
                                        ->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'total_revenue' => Booking::whereIn('status', ['confirmed', 'checked_in', 'checked_out'])
                                     ->sum('total_amount')
        ];

        return response()->json($stats);
    }
}
