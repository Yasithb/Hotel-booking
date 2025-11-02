@extends('layouts.app')

@section('title', 'Add New Room - Hotel Booking System')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Add New Room
                    </h4>
                </div>
                <div class="card-body">
                    <form id="roomForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_number" class="form-label">Room Number *</label>
                                    <input type="text" class="form-control" id="room_number" name="room_number" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_type" class="form-label">Room Type *</label>
                                    <select class="form-select" id="room_type" name="room_type" required>
                                        <option value="">Select room type</option>
                                        <option value="single">Single</option>
                                        <option value="double">Double</option>
                                        <option value="suite">Suite</option>
                                        <option value="deluxe">Deluxe</option>
                                        <option value="presidential">Presidential</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price_per_night" class="form-label">Price per Night ($) *</label>
                                    <input type="number" class="form-control" id="price_per_night" name="price_per_night" min="0" step="0.01" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_occupancy" class="form-label">Maximum Occupancy *</label>
                                    <input type="number" class="form-control" id="max_occupancy" name="max_occupancy" min="1" max="10" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe the room features and amenities"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="amenities" class="form-label">Amenities</label>
                            <div class="row" id="amenitiesContainer">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="WiFi" id="amenity_wifi">
                                        <label class="form-check-label" for="amenity_wifi">WiFi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="TV" id="amenity_tv">
                                        <label class="form-check-label" for="amenity_tv">TV</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Air Conditioning" id="amenity_ac">
                                        <label class="form-check-label" for="amenity_ac">Air Conditioning</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Mini Bar" id="amenity_minibar">
                                        <label class="form-check-label" for="amenity_minibar">Mini Bar</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Safe" id="amenity_safe">
                                        <label class="form-check-label" for="amenity_safe">Safe</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Balcony" id="amenity_balcony">
                                        <label class="form-check-label" for="amenity_balcony">Balcony</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Kitchenette" id="amenity_kitchenette">
                                        <label class="form-check-label" for="amenity_kitchenette">Kitchenette</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Living Area" id="amenity_living">
                                        <label class="form-check-label" for="amenity_living">Living Area</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Sea View" id="amenity_seaview">
                                        <label class="form-check-label" for="amenity_seaview">Sea View</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="City View" id="amenity_cityview">
                                        <label class="form-check-label" for="amenity_cityview">City View</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Garden View" id="amenity_gardenview">
                                        <label class="form-check-label" for="amenity_gardenview">Garden View</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Jacuzzi" id="amenity_jacuzzi">
                                        <label class="form-check-label" for="amenity_jacuzzi">Jacuzzi</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="customAmenity" placeholder="Add custom amenity">
                                    <button type="button" class="btn btn-outline-secondary" onclick="addCustomAmenity()">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_available" name="is_available" checked>
                                <label class="form-check-label" for="is_available">
                                    Room is available for booking
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Rooms
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('roomForm').addEventListener('submit', handleSubmit);
    
    // Add enter key handler for custom amenity
    document.getElementById('customAmenity').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addCustomAmenity();
        }
    });
});

async function handleSubmit(e) {
    e.preventDefault();
    
    // Clear previous validation errors
    clearValidationErrors();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    
    // Collect amenities
    const amenities = [];
    document.querySelectorAll('#amenitiesContainer input[type="checkbox"]:checked').forEach(checkbox => {
        amenities.push(checkbox.value);
    });
    data.amenities = amenities;
    
    // Convert boolean values
    data.is_available = document.getElementById('is_available').checked;
    data.price_per_night = parseFloat(data.price_per_night);
    data.max_occupancy = parseInt(data.max_occupancy);
    
    try {
        showLoading();
        const response = await api.post('/rooms', data);
        hideLoading();
        
        showToast('Room created successfully!');
        setTimeout(() => {
            window.location.href = '{{ route("rooms.index") }}';
        }, 1500);
        
    } catch (error) {
        hideLoading();
        console.error('Error creating room:', error);
        
        if (error.errors) {
            displayValidationErrors(error.errors);
        } else {
            showToast('Error creating room. Please try again.', 'error');
        }
    }
}

function addCustomAmenity() {
    const input = document.getElementById('customAmenity');
    const amenity = input.value.trim();
    
    if (!amenity) return;
    
    // Check if amenity already exists
    const existingCheckboxes = document.querySelectorAll('#amenitiesContainer input[type="checkbox"]');
    for (let checkbox of existingCheckboxes) {
        if (checkbox.value.toLowerCase() === amenity.toLowerCase()) {
            showToast('This amenity already exists', 'error');
            input.value = '';
            return;
        }
    }
    
    // Create new checkbox
    const container = document.querySelector('#amenitiesContainer .col-md-4:last-child');
    const checkboxDiv = document.createElement('div');
    checkboxDiv.className = 'form-check';
    
    const checkboxId = 'amenity_custom_' + Date.now();
    checkboxDiv.innerHTML = `
        <input class="form-check-input" type="checkbox" value="${amenity}" id="${checkboxId}" checked>
        <label class="form-check-label" for="${checkboxId}">${amenity}</label>
        <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeCustomAmenity(this)">
            <i class="bi bi-x"></i>
        </button>
    `;
    
    container.appendChild(checkboxDiv);
    input.value = '';
    
    showToast('Custom amenity added!');
}

function removeCustomAmenity(button) {
    button.closest('.form-check').remove();
}

function clearValidationErrors() {
    document.querySelectorAll('.is-invalid').forEach(element => {
        element.classList.remove('is-invalid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(element => {
        element.textContent = '';
    });
}

function displayValidationErrors(errors) {
    for (const [field, messages] of Object.entries(errors)) {
        const input = document.querySelector(`[name="${field}"], #${field}`);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = messages[0];
            }
        }
    }
}
</script>
@endpush