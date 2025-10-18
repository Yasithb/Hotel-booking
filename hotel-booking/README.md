# Hotel Room Booking System

A comprehensive backend API for managing hotel room bookings, built with Laravel 12. This system provides complete functionality for a small hotel to manage rooms, guests, and bookings efficiently.

## 🏨 Features

### Core Functionality
- **Room Management**: Complete CRUD operations for hotel rooms
- **Guest Management**: Register and manage guest information
- **Booking System**: Create, modify, and track reservations
- **Availability Checking**: Real-time room availability for specific dates
- **Status Management**: Handle booking lifecycle (pending → confirmed → checked-in → checked-out)
- **Dashboard Analytics**: Overview of hotel operations and statistics

### Business Logic
- **Conflict Prevention**: Prevents double-booking of rooms
- **Capacity Validation**: Ensures guest count doesn't exceed room capacity
- **Date Validation**: Enforces logical check-in/check-out date rules
- **Status Workflow**: Manages booking status transitions with proper validation
- **Automatic Calculations**: Auto-calculates total amounts based on room rates and duration

## 🗄️ Database Schema

### Rooms Table
- Room number (unique identifier)
- Room type (single, double, suite, deluxe, presidential)
- Price per night
- Maximum occupancy
- Amenities (JSON array)
- Availability status
- Description

### Guests Table
- Personal information (name, email, phone)
- Address and contact details
- Identity information (date of birth, nationality, ID number)
- Gender (optional)

### Bookings Table
- Guest and room associations (foreign keys)
- Check-in and check-out dates
- Number of guests
- Total amount (auto-calculated)
- Status (pending, confirmed, checked_in, checked_out, cancelled)
- Special requests
- Booking timestamp

## 🚀 API Endpoints

### Room Management
- `GET /api/rooms` - List all rooms with filtering options
- `POST /api/rooms` - Create a new room
- `GET /api/rooms/{id}` - Get specific room details
- `PUT /api/rooms/{id}` - Update room information
- `DELETE /api/rooms/{id}` - Delete room (if no active bookings)
- `GET /api/rooms/{id}/availability` - Check room availability for dates
- `GET /api/available-rooms` - Get available rooms for specific dates

### Guest Management
- `GET /api/guests` - List all guests with search functionality
- `POST /api/guests` - Register a new guest
- `GET /api/guests/{id}` - Get guest details with booking history
- `PUT /api/guests/{id}` - Update guest information
- `DELETE /api/guests/{id}` - Delete guest (if no active bookings)
- `GET /api/guests/{id}/bookings` - Get guest's booking history
- `GET /api/guests/{id}/current-bookings` - Get guest's current bookings
- `GET /api/search/guests` - Search guests by various criteria

### Booking Management
- `GET /api/bookings` - List all bookings with filtering
- `POST /api/bookings` - Create a new booking
- `GET /api/bookings/{id}` - Get booking details
- `PUT /api/bookings/{id}` - Update booking information
- `DELETE /api/bookings/{id}` - Delete booking (pending/cancelled only)
- `POST /api/bookings/{id}/cancel` - Cancel a booking
- `POST /api/bookings/{id}/confirm` - Confirm a pending booking
- `POST /api/bookings/{id}/check-in` - Check in a guest
- `POST /api/bookings/{id}/check-out` - Check out a guest

### Dashboard & Analytics
- `GET /api/dashboard` - Get hotel overview statistics
- `GET /api/today/check-ins` - Today's scheduled check-ins
- `GET /api/today/check-outs` - Today's scheduled check-outs
- `GET /api/bookings-statistics` - Comprehensive booking statistics

## 📋 Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- SQLite (default) or other database

### Installation Steps

1. **Clone and Setup**
   ```bash
   cd hotel-booking
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Start Development Server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000/api`

## 📊 Sample Data

The system includes comprehensive seeders that create:

### Sample Rooms (12 total)
- **Single Rooms**: 3 rooms (101-103) - $80-85/night
- **Double Rooms**: 4 rooms (201-204) - $120-130/night
- **Deluxe Rooms**: 2 rooms (401-402) - $180-190/night
- **Suites**: 2 rooms (301-302) - $250-280/night
- **Presidential Suite**: 1 room (501) - $500/night

### Sample Guests (10 total)
- International guests from various countries
- Complete contact information and identity details
- Realistic names and addresses

### Sample Bookings (11 total)
- **Past bookings** (checked out)
- **Current bookings** (checked in)
- **Today's check-ins/check-outs**
- **Future bookings** (confirmed)
- **Pending bookings** (awaiting confirmation)
- **Cancelled bookings**

## 🧪 Testing the API

### Using PowerShell (Windows)

```powershell
# Get dashboard statistics
Invoke-RestMethod -Uri "http://localhost:8000/api/dashboard" -Method GET

# Get all rooms
Invoke-RestMethod -Uri "http://localhost:8000/api/rooms" -Method GET

# Check available rooms for specific dates
Invoke-RestMethod -Uri "http://localhost:8000/api/available-rooms?check_in_date=2025-12-01&check_out_date=2025-12-03" -Method GET

# Create a new booking
$bookingData = @{
    guest_id = 1
    room_id = 3
    check_in_date = "2025-12-15"
    check_out_date = "2025-12-18"
    number_of_guests = 2
    special_requests = "Ocean view preferred"
}
Invoke-RestMethod -Uri "http://localhost:8000/api/bookings" -Method POST -Body ($bookingData | ConvertTo-Json) -ContentType "application/json"
```

### Using cURL (Linux/Mac)

```bash
# Get dashboard statistics
curl -X GET "http://localhost:8000/api/dashboard" -H "Accept: application/json"

# Create a new guest
curl -X POST "http://localhost:8000/api/guests" \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Jane",
    "last_name": "Doe",
    "email": "jane.doe@example.com",
    "phone": "+1-555-0123",
    "nationality": "American"
  }'
```

## 📋 Business Rules & Validation

### Room Booking Rules
- Check-in date must be today or later
- Check-out date must be after check-in date
- Number of guests cannot exceed room maximum occupancy
- Room must be available for the entire requested period
- No overlapping bookings allowed for the same room

### Status Transitions
- **Pending** → **Confirmed** (manual confirmation)
- **Confirmed** → **Checked In** (on/after check-in date)
- **Checked In** → **Checked Out** (checkout process)
- **Pending/Confirmed** → **Cancelled** (before check-in)

### Data Validation
- Unique email addresses for guests
- Unique room numbers
- Valid date formats and logical date sequences
- Positive numeric values for prices and occupancy
- Valid enum values for room types and booking statuses

## 🔧 Technical Implementation

### Models & Relationships
- **Room** has many **Bookings**
- **Guest** has many **Bookings**
- **Booking** belongs to **Room** and **Guest**

### Key Features
- **JSON Casting**: Room amenities stored as JSON arrays
- **Date Casting**: Automatic date parsing for booking dates
- **Scopes**: Query scopes for active, upcoming bookings
- **Accessors**: Computed attributes like full name, number of nights
- **Validation**: Comprehensive request validation
- **Error Handling**: Proper HTTP status codes and error messages

### Performance Considerations
- **Eager Loading**: Related models loaded efficiently
- **Pagination**: Large datasets paginated automatically
- **Indexing**: Database indexes on commonly queried fields
- **Query Optimization**: Efficient database queries for availability checking

## 📈 Dashboard Metrics

The dashboard provides real-time insights:
- Total rooms and availability count
- Guest registration statistics
- Active bookings overview
- Today's check-in/check-out schedules
- Pending bookings requiring attention
- Revenue tracking and booking statistics

## 🏗️ Architecture

### Laravel Framework Features Used
- **Eloquent ORM**: For database interactions
- **Resource Controllers**: RESTful API endpoints
- **Form Requests**: Input validation
- **Migrations**: Database schema versioning
- **Seeders**: Sample data generation
- **Route Model Binding**: Automatic model resolution

### Best Practices Implemented
- **RESTful API Design**: Following REST conventions
- **Single Responsibility**: Controllers focused on specific actions
- **Data Validation**: Comprehensive input validation
- **Error Handling**: Consistent error responses
- **Code Organization**: Logical file structure and naming

## 📝 API Response Format

All API endpoints return JSON responses with consistent structure:

### Success Response
```json
{
  "message": "Operation successful",
  "data": { ... },
  "meta": { ... }
}
```

### Error Response
```json
{
  "message": "Validation failed",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

### Paginated Response
```json
{
  "current_page": 1,
  "data": [...],
  "first_page_url": "...",
  "last_page": 3,
  "per_page": 15,
  "total": 42
}
```

## 🎯 Use Cases Covered

1. **Hotel Reception**: Check-in/check-out guests, view daily schedules
2. **Reservations**: Create, modify, cancel bookings
3. **Room Management**: Add new rooms, update pricing, manage availability
4. **Guest Services**: Access guest history, manage special requests
5. **Management**: View occupancy statistics, revenue tracking
6. **Maintenance**: Mark rooms unavailable, track room status

This Hotel Room Booking System provides a complete backend solution for hotel management with robust validation, error handling, and business logic implementation. The API is designed to be consumed by web, mobile, or desktop applications providing a seamless hotel management experience.

---

## 📚 Additional Resources

- **API Documentation**: See `API_DOCUMENTATION.md` for detailed endpoint documentation
- **Testing Scripts**: Use `API_TESTS.md` for PowerShell testing commands
- **Laravel Documentation**: [https://laravel.com/docs](https://laravel.com/docs)
