$bookingData = @{
    guest_id = 1
    room_id = 1
    check_in_date = "2025-12-10"
    check_out_date = "2025-12-13"
    number_of_guests = 1
    special_requests = "Test booking via API"
}

$json = $bookingData | ConvertTo-Json
Invoke-RestMethod -Uri "http://localhost:8000/api/bookings" -Method POST -Body $json -ContentType "application/json"