CREATE DATABASE IF NOT EXISTS iklan_mobil;
USE iklan_mobil;

-- Tabel Users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL
);

INSERT INTO users (username, password, role) VALUES
('admin', 'admin123', 'admin'),
('user1', 'user123', 'user');

-- Tabel Iklan
CREATE TABLE iklan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga INT,
    gambar VARCHAR(255),
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
