<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Room::query();

        // Filter by room type
        if ($request->has('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        // Filter by availability
        if ($request->has('is_available')) {
            $query->where('is_available', $request->boolean('is_available'));
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        // Check availability for specific dates
        if ($request->has('check_in') && $request->has('check_out')) {
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;
            
            $query->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
                $q->where('status', '!=', 'cancelled')
                  ->where(function ($query) use ($checkIn, $checkOut) {
                      $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                            ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                            ->orWhere(function ($query) use ($checkIn, $checkOut) {
                                $query->where('check_in_date', '<=', $checkIn)
                                      ->where('check_out_date', '>=', $checkOut);
                            });
                  });
            });
        }

        $rooms = $query->paginate($request->get('per_page', 15));

        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms',
            'room_type' => ['required', Rule::in(['single', 'double', 'suite', 'deluxe', 'presidential'])],
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'max_occupancy' => 'required|integer|min:1',
            'is_available' => 'boolean'
        ]);

        $room = Room::create($validated);

        return response()->json([
            'message' => 'Room created successfully',
            'room' => $room
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room): JsonResponse
    {
        $room->load(['bookings' => function ($query) {
            $query->with('guest')
                  ->whereIn('status', ['confirmed', 'checked_in'])
                  ->orderBy('check_in_date');
        }]);

        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room): JsonResponse
    {
        $validated = $request->validate([
            'room_number' => 'sometimes|string|unique:rooms,room_number,' . $room->id,
            'room_type' => ['sometimes', Rule::in(['single', 'double', 'suite', 'deluxe', 'presidential'])],
            'price_per_night' => 'sometimes|numeric|min:0',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'max_occupancy' => 'sometimes|integer|min:1',
            'is_available' => 'boolean'
        ]);

        $room->update($validated);

        return response()->json([
            'message' => 'Room updated successfully',
            'room' => $room
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room): JsonResponse
    {
        // Check if room has active bookings
        $activeBookings = $room->bookings()
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->count();

        if ($activeBookings > 0) {
            return response()->json([
                'message' => 'Cannot delete room with active bookings'
            ], 422);
        }

        $room->delete();

        return response()->json([
            'message' => 'Room deleted successfully'
        ]);
    }

    /**
     * Check room availability for specific dates
     */
    public function checkAvailability(Request $request, Room $room): JsonResponse
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date'
        ]);

        $isAvailable = $room->isAvailableForDates(
            $validated['check_in_date'],
            $validated['check_out_date']
        );

        return response()->json([
            'room_id' => $room->id,
            'room_number' => $room->room_number,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'is_available' => $isAvailable
        ]);
    }

    /**
     * Get available rooms for specific dates
     */
    public function availableRooms(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'room_type' => ['nullable', Rule::in(['single', 'double', 'suite', 'deluxe', 'presidential'])],
            'max_occupancy' => 'nullable|integer|min:1'
        ]);

        $query = Room::where('is_available', true);

        if (isset($validated['room_type'])) {
            $query->where('room_type', $validated['room_type']);
        }

        if (isset($validated['max_occupancy'])) {
            $query->where('max_occupancy', '>=', $validated['max_occupancy']);
        }

        $availableRooms = $query->whereDoesntHave('bookings', function ($q) use ($validated) {
            $q->where('status', '!=', 'cancelled')
              ->where(function ($query) use ($validated) {
                  $query->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                        ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']])
                        ->orWhere(function ($query) use ($validated) {
                            $query->where('check_in_date', '<=', $validated['check_in_date'])
                                  ->where('check_out_date', '>=', $validated['check_out_date']);
                        });
              });
        })->get();

        return response()->json([
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'available_rooms' => $availableRooms
        ]);
    }
}
