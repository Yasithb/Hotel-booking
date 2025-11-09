<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            // Single rooms
            [
                'room_number' => '101',
                'room_type' => 'single',
                'price_per_night' => 80.00,
                'description' => 'Comfortable single room with city view',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar'],
                'max_occupancy' => 1,
                'is_available' => true
            ],
            [
                'room_number' => '102',
                'room_type' => 'single',
                'price_per_night' => 85.00,
                'description' => 'Single room with balcony',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Balcony'],
                'max_occupancy' => 1,
                'is_available' => true
            ],
            [
                'room_number' => '103',
                'room_type' => 'single',
                'price_per_night' => 80.00,
                'description' => 'Standard single room',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning'],
                'max_occupancy' => 1,
                'is_available' => true
            ],

            // Double rooms
            [
                'room_number' => '201',
                'room_type' => 'double',
                'price_per_night' => 120.00,
                'description' => 'Spacious double room with queen bed',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar', 'Safe'],
                'max_occupancy' => 2,
                'is_available' => true
            ],
            [
                'room_number' => '202',
                'room_type' => 'double',
                'price_per_night' => 130.00,
                'description' => 'Double room with sea view',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar', 'Sea View'],
                'max_occupancy' => 2,
                'is_available' => true
            ],
            [
                'room_number' => '203',
                'room_type' => 'double',
                'price_per_night' => 125.00,
                'description' => 'Double room with twin beds',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar'],
                'max_occupancy' => 2,
                'is_available' => true
            ],
            [
                'room_number' => '204',
                'room_type' => 'double',
                'price_per_night' => 120.00,
                'description' => 'Standard double room',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning'],
                'max_occupancy' => 2,
                'is_available' => true
            ],

            // Suite rooms
            [
                'room_number' => '301',
                'room_type' => 'suite',
                'price_per_night' => 250.00,
                'description' => 'Luxury suite with separate living area',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar', 'Safe', 'Kitchenette', 'Living Area'],
                'max_occupancy' => 4,
                'is_available' => true
            ],
            [
                'room_number' => '302',
                'room_type' => 'suite',
                'price_per_night' => 280.00,
                'description' => 'Executive suite with city view',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar', 'Safe', 'Kitchenette', 'City View', 'Work Desk'],
                'max_occupancy' => 4,
                'is_available' => true
            ],

            // Deluxe rooms
            [
                'room_number' => '401',
                'room_type' => 'deluxe',
                'price_per_night' => 180.00,
                'description' => 'Deluxe room with premium amenities',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar', 'Safe', 'Bathtub', 'Premium Toiletries'],
                'max_occupancy' => 3,
                'is_available' => true
            ],
            [
                'room_number' => '402',
                'room_type' => 'deluxe',
                'price_per_night' => 190.00,
                'description' => 'Deluxe room with garden view',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar', 'Safe', 'Garden View', 'Premium Toiletries'],
                'max_occupancy' => 3,
                'is_available' => true
            ],

            // Presidential suite
            [
                'room_number' => '501',
                'room_type' => 'presidential',
                'price_per_night' => 500.00,
                'description' => 'Presidential suite with panoramic views and luxury amenities',
                'amenities' => ['WiFi', 'TV', 'Air Conditioning', 'Mini Bar', 'Safe', 'Kitchenette', 'Living Area', 'Dining Area', 'Panoramic View', 'Jacuzzi', 'Butler Service'],
                'max_occupancy' => 6,
                'is_available' => true
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
