# Hotel Booking System - API Test Commands

# These commands can be used to test the API endpoints using PowerShell

# 1. Get Dashboard Statistics
Invoke-RestMethod -Uri "http://localhost:8000/api/dashboard" -Method GET -ContentType "application/json"

# 2. Get All Rooms
Invoke-RestMethod -Uri "http://localhost:8000/api/rooms" -Method GET -ContentType "application/json"

# 3. Get Available Rooms for Specific Dates
Invoke-RestMethod -Uri "http://localhost:8000/api/available-rooms?check_in_date=2024-12-01&check_out_date=2024-12-03" -Method GET -ContentType "application/json"

# 4. Get All Guests
Invoke-RestMethod -Uri "http://localhost:8000/api/guests" -Method GET -ContentType "application/json"

# 5. Get All Bookings
Invoke-RestMethod -Uri "http://localhost:8000/api/bookings" -Method GET -ContentType "application/json"

# 6. Get Today's Check-ins
Invoke-RestMethod -Uri "http://localhost:8000/api/today/check-ins" -Method GET -ContentType "application/json"

# 7. Get Today's Check-outs
Invoke-RestMethod -Uri "http://localhost:8000/api/today/check-outs" -Method GET -ContentType "application/json"

# 8. Get Booking Statistics
Invoke-RestMethod -Uri "http://localhost:8000/api/bookings-statistics" -Method GET -ContentType "application/json"

# 9. Create a New Guest
$guestData = @{
    first_name = "Alice"
    last_name = "Williams"
    email = "alice.williams@example.com"
    phone = "+1-555-0199"
    nationality = "American"
}
Invoke-RestMethod -Uri "http://localhost:8000/api/guests" -Method POST -Body ($guestData | ConvertTo-Json) -ContentType "application/json"

# 10. Create a New Room
$roomData = @{
    room_number = "505"
    room_type = "suite"
    price_per_night = 300.00
    description = "Executive suite with panoramic view"
    amenities = @("WiFi", "TV", "Air Conditioning", "Mini Bar", "Safe", "Balcony")
    max_occupancy = 4
}
Invoke-RestMethod -Uri "http://localhost:8000/api/rooms" -Method POST -Body ($roomData | ConvertTo-Json) -ContentType "application/json"

# 11. Create a New Booking
$bookingData = @{
    guest_id = 1
    room_id = 3
    check_in_date = "2024-12-10"
    check_out_date = "2024-12-13"
    number_of_guests = 2
    special_requests = "Ocean view room preferred"
}
Invoke-RestMethod -Uri "http://localhost:8000/api/bookings" -Method POST -Body ($bookingData | ConvertTo-Json) -ContentType "application/json"

# 12. Search Guests
Invoke-RestMethod -Uri "http://localhost:8000/api/search/guests?term=john" -Method GET -ContentType "application/json"