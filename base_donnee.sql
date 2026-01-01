CREATE DATABASE Kari;

USE Kari;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('traveler','host','admin') NOT NULL DEFAULT 'traveler', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    host_id INT NOT NULL,            -- référence vers users.id (l’hôte)
    title VARCHAR(255) NOT NULL,
    description TEXT,
    address VARCHAR(255),
    city VARCHAR(100),
    price_per_night DECIMAL(10,2),
    capacity INT,
    image_url VARCHAR(255),
    available_dates TEXT,            -- ou JSON si tu veux stocker plusieurs dates
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (host_id) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,        
    rental_id INT NOT NULL,     
    nb_etoiles INT NOT NULL, 
    commentaire TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (rental_id) REFERENCES rentals(id)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,        
    rental_id INT NOT NULL,      
    start_date DATE NOT NULL,    
    end_date DATE NOT NULL,     
    status BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (rental_id) REFERENCES rentals(id)
);














