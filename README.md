# 🏨 Booking Hotel Web Application

A simple and functional hotel booking system developed using **PHP**, **MySQL**, **HTML/CSS**, and a bit of **JavaScript**. This web-based project allows users to register, log in, book and cancel rooms, while administrators can manage rooms through a separate dashboard.

## ✨ Features

- 🔐 User Authentication (Register, Login, Logout)
- 👤 Separate Dashboards for Users and Admins
- 🏨 Admin Room Management (Add, Edit, Delete)
- 📅 Booking and Cancellation System
- 📄 Booking Confirmation Page
- 💾 MySQL Database Integration
- 🎨 Custom CSS Styling for Different Pages

## 📁 Project Structure

```
BookingHotel-webProgramming--main/
│
├── index.php                   # Home page
├── login.php                   # User login
├── register.php                # User registration
├── logout.php                  # User logout
├── user_dashboard.php          # Dashboard for regular users
├── admin_dashboard.php         # Dashboard for admin users
├── add_room.php                # Add a new room (admin only)
├── edit_room.php               # Edit room details (admin only)
├── delete_room.php             # Delete a room (admin only)
├── booking_confirmation.php    # Booking confirmation page
├── cancel_booking.php          # Cancel a booking
├── test_db.php                 # Test database connection
├── config/
│   └── db.php                  # Database connection settings
├── script.js                   # Front-end interactions
├── hotel.jpg                   # Sample image used on pages
├── styles_admin.css            # Styles for admin dashboard
├── styles_dashboard.css        # Styles for user dashboard
├── styles_index.css            # Styles for homepage
├── styles_login.css            # Styles for login page
├── styles_confirmation.css     # Styles for confirmation page
└── README.md                   # Project documentation
```

## ⚙️ How to Run the Project

1. **Clone or download this repository:**
   ```bash
   git clone https://github.com/yourusername/BookingHotel-webProgramming--main.git
   ```

2. **Move the project folder to your local server directory:**
   - For **XAMPP**: `htdocs/`
   - For **WAMP**: `www/`

3. **Create a MySQL database:**
   - Open `phpMyAdmin`
   - Create a new database, for example: `hotel_booking`
   - Import the SQL file (if provided) to set up the tables

4. **Configure the database connection:**
   - Open `config/db.php`
   - Set your database credentials:
     ```php
     $conn = new mysqli("localhost", "root", "", "hotel_booking");
     ```

5. **Launch the project in your browser:**
   ```
   http://localhost/BookingHotel-webProgramming--main/
   ```

## 🧪 Database Test

To check if the database connection is working, open:
```
http://localhost/BookingHotel-webProgramming--main/test_db.php
```

## 👨‍💻 Developer

Web Programming Project  
Developed by: **Niloufar Cheraghi**

## 📄 License

This project is licensed under the **MIT License**. 
