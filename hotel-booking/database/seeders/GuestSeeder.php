<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guest;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guests = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'email' => 'john.smith@email.com',
                'phone' => '+1-555-0101',
                'address' => '123 Main St, New York, NY 10001',
                'date_of_birth' => '1985-06-15',
                'gender' => 'male',
                'nationality' => 'American',
                'id_number' => 'P123456789'
            ],
            [
                'first_name' => 'Emma',
                'last_name' => 'Johnson',
                'email' => 'emma.johnson@email.com',
                'phone' => '+1-555-0102',
                'address' => '456 Oak Ave, Los Angeles, CA 90210',
                'date_of_birth' => '1990-03-22',
                'gender' => 'female',
                'nationality' => 'American',
                'id_number' => 'P987654321'
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'email' => 'michael.brown@email.com',
                'phone' => '+1-555-0103',
                'address' => '789 Pine St, Chicago, IL 60601',
                'date_of_birth' => '1988-11-08',
                'gender' => 'male',
                'nationality' => 'American',
                'id_number' => 'P456789123'
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Davis',
                'email' => 'sarah.davis@email.com',
                'phone' => '+1-555-0104',
                'address' => '321 Elm St, Houston, TX 77001',
                'date_of_birth' => '1992-07-14',
                'gender' => 'female',
                'nationality' => 'American',
                'id_number' => 'P789123456'
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Wilson',
                'email' => 'david.wilson@email.com',
                'phone' => '+44-20-7946-0958',
                'address' => '10 Downing Street, London, UK',
                'date_of_birth' => '1983-12-03',
                'gender' => 'male',
                'nationality' => 'British',
                'id_number' => 'GB123456789'
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Garcia',
                'email' => 'maria.garcia@email.com',
                'phone' => '+34-91-123-4567',
                'address' => 'Calle Mayor 1, Madrid, Spain',
                'date_of_birth' => '1987-04-25',
                'gender' => 'female',
                'nationality' => 'Spanish',
                'id_number' => 'ES987654321'
            ],
            [
                'first_name' => 'Pierre',
                'last_name' => 'Dubois',
                'email' => 'pierre.dubois@email.com',
                'phone' => '+33-1-42-86-87-88',
                'address' => '1 Rue de Rivoli, Paris, France',
                'date_of_birth' => '1991-09-17',
                'gender' => 'male',
                'nationality' => 'French',
                'id_number' => 'FR456789123'
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'Mueller',
                'email' => 'anna.mueller@email.com',
                'phone' => '+49-30-12345678',
                'address' => 'Unter den Linden 1, Berlin, Germany',
                'date_of_birth' => '1989-01-30',
                'gender' => 'female',
                'nationality' => 'German',
                'id_number' => 'DE123789456'
            ],
            [
                'first_name' => 'Hiroshi',
                'last_name' => 'Tanaka',
                'email' => 'hiroshi.tanaka@email.com',
                'phone' => '+81-3-1234-5678',
                'address' => '1-1-1 Chiyoda, Tokyo, Japan',
                'date_of_birth' => '1986-08-12',
                'gender' => 'male',
                'nationality' => 'Japanese',
                'id_number' => 'JP789456123'
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Anderson',
                'email' => 'lisa.anderson@email.com',
                'phone' => '+61-2-9876-5432',
                'address' => '1 Harbour Bridge Rd, Sydney, Australia',
                'date_of_birth' => '1993-05-07',
                'gender' => 'female',
                'nationality' => 'Australian',
                'id_number' => 'AU654321987'
            ]
        ];

        foreach ($guests as $guest) {
            Guest::create($guest);
        }
    }
}
