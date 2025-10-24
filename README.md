# 🏨 Hotel Room Booking System

A full-featured **Hotel Room Booking System** built with **Laravel 10**, designed to simplify guest reservations, room management, and booking operations for small hotels.  

This system allows admins to manage rooms and bookings efficiently, while guests can register, view available rooms, and make bookings seamlessly with real-time availability checks.

---

## 🚀 Features

### 👤 Guest Features
- User registration and secure authentication (Laravel Breeze)
- Browse and view available rooms with details
- Check room availability before booking
- Make room bookings with date validation
- View and manage own bookings
- Automatic total price calculation (based on stay duration)

### 🛠️ Admin Features
- Admin dashboard for managing rooms and bookings
- CRUD operations for rooms (add, update, delete)
- View all guest bookings and update booking statuses
- Role-based access control (Admin / Guest)
- Manage room statuses (Available, Maintenance, Inactive)

### ⚙️ System Features
- Date-based booking overlap prevention
- Eloquent ORM with relational data models
- Blade templates with TailwindCSS (via Laravel Breeze)
- CSRF protection, validation, and authentication middleware
- Clean, maintainable MVC architecture

---

## 🧩 Tech Stack

| Layer | Technology |
|-------|-------------|
| **Framework** | Laravel 10 |
| **Language** | PHP 8.2 |
| **Database** | MySQL / MariaDB |
| **Frontend** | Blade Templates, Tailwind CSS |
| **Authentication** | Laravel Breeze |
| **Server** | Apache / Nginx |
| **Environment** | XAMPP / Laravel Sail / Localhost |

---

## 🗄️ Database Schema Overview

**Tables:**
- `users` – Stores user details (guests/admins)
- `rooms` – Room details like number, type, price, and status
- `bookings` – Tracks bookings with check-in/out and total price

**Relationships:**
- `User` → hasMany(`Booking`)
- `Room` → hasMany(`Booking`)
- `Booking` → belongsTo(`User`), belongsTo(`Room`)

---

## ⚙️ Installation Guide

### 1️⃣ Clone the repository
```bash
git clone https://github.com/your-username/hotel-booking-system.git
cd hotel-booking-system
