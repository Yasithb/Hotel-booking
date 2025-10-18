# Hotel Room Booking System API Documentation

This is a comprehensive backend API for a Hotel Room Booking System built with Laravel 12. The system manages rooms, guests, and bookings for a small hotel.

## Features

- **Room Management**: Add, update, delete, and view rooms with different types and amenities
- **Guest Management**: Register and manage guest information
- **Booking System**: Create, manage, and track bookings with availability checking
- **Real-time Availability**: Check room availability for specific dates
- **Booking Status Management**: Handle check-ins, check-outs, confirmations, and cancellations
- **Dashboard Statistics**: Get overview of hotel operations

## Models

### Room
- Unique room number and type (single, double, suite, deluxe, presidential)
- Price per night and maximum occupancy
- Amenities stored as JSON array
- Availability status

### Guest
- Personal information (name, email, phone, address)
- Identity details (date of birth, nationality, ID number)
- Booking history tracking

### Booking
- Links guests to rooms with specific dates
- Status tracking (pending, confirmed, checked_in, checked_out, cancelled)
- Total amount calculation
- Special requests handling

## API Endpoints

### Rooms

#### GET /api/rooms
Get list of all rooms with optional filtering
- **Query Parameters:**
  - `room_type`: Filter by room type
  - `is_available`: Filter by availability (true/false)
  - `min_price`, `max_price`: Price range filtering
  - `check_in`, `check_out`: Check availability for specific dates
  - `per_page`: Number of results per page (default: 15)

#### POST /api/rooms
Create a new room
- **Required Fields:**
  - `room_number`: Unique room identifier
  - `room_type`: single|double|suite|deluxe|presidential
  - `price_per_night`: Numeric price
  - `max_occupancy`: Integer minimum 1
- **Optional Fields:**
  - `description`: Text description
  - `amenities`: Array of amenities
  - `is_available`: Boolean (default: true)

#### GET /api/rooms/{id}
Get specific room details with current bookings

#### PUT /api/rooms/{id}
Update room information

#### DELETE /api/rooms/{id}
Delete room (only if no active bookings)

#### GET /api/rooms/{id}/availability
Check if specific room is available for given dates
- **Required Parameters:**
  - `check_in_date`: Date (YYYY-MM-DD)
  - `check_out_date`: Date (YYYY-MM-DD)

#### GET /api/available-rooms
Get all available rooms for specific dates
- **Required Parameters:**
  - `check_in_date`: Date (YYYY-MM-DD)
  - `check_out_date`: Date (YYYY-MM-DD)
- **Optional Parameters:**
  - `room_type`: Filter by room type
  - `max_occupancy`: Minimum occupancy requirement

### Guests

#### GET /api/guests
Get list of all guests with optional search
- **Query Parameters:**
  - `search`: Search by name or email
  - `nationality`: Filter by nationality
  - `per_page`: Number of results per page (default: 15)

#### POST /api/guests
Create a new guest
- **Required Fields:**
  - `first_name`: Guest's first name
  - `last_name`: Guest's last name
  - `email`: Unique email address
- **Optional Fields:**
  - `phone`: Phone number
  - `address`: Physical address
  - `date_of_birth`: Date (YYYY-MM-DD)
  - `gender`: male|female|other
  - `nationality`: Country
  - `id_number`: Passport/ID number

#### GET /api/guests/{id}
Get specific guest details with booking history

#### PUT /api/guests/{id}
Update guest information

#### DELETE /api/guests/{id}
Delete guest (only if no active bookings)

#### GET /api/guests/{id}/bookings
Get guest's booking history (paginated)

#### GET /api/guests/{id}/current-bookings
Get guest's current active bookings

#### GET /api/search/guests
Search guests by various criteria
- **Required Parameters:**
  - `term`: Search term (minimum 2 characters)

### Bookings

#### GET /api/bookings
Get list of all bookings with optional filtering
- **Query Parameters:**
  - `status`: Filter by booking status
  - `room_id`: Filter by room
  - `guest_id`: Filter by guest
  - `start_date`, `end_date`: Date range filtering
  - `booking_date`: Filter by booking creation date
  - `per_page`: Number of results per page (default: 15)

#### POST /api/bookings
Create a new booking
- **Required Fields:**
  - `guest_id`: Valid guest ID
  - `room_id`: Valid room ID
  - `check_in_date`: Date (YYYY-MM-DD, today or later)
  - `check_out_date`: Date (YYYY-MM-DD, after check-in)
  - `number_of_guests`: Integer minimum 1
- **Optional Fields:**
  - `special_requests`: Text description

#### GET /api/bookings/{id}
Get specific booking details

#### PUT /api/bookings/{id}
Update booking information
- Can modify dates, number of guests, and special requests
- Automatically recalculates total amount
- Validates room availability for new dates

#### DELETE /api/bookings/{id}
Delete booking (only pending or cancelled bookings)

#### POST /api/bookings/{id}/cancel
Cancel a booking (if eligible)

#### POST /api/bookings/{id}/confirm
Confirm a pending booking

#### POST /api/bookings/{id}/check-in
Check in a confirmed booking

#### POST /api/bookings/{id}/check-out
Check out a checked-in booking

#### GET /api/today/check-ins
Get today's scheduled check-ins

#### GET /api/today/check-outs
Get today's scheduled check-outs

#### GET /api/bookings-statistics
Get booking statistics and metrics

### Dashboard

#### GET /api/dashboard
Get hotel overview statistics
- Total rooms and available rooms
- Total guests and active bookings
- Today's check-ins and check-outs
- Pending bookings count

## Database Schema

### Rooms Table
- `id`: Primary key
- `room_number`: Unique string
- `room_type`: Enum (single, double, suite, deluxe, presidential)
- `price_per_night`: Decimal(8,2)
- `description`: Text (nullable)
- `amenities`: JSON array (nullable)
- `max_occupancy`: Integer (default: 2)
- `is_available`: Boolean (default: true)
- `created_at`, `updated_at`: Timestamps

### Guests Table
- `id`: Primary key
- `first_name`, `last_name`: Required strings
- `email`: Unique string
- `phone`: String (nullable)
- `address`: Text (nullable)
- `date_of_birth`: Date (nullable)
- `gender`: Enum (male, female, other, nullable)
- `nationality`: String (nullable)
- `id_number`: String (nullable)
- `created_at`, `updated_at`: Timestamps

### Bookings Table
- `id`: Primary key
- `guest_id`: Foreign key to guests table
- `room_id`: Foreign key to rooms table
- `check_in_date`, `check_out_date`: Dates
- `number_of_guests`: Integer (default: 1)
- `total_amount`: Decimal(10,2)
- `status`: Enum (pending, confirmed, checked_in, checked_out, cancelled)
- `special_requests`: Text (nullable)
- `booking_date`: Timestamp (auto-set)
- `created_at`, `updated_at`: Timestamps

## Installation & Setup

1. **Install Dependencies:**
   ```bash
   composer install
   npm install
   ```

2. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Start Development Server:**
   ```bash
   php artisan serve
   ```

## Sample Data

The system includes comprehensive seeders that create:
- 12 sample rooms of different types
- 10 sample guests from various countries
- Multiple bookings in different statuses (past, current, future, pending, cancelled)

## Business Logic Features

### Room Availability
- Prevents double booking of rooms
- Checks occupancy limits
- Handles date conflicts intelligently

### Booking Status Flow
- **Pending** → **Confirmed** → **Checked In** → **Checked Out**
- **Pending** → **Cancelled**
- **Confirmed** → **Cancelled** (if before check-in date)

### Validation Rules
- Check-in date must be today or later
- Check-out date must be after check-in date
- Number of guests cannot exceed room capacity
- Room must be available for selected dates
- Email addresses must be unique for guests
- Room numbers must be unique

### Calculated Fields
- Total booking amount (price per night × number of nights)
- Number of nights between dates
- Current booking status
- Cancellation eligibility

## Error Handling

The API returns appropriate HTTP status codes:
- **200**: Success
- **201**: Created successfully
- **400**: Bad request
- **404**: Resource not found
- **422**: Validation error
- **500**: Server error

All validation errors include detailed messages explaining what went wrong.

## Testing

Run the test suite:
```bash
php artisan test
```

## API Usage Examples

### Create a Booking
```bash
POST /api/bookings
{
    "guest_id": 1,
    "room_id": 5,
    "check_in_date": "2024-10-20",
    "check_out_date": "2024-10-23",
    "number_of_guests": 2,
    "special_requests": "Late check-in expected"
}
```

### Check Room Availability
```bash
GET /api/available-rooms?check_in_date=2024-10-20&check_out_date=2024-10-23&room_type=double
```

### Search Guests
```bash
GET /api/search/guests?term=john
```

This system provides a complete backend solution for hotel room booking management with comprehensive validation, error handling, and business logic implementation.