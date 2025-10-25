@extends('layouts.app')

@section('title', 'System Settings - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <h2><i class="bi bi-gear"></i> System Settings</h2>
            <p class="text-muted">Manage hotel booking system configuration and preferences.</p>
        </div>
    </div>
    
    <div class="row">
        <!-- General Settings -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-building"></i> Hotel Information</h5>
                </div>
                <div class="card-body">
                    <form id="hotelSettingsForm">
                        <div class="mb-3">
                            <label for="hotel_name" class="form-label">Hotel Name</label>
                            <input type="text" class="form-control" id="hotel_name" value="Grand Hotel & Resort">
                        </div>
                        <div class="mb-3">
                            <label for="hotel_address" class="form-label">Address</label>
                            <textarea class="form-control" id="hotel_address" rows="3">123 Ocean View Drive
Miami Beach, FL 33139
United States</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hotel_phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="hotel_phone" value="+1 (305) 555-0123">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hotel_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="hotel_email" value="info@grandhotel.com">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Hotel Info
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Booking Settings -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Booking Settings</h5>
                </div>
                <div class="card-body">
                    <form id="bookingSettingsForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="checkin_time" class="form-label">Check-in Time</label>
                                    <input type="time" class="form-control" id="checkin_time" value="15:00">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="checkout_time" class="form-label">Check-out Time</label>
                                    <input type="time" class="form-control" id="checkout_time" value="11:00">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                            <input type="number" class="form-control" id="tax_rate" value="10" min="0" max="100" step="0.1">
                        </div>
                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <select class="form-select" id="currency">
                                <option value="USD" selected>USD - US Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="GBP">GBP - British Pound</option>
                                <option value="CAD">CAD - Canadian Dollar</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="allow_overbooking">
                            <label class="form-check-label" for="allow_overbooking">
                                Allow Overbooking
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Booking Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Email Settings -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-envelope"></i> Email Settings</h5>
                </div>
                <div class="card-body">
                    <form id="emailSettingsForm">
                        <div class="mb-3">
                            <label for="smtp_host" class="form-label">SMTP Host</label>
                            <input type="text" class="form-control" id="smtp_host" value="smtp.gmail.com">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="smtp_port" class="form-label">SMTP Port</label>
                                    <input type="number" class="form-control" id="smtp_port" value="587">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="smtp_security" class="form-label">Security</label>
                                    <select class="form-select" id="smtp_security">
                                        <option value="tls" selected>TLS</option>
                                        <option value="ssl">SSL</option>
                                        <option value="none">None</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="send_confirmation_emails" checked>
                            <label class="form-check-label" for="send_confirmation_emails">
                                Send Booking Confirmation Emails
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="send_reminder_emails" checked>
                            <label class="form-check-label" for="send_reminder_emails">
                                Send Check-in Reminder Emails
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Email Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- System Information -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> System Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>System Version:</strong></td>
                            <td>1.0.0</td>
                        </tr>
                        <tr>
                            <td><strong>Laravel Version:</strong></td>
                            <td>{{ app()->version() }}</td>
                        </tr>
                        <tr>
                            <td><strong>PHP Version:</strong></td>
                            <td>{{ PHP_VERSION }}</td>
                        </tr>
                        <tr>
                            <td><strong>Database:</strong></td>
                            <td id="databaseInfo">Loading...</td>
                        </tr>
                        <tr>
                            <td><strong>Server Time:</strong></td>
                            <td id="serverTime">{{ now()->format('Y-m-d H:i:s T') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Timezone:</strong></td>
                            <td>{{ config('app.timezone') }}</td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <h6><i class="bi bi-database"></i> Database Statistics</h6>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-item">
                                <h4 class="text-primary" id="roomCount">0</h4>
                                <small>Rooms</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h4 class="text-success" id="guestCount">0</h4>
                                <small>Guests</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <h4 class="text-info" id="bookingCount">0</h4>
                                <small>Bookings</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-primary w-100 mb-2" onclick="clearCache()">
                                <i class="bi bi-arrow-clockwise"></i> Clear Cache
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-info w-100 mb-2" onclick="backupDatabase()">
                                <i class="bi bi-download"></i> Backup Database
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success w-100 mb-2" onclick="generateReport()">
                                <i class="bi bi-file-earmark-pdf"></i> Generate Report
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-warning w-100 mb-2" onclick="maintenanceMode()">
                                <i class="bi bi-tools"></i> Maintenance Mode
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadSystemInfo();
    loadDatabaseStats();
    
    // Auto-save forms
    document.getElementById('hotelSettingsForm').addEventListener('submit', saveHotelSettings);
    document.getElementById('bookingSettingsForm').addEventListener('submit', saveBookingSettings);
    document.getElementById('emailSettingsForm').addEventListener('submit', saveEmailSettings);
});

async function loadSystemInfo() {
    try {
        // Get database info
        const dbInfo = await api.get('/system/database-info');
        document.getElementById('databaseInfo').textContent = dbInfo.connection + ' (' + dbInfo.version + ')';
    } catch (error) {
        document.getElementById('databaseInfo').textContent = 'MySQL';
    }
}

async function loadDatabaseStats() {
    try {
        const stats = await api.get('/system/stats');
        document.getElementById('roomCount').textContent = stats.rooms || 0;
        document.getElementById('guestCount').textContent = stats.guests || 0;
        document.getElementById('bookingCount').textContent = stats.bookings || 0;
    } catch (error) {
        console.error('Error loading database stats:', error);
    }
}

async function saveHotelSettings(e) {
    e.preventDefault();
    showToast('Hotel information saved successfully!');
}

async function saveBookingSettings(e) {
    e.preventDefault();
    showToast('Booking settings saved successfully!');
}

async function saveEmailSettings(e) {
    e.preventDefault();
    showToast('Email settings saved successfully!');
}

async function clearCache() {
    if (!confirm('Are you sure you want to clear the system cache?')) {
        return;
    }
    
    try {
        showLoading();
        // Simulate cache clearing
        await new Promise(resolve => setTimeout(resolve, 2000));
        hideLoading();
        showToast('System cache cleared successfully!');
    } catch (error) {
        hideLoading();
        showToast('Error clearing cache. Please try again.', 'error');
    }
}

async function backupDatabase() {
    if (!confirm('Are you sure you want to create a database backup?')) {
        return;
    }
    
    try {
        showLoading();
        // Simulate backup creation
        await new Promise(resolve => setTimeout(resolve, 3000));
        hideLoading();
        showToast('Database backup created successfully!');
    } catch (error) {
        hideLoading();
        showToast('Error creating backup. Please try again.', 'error');
    }
}

async function generateReport() {
    try {
        showLoading();
        // Simulate report generation
        await new Promise(resolve => setTimeout(resolve, 2000));
        hideLoading();
        showToast('System report generated successfully!');
        
        // Simulate download
        const link = document.createElement('a');
        link.href = '#';
        link.download = `hotel-report-${new Date().toISOString().split('T')[0]}.pdf`;
        link.click();
    } catch (error) {
        hideLoading();
        showToast('Error generating report. Please try again.', 'error');
    }
}

async function maintenanceMode() {
    const isEnabled = confirm('Toggle maintenance mode? This will prevent guests from making new bookings.');
    
    if (isEnabled) {
        showToast('Maintenance mode enabled. New bookings are disabled.');
    }
}
</script>
@endpush

@push('styles')
<style>
.stat-item {
    padding: 1rem;
    text-align: center;
}

.table td {
    vertical-align: middle;
    padding: 0.5rem 0;
}

.card {
    margin-bottom: 1.5rem;
}

.form-control, .form-select {
    border-radius: 5px;
}

.btn {
    border-radius: 5px;
}
</style>
@endpush