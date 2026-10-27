# CaneDae ThirdHome Catering – XAMPP Setup Guide

## 📁 Folder Structure
```
canedae/                    ← Place this in C:/xampp/htdocs/canedae/
├── index.php               ← Homepage
├── config/
│   └── db.php              ← Database config
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── pages/
│   ├── about.php
│   ├── packages.php
│   ├── trays.php
│   ├── calendar.php        ← Step 1: Date selection
│   ├── menu.php            ← Step 3: Menu customization
│   ├── event-details.php   ← Step 4: Event info
│   ├── summary.php         ← Step 5: Summary
│   ├── payment.php         ← Step 6: Payment
│   ├── receipt.php         ← Step 7: Digital receipt
│   └── my-reservations.php ← Reservation status
├── includes/
│   ├── header.php          ← Shared navbar
│   ├── footer.php          ← Shared footer
│   └── booking_steps.php   ← Step indicator
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   ├── images/             ← Add your images here
│   └── uploads/payments/   ← Payment proof uploads (auto-created)
└── database/
    └── canedae_db.sql      ← Import this into phpMyAdmin
```

## 🚀 Setup Steps

### 1. Copy Files
Copy the entire `canedae` folder to:
```
C:\xampp\htdocs\canedae\
```

### 2. Start XAMPP
- Open **XAMPP Control Panel**
- Start **Apache** and **MySQL**

### 3. Import Database
1. Open browser → `http://localhost/phpmyadmin`
2. Click **"New"** → Create database: `canedae_db`
3. Select `canedae_db` → Click **"Import"**
4. Choose file: `database/canedae_db.sql`
5. Click **"Go"**

### 4. Configure Database (if needed)
Edit `config/db.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');        // Your MySQL password (usually empty in XAMPP)
define('DB_NAME', 'canedae_db');
define('BASE_URL', 'http://localhost/canedae/');
```

### 5. Add Images
Place your images in `assets/images/`:
- `logo.png` – Your logo (circular, ~100x100)
- `hero_food.jpg` – Hero section food photo
- `pkg_birthday.jpg` – Birthday package
- `pkg_anniversary.jpg` – Anniversary package
- `pkg_corporate.jpg` – Corporate package
- `pkg_wedding.jpg` – Wedding package
- `tray_chicken.jpg` – Chicken tray
- `tray_beef.jpg` – Beef tray
- `tray_fish.jpg` – Fish/Seafoods tray
- `tray_vegetables.jpg` – Vegetables tray
- `linen_texture.png` – Background texture (optional, CSS handles fallback)

> **Note:** If images are missing, online fallback images are automatically used via onerror.

### 6. Open the Website
```
http://localhost/canedae/
```

## 🔑 Default Admin Login
| Field    | Value                  |
|----------|------------------------|
| Email    | admin@canedae.com      |
| Password | password               |

> ⚠️ Change the admin password after first login!

## 👤 User Roles
| Role  | Access                                      |
|-------|---------------------------------------------|
| user  | Browse, book, view own reservations         |
| admin | Full system management (coming next phase)  |

## 📋 Booking Flow
```
HOME
  ↓
BOOK NOW
  ↓
CHECK AVAILABILITY
  ↓
SELECT DATE & TIME
  ↓
CONTINUE
  ↓
SELECT BOOKING TYPE
  ↓
CATERING PACKAGE ───[or Skip Package]───┐
  ↓                                     │
PACKAGE DETAILS                         │
  ↓                                     │
MENU CUSTOMIZATION                      │
  ↓                                     │
FOOD TRAYS <────────────────────────────┘
(Order both Package & Trays, or Trays only, or Skip Trays)
  ↓
EVENT DETAILS
  ↓
RESERVATION SUMMARY
  ↓
PAYMENT / 30% DOWNPAYMENT
  ↓
DIGITAL RECEIPT
  ↓
MY RESERVATIONS
  ↓
RESERVATION STATUS
```

## 🛠️ Tech Stack
- **PHP** 7.4+ (PDO)
- **MySQL** 5.7+ / MariaDB
- **HTML5 / CSS3** (vanilla, no framework)
- **JavaScript** (vanilla, no jQuery)
- **XAMPP** for local development
- **Font Awesome 6** (CDN)
- **Google Fonts** – Cinzel, Lato, Playfair Display
