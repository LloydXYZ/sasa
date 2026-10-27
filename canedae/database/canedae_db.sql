-- CaneDae ThirdHome Catering - Database Schema
-- Import this file into phpMyAdmin or run via MySQL CLI

CREATE DATABASE IF NOT EXISTS canedae_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE canedae_db;

-- ============================================================
-- USERS TABLE (role-based: user / admin)
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20),
    username VARCHAR(100) DEFAULT 'HelloWorldKumbaga',
    birthdate VARCHAR(50) DEFAULT 'July -- 2005',
    profile_picture VARCHAR(255) NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- PACKAGES TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    pax_min INT DEFAULT 0,
    pax_max INT DEFAULT 0,
    price_min DECIMAL(12,2) DEFAULT 0.00,
    price_max DECIMAL(12,2) DEFAULT 0.00,
    image VARCHAR(255),
    inclusions TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TRAYS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS trays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category ENUM('Chicken','Beef','Fish/Seafoods','Vegetables','Other') DEFAULT 'Other',
    description TEXT,
    pax_min INT DEFAULT 18,
    pax_max INT DEFAULT 20,
    price DECIMAL(10,2) DEFAULT 0.00,
    image VARCHAR(255),
    inclusions TEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- MENU ITEMS TABLE (for package customization)
-- ============================================================
CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    package_id INT NOT NULL,
    category VARCHAR(100) NOT NULL,
    item_name VARCHAR(150) NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
);

-- ============================================================
-- RESERVATIONS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    package_id INT,
    event_name VARCHAR(150),
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    event_venue VARCHAR(255) NOT NULL,
    event_type VARCHAR(100),
    pax INT DEFAULT 50,
    special_requests TEXT,
    status VARCHAR(50) DEFAULT 'Submitted',
    total_amount DECIMAL(12,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL
);

-- ============================================================
-- RESERVATION TRAYS (trays selected per reservation)
-- ============================================================
CREATE TABLE IF NOT EXISTS reservation_trays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    tray_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (tray_id) REFERENCES trays(id) ON DELETE CASCADE
);

-- ============================================================
-- RESERVATION MENU SELECTIONS
-- ============================================================
CREATE TABLE IF NOT EXISTS reservation_menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

-- ============================================================
-- PAYMENTS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    reference_number VARCHAR(100) UNIQUE,
    payment_method ENUM('GCash','Maya','Bank Transfer','Cash on Event') DEFAULT 'GCash',
    amount_paid DECIMAL(12,2) DEFAULT 0.00,
    payment_proof VARCHAR(255),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending','Verified','Rejected') DEFAULT 'Pending',
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE
);

-- ============================================================
-- AVAILABILITY / BLOCKED DATES
-- ============================================================
CREATE TABLE IF NOT EXISTS blocked_dates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blocked_date DATE NOT NULL UNIQUE,
    reason VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- SEED DATA
-- ============================================================

-- Default admin
INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES
('Admin', 'CaneDae', 'admin@canedae.com', '09187305207', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Default password: "password" (hashed with bcrypt)

-- Packages
INSERT INTO packages (name, description, pax_min, pax_max, price_min, price_max, image) VALUES
('Birthday Package', 'Perfect for birthday celebrations with delicious food and elegant setup.', 40, 50, 20500.00, 20500.00, 'assets/images/pkg_birthday.jpg'),
('Anniversary Package', 'Celebrate your love story with our romantic anniversary catering package.', 60, 60, 15000.00, 20000.00, 'assets/images/pkg_anniversary.jpg'),
('Corporate Package', 'Professional catering for corporate events, meetings and gatherings.', 80, 80, 25000.00, 25000.00, 'assets/images/pkg_corporate.jpg'),
('Wedding Package', 'Make your dream wedding unforgettable with our full catering service.', 100, 100, 55000.00, 55000.00, 'assets/images/pkg_wedding.jpg');

-- Trays
INSERT INTO trays (name, category, description, pax_min, pax_max, price, image) VALUES
('Chicken Tray', 'Chicken', 'Assorted chicken dishes – fried, grilled, or sauced. Perfect for any celebration.', 18, 20, 1150.00, 'assets/images/tray_chicken.jpg'),
('Beef Tray', 'Beef', 'Savory beef dishes prepared with rich sauces and fresh ingredients.', 18, 20, 1150.00, 'assets/images/tray_beef.jpg'),
('Fish/Seafoods Tray', 'Fish/Seafoods', 'Fresh seafood and fish selections expertly cooked for your guests.', 18, 20, 1150.00, 'assets/images/tray_fish.jpg'),
('Vegetables Tray', 'Vegetables', 'Fresh and healthy vegetable dishes for a balanced meal.', 18, 20, 850.00, 'assets/images/tray_vegetables.jpg');

-- Menu items for Birthday Package
INSERT INTO menu_items (package_id, category, item_name) VALUES
(1, 'Soup', 'Chicken Sopas'),
(1, 'Soup', 'Bulalo'),
(1, 'Main Course', 'Lechon Manok'),
(1, 'Main Course', 'Pork Adobo'),
(1, 'Main Course', 'Beef Caldereta'),
(1, 'Pasta', 'Baked Macaroni'),
(1, 'Pasta', 'Carbonara'),
(1, 'Rice', 'Steamed Rice'),
(1, 'Rice', 'Garlic Rice'),
(1, 'Dessert', 'Buko Pandan'),
(1, 'Dessert', 'Leche Flan'),
(1, 'Drinks', 'Iced Tea'),
(1, 'Drinks', 'Fruit Punch');

-- Menu items for Anniversary Package
INSERT INTO menu_items (package_id, category, item_name) VALUES
(2, 'Appetizer', 'Garden Salad'),
(2, 'Appetizer', 'Crispy Lumpia'),
(2, 'Main Course', 'Roast Beef'),
(2, 'Main Course', 'Grilled Salmon'),
(2, 'Main Course', 'Chicken Cordon Bleu'),
(2, 'Pasta', 'Spaghetti Bolognese'),
(2, 'Rice', 'Steamed Rice'),
(2, 'Dessert', 'Chocolate Cake'),
(2, 'Dessert', 'Fruit Salad'),
(2, 'Drinks', 'Lemonade'),
(2, 'Drinks', 'Cucumber Water');

-- Menu items for Corporate Package
INSERT INTO menu_items (package_id, category, item_name) VALUES
(3, 'Appetizer', 'Prawn Cocktail'),
(3, 'Main Course', 'Chicken Teriyaki'),
(3, 'Main Course', 'Pork BBQ'),
(3, 'Main Course', 'Fish Fillet'),
(3, 'Pasta', 'Pesto Pasta'),
(3, 'Rice', 'Steamed Rice'),
(3, 'Dessert', 'Mango Float'),
(3, 'Drinks', 'Bottled Water'),
(3, 'Drinks', 'Soda');

-- Menu items for Wedding Package
INSERT INTO menu_items (package_id, category, item_name) VALUES
(4, 'Appetizer', 'Caesar Salad'),
(4, 'Appetizer', 'Bruschetta'),
(4, 'Main Course', 'Lechon de Leche'),
(4, 'Main Course', 'Roasted Chicken'),
(4, 'Main Course', 'Beef Wellington'),
(4, 'Main Course', 'Seafood Kare-Kare'),
(4, 'Pasta', 'Lasagna'),
(4, 'Pasta', 'Fettuccine Alfredo'),
(4, 'Rice', 'Steamed Rice'),
(4, 'Soup', 'Cream of Mushroom'),
(4, 'Dessert', 'Wedding Cake'),
(4, 'Dessert', 'Buko Pandan'),
(4, 'Dessert', 'Leche Flan'),
(4, 'Drinks', 'Sparkling Juice'),
(4, 'Drinks', 'Fruit Punch');
