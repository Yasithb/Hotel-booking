<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Guest::query();

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by nationality
        if ($request->has('nationality')) {
            $query->where('nationality', $request->nationality);
        }

        $guests = $query->withCount(['bookings'])
                       ->paginate($request->get('per_page', 15));

        return response()->json($guests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:guests',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'nationality' => 'nullable|string|max:100',
            'id_number' => 'nullable|string|max:50'
        ]);

        $guest = Guest::create($validated);

        return response()->json([
            'message' => 'Guest created successfully',
            'guest' => $guest
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guest $guest): JsonResponse
    {
        $guest->load(['bookings' => function ($query) {
            $query->with('room')
                  ->orderBy('booking_date', 'desc');
        }]);

        // Add some computed attributes
        $guest->total_bookings = $guest->bookings->count();
        $guest->current_bookings = $guest->currentBookings()->with('room')->get();
        $guest->booking_history = $guest->bookingHistory()->with('room')->limit(10)->get();

        return response()->json($guest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guest $guest): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:guests,email,' . $guest->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'nationality' => 'nullable|string|max:100',
            'id_number' => 'nullable|string|max:50'
        ]);

        $guest->update($validated);

        return response()->json([
            'message' => 'Guest updated successfully',
            'guest' => $guest
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guest $guest): JsonResponse
    {
        // Check if guest has active bookings
        $activeBookings = $guest->bookings()
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->count();

        if ($activeBookings > 0) {
            return response()->json([
                'message' => 'Cannot delete guest with active bookings'
            ], 422);
        }

        $guest->delete();

        return response()->json([
            'message' => 'Guest deleted successfully'
        ]);
    }

    /**
     * Get guest's booking history
     */
    public function bookingHistory(Guest $guest): JsonResponse
    {
        $bookings = $guest->bookings()
            ->with(['room'])
            ->orderBy('booking_date', 'desc')
            ->paginate(10);

        return response()->json($bookings);
    }

    /**
     * Get guest's current bookings
     */
    public function currentBookings(Guest $guest): JsonResponse
    {
        $bookings = $guest->currentBookings()
            ->with(['room'])
            ->get();

        return response()->json($bookings);
    }

    /**
     * Search guests by various criteria
     */
    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'term' => 'required|string|min:2'
        ]);

        $term = $validated['term'];

        $guests = Guest::where('first_name', 'like', "%{$term}%")
            ->orWhere('last_name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->orWhere('phone', 'like', "%{$term}%")
            ->orWhere('id_number', 'like', "%{$term}%")
            ->limit(10)
            ->get();

        return response()->json($guests);
    }
}
