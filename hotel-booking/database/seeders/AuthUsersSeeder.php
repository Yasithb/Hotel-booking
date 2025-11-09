<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@hotel.com',
            'phone_number' => '+1-555-0101',
            'nationality' => 'United States',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'newsletter_subscribed' => true,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        // Create demo staff user
        User::create([
            'first_name' => 'Staff',
            'last_name' => 'Member',
            'email' => 'staff@hotel.com',
            'phone_number' => '+1-555-0102',
            'nationality' => 'United States',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'newsletter_subscribed' => true,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        // Create demo guest user
        User::create([
            'first_name' => 'Guest',
            'last_name' => 'User',
            'email' => 'guest@hotel.com',
            'phone_number' => '+1-555-0103',
            'nationality' => 'Canada',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'newsletter_subscribed' => false,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        // Create additional demo users
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '+1-555-0104',
            'nationality' => 'United Kingdom',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'newsletter_subscribed' => true,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'phone_number' => '+1-555-0105',
            'nationality' => 'Australia',
            'password' => Hash::make('password123'),
            'role' => 'guest',
            'newsletter_subscribed' => true,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'first_name' => 'Hotel',
            'last_name' => 'Manager',
            'email' => 'manager@hotel.com',
            'phone_number' => '+1-555-0106',
            'nationality' => 'United States',
            'password' => Hash::make('password123'),
            'role' => 'staff',
            'newsletter_subscribed' => true,
            'active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Demo authentication users created successfully!');
        $this->command->info('Demo Credentials:');
        $this->command->info('Admin: admin@hotel.com / password123');
        $this->command->info('Staff: staff@hotel.com / password123');
        $this->command->info('Guest: guest@hotel.com / password123');
        $this->command->info('Manager: manager@hotel.com / password123');
    }
}
