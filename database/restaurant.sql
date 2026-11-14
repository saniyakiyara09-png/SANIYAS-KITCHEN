CREATE DATABASE IF NOT EXISTS saniyas_kitchen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE saniyas_kitchen;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(80) NOT NULL UNIQUE
);

CREATE TABLE menu_items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 category_id INT NULL,
 name VARCHAR(120) NOT NULL,
 description TEXT,
 price DECIMAL(10,2) NOT NULL DEFAULT 0,
 image_url VARCHAR(500),
 is_available TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE bookings (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NULL,
 customer_name VARCHAR(100) NOT NULL,
 email VARCHAR(190) NOT NULL,
 phone VARCHAR(20) NOT NULL,
 booking_date DATE NOT NULL,
 booking_time TIME NOT NULL,
 guests TINYINT UNSIGNED NOT NULL,
 notes TEXT,
 status ENUM('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE orders (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 total_amount DECIMAL(10,2) NOT NULL,
 notes TEXT,
 status ENUM('pending','preparing','completed','cancelled') NOT NULL DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT NOT NULL,
 menu_item_id INT NULL,
 item_name VARCHAR(120) NOT NULL,
 unit_price DECIMAL(10,2) NOT NULL,
 quantity INT NOT NULL,
 FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
 FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE SET NULL
);

CREATE TABLE payments (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT NOT NULL UNIQUE,
 amount DECIMAL(10,2) NOT NULL,
 method VARCHAR(30) NOT NULL DEFAULT 'UPI_QR_DEMO',
 customer_reference VARCHAR(100) NULL,
 status ENUM('pending','paid','rejected') NOT NULL DEFAULT 'pending',
 verified_at DATETIME NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

INSERT INTO categories(name) VALUES
('Starters'),('Main Course'),('Desserts'),('Beverages');

INSERT INTO menu_items(category_id,name,description,price,image_url) VALUES
(1,'Crispy Garden Bites','Golden, crisp seasonal vegetables with a house dip.',249,'https://images.unsplash.com/photo-1541014741259-de529411b96a?w=900'),
(1,'Creamy Tomato Soup','Slow-simmered tomato soup finished with herbs.',179,'https://images.unsplash.com/photo-1547592180-85f173990554?w=900'),
(2,'Royal Paneer Curry','Paneer in a rich, aromatic tomato and cashew gravy.',349,'https://images.unsplash.com/photo-1631452180519-c014fe946bc7?w=900'),
(2,'Herb Butter Rice Bowl','Fragrant rice with vegetables and herb butter.',279,'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=900'),
(3,'Chocolate Decadence','A soft chocolate dessert for a sweet finish.',199,'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=900'),
(4,'Classic Iced Coffee','Chilled coffee, smooth and refreshing.',149,'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=900');

-- Create the first admin account using the one-time setup script below.
