CREATE DATABASE hotel_booking;

USE hotel_booking;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(100) NOT NULL,
    room_type VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);

INSERT INTO rooms (room_name, room_type, price, description, image) VALUES
('Deluxe Room', 'Deluxe', 2500.00, 'Comfortable deluxe room with mountain view and attached bathroom.', 'images/room1.jpg'),
('Premium Room', 'Premium', 3500.00, 'Premium room with king size bed, balcony, Wi-Fi and room service.', 'images/room2.jpg'),
('Family Suite', 'Suite', 5000.00, 'Large family suite with two beds, living area and beautiful view.', 'images/room3.jpg');