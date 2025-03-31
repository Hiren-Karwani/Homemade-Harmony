# Homemade Harmony - Tiffin Service

## 📌 Overview
Homemade Harmony is an online tiffin service that allows users to browse meal schedules, place orders, and make payments. The platform includes features like user authentication, a cart system, an admin dashboard, and multiple payment options including Razorpay and Cash on Delivery (COD).

## 🚀 Features
- **User Authentication**: Register, login, and session-based access control.
- **Meal Ordering System**: View schedule and place orders.
- **Cart System**: Add, update, and remove items before checkout.
- **Payment Options**:
  - **Razorpay Payment Gateway**
  - **Cash on Delivery (COD)**
- **Admin Dashboard**:
  - Manage orders (approve/reject pending orders).
  - Add/remove/update products and schedule.
  - View pending orders and user addresses.
- **Filters & Search**: Easily search meals and filter them.

## 🏗️ Project Structure
```
Homemade-Harmony/
│── css/                 # Stylesheets
│── images/              # Image assets
│── js/                  # JavaScript files
│── php/
│   ├── config.php       # Database connection
│   ├── auth_check.php   # Session-based authentication check
│   ├── admin_dashboard.php # Admin panel
│   ├── add_product.php  # Admin: Add new meals/products
│── index.php            # Home page
│── register.php         # User Registration Page
│── login.php            # User Login Page
│── logout.php           # Logout script
│── cart.php             # Shopping Cart
│── checkout.php         # Razorpay & COD checkout page
│── cod_success.php      # COD Order Confirmation
│── payment_success.php  # Razorpay Payment Success
│── schedule.php         # View meal schedule
│── contact.php          # Contact & Feedback Form
│── README.md            # Project Documentation
```

## 🛠️ Setup & Installation
### 1️⃣ Prerequisites
- Install [XAMPP](https://www.apachefriends.org/index.html) (or any PHP & MySQL server).
- Install [Composer](https://getcomposer.org/) (for Razorpay SDK).

### 2️⃣ Clone the Repository
```sh
git clone https://github.com/Hiren-Karwani/Homemade-Harmony.git
cd Homemade-Harmony
```

### 3️⃣ Set Up the Database
1. Open `phpMyAdmin` and create a database named `homemade_harmony`.
2. Import `database.sql` (if available) to set up tables.
3. Update `php/config.php` with your database credentials.

```php
$servername = "localhost";
$username = "root";
$password = "";
$database = "tiffins";
$conn = new mysqli($servername, $username, $password, $database);
```

### 4️⃣ Install Razorpay SDK
Run the following command inside the project folder:
```sh
composer require razorpay/razorpay
```

### 5️⃣ Start the Server
Run XAMPP and start **Apache** and **MySQL**. Open the browser and go to:
```
http://localhost/Homemade-Harmony/index.php
```

## 🔑 Admin Login
- **Admin Panel URL**: `admin_dashboard.php`
- **Default Credentials**:
  - **Username**: `Hiren`
  - **Password**: `123` (change after first login!)

## 🛒 How to Place an Order?
1. Register/Login.
2. Browse the weekly meal schedule.
3. Add meals to your cart.
4. Proceed to checkout.
5. Choose **Razorpay** (Online) or **Cash on Delivery**.
6. Confirm your order.

## 📌 Future Improvements
- ✅ Add order tracking system.
- ✅ Implement an order cancellation feature.
- ✅ Improve UI with better responsiveness.

## 🤝 Contributing
Want to contribute? Fork the repo and submit a pull request!

## 📞 Support
For any issues or suggestions, contact us at `karwanih7@gmail.com`.

---
**© 2025 Homemade Harmony. All rights reserved.**

