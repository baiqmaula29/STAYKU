CREATE DATABASE hostel_db;
USE hostel_db;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('owner','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(100) NOT NULL,
    room_number VARCHAR(20) NOT NULL,

    daily_price DECIMAL(12,2) NOT NULL,
    weekly_price DECIMAL(12,2) NOT NULL,

    photo VARCHAR(255),
    ALTER TABLE rooms

    description TEXT,

    status ENUM('available','occupied')
    DEFAULT 'available',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,
    room_id INT NOT NULL,

    rent_type ENUM('harian','mingguan') NOT NULL,

    duration INT NOT NULL,

    check_in DATE,
    check_out DATE,

    total_price DECIMAL(12,2),

    status ENUM(
        'pending',
        'Menunggu Verifikasi',
        'Lunas',
        'cancelled'
    ) DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY(room_id)
    REFERENCES rooms(id)
    ON DELETE CASCADE
);
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,

    booking_id INT NOT NULL,

    amount DECIMAL(12,2) NOT NULL,

    payment_proof VARCHAR(255),

    status ENUM(
        'pending',
        'paid',
        'rejected'
    ) DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (booking_id)
    REFERENCES bookings(id)
    ON DELETE CASCADE
);