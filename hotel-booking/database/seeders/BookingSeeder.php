<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all rooms and guests
        $rooms = Room::all();
        $guests = Guest::all();

        if ($rooms->isEmpty() || $guests->isEmpty()) {
            $this->command->warn('No rooms or guests found. Please run RoomSeeder and GuestSeeder first.');
            return;
        }

        $bookings = [
            // Past bookings (completed)
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->subDays(10),
                'check_out_date' => Carbon::now()->subDays(7),
                'number_of_guests' => 2,
                'status' => 'checked_out',
                'special_requests' => 'Late check-out requested',
                'booking_date' => Carbon::now()->subDays(15)
            ],
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->subDays(20),
                'check_out_date' => Carbon::now()->subDays(17),
                'number_of_guests' => 1,
                'status' => 'checked_out',
                'special_requests' => null,
                'booking_date' => Carbon::now()->subDays(25)
            ],

            // Current bookings (checked in)
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->subDays(2),
                'check_out_date' => Carbon::now()->addDays(1),
                'number_of_guests' => 2,
                'status' => 'checked_in',
                'special_requests' => 'Extra towels',
                'booking_date' => Carbon::now()->subDays(7)
            ],
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->subDay(),
                'check_out_date' => Carbon::now()->addDays(3),
                'number_of_guests' => 1,
                'status' => 'checked_in',
                'special_requests' => 'Quiet room please',
                'booking_date' => Carbon::now()->subDays(10)
            ],

            // Today's check-ins
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now(),
                'check_out_date' => Carbon::now()->addDays(2),
                'number_of_guests' => 2,
                'status' => 'confirmed',
                'special_requests' => 'Airport pickup required',
                'booking_date' => Carbon::now()->subDays(5)
            ],

            // Today's check-outs
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->subDays(3),
                'check_out_date' => Carbon::now(),
                'number_of_guests' => 2,
                'status' => 'checked_in',
                'special_requests' => null,
                'booking_date' => Carbon::now()->subDays(8)
            ],

            // Future bookings (confirmed)
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->addDays(5),
                'check_out_date' => Carbon::now()->addDays(8),
                'number_of_guests' => 4,
                'status' => 'confirmed',
                'special_requests' => 'Connecting rooms if possible',
                'booking_date' => Carbon::now()->subDays(3)
            ],
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->addDays(7),
                'check_out_date' => Carbon::now()->addDays(10),
                'number_of_guests' => 1,
                'status' => 'confirmed',
                'special_requests' => 'Business traveler, need workspace',
                'booking_date' => Carbon::now()->subDay()
            ],

            // Pending bookings
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->addDays(12),
                'check_out_date' => Carbon::now()->addDays(15),
                'number_of_guests' => 3,
                'status' => 'pending',
                'special_requests' => 'Anniversary celebration',
                'booking_date' => Carbon::now()
            ],
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->addDays(14),
                'check_out_date' => Carbon::now()->addDays(16),
                'number_of_guests' => 2,
                'status' => 'pending',
                'special_requests' => null,
                'booking_date' => Carbon::now()
            ],

            // Cancelled booking
            [
                'guest_id' => $guests->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->addDays(20),
                'check_out_date' => Carbon::now()->addDays(22),
                'number_of_guests' => 2,
                'status' => 'cancelled',
                'special_requests' => 'Cancelled due to travel restrictions',
                'booking_date' => Carbon::now()->subDays(2)
            ]
        ];

        foreach ($bookings as $bookingData) {
            // Calculate total amount
            $room = Room::find($bookingData['room_id']);
            $checkIn = Carbon::parse($bookingData['check_in_date']);
            $checkOut = Carbon::parse($bookingData['check_out_date']);
            $nights = $checkOut->diffInDays($checkIn);
            
            $bookingData['total_amount'] = $room->price_per_night * $nights;
            
            // Ensure we don't create conflicting bookings for the same room
            $existingBooking = Booking::where('room_id', $bookingData['room_id'])
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($bookingData) {
                    $query->whereBetween('check_in_date', [$bookingData['check_in_date'], $bookingData['check_out_date']])
                          ->orWhereBetween('check_out_date', [$bookingData['check_in_date'], $bookingData['check_out_date']])
                          ->orWhere(function ($query) use ($bookingData) {
                              $query->where('check_in_date', '<=', $bookingData['check_in_date'])
                                    ->where('check_out_date', '>=', $bookingData['check_out_date']);
                          });
                })
                ->exists();

            if (!$existingBooking) {
                Booking::create($bookingData);
            } else {
                // Try with a different room
                $availableRoom = $rooms->where('id', '!=', $bookingData['room_id'])->first();
                if ($availableRoom) {
                    $bookingData['room_id'] = $availableRoom->id;
                    $bookingData['total_amount'] = $availableRoom->price_per_night * $nights;
                    
                    // Check again for conflicts
                    $conflictCheck = Booking::where('room_id', $availableRoom->id)
                        ->where('status', '!=', 'cancelled')
                        ->where(function ($query) use ($bookingData) {
                            $query->whereBetween('check_in_date', [$bookingData['check_in_date'], $bookingData['check_out_date']])
                                  ->orWhereBetween('check_out_date', [$bookingData['check_in_date'], $bookingData['check_out_date']])
                                  ->orWhere(function ($query) use ($bookingData) {
                                      $query->where('check_in_date', '<=', $bookingData['check_in_date'])
                                            ->where('check_out_date', '>=', $bookingData['check_out_date']);
                                  });
                        })
                        ->exists();
                    
                    if (!$conflictCheck) {
                        Booking::create($bookingData);
                    }
                }
            }
        }
    }
}
