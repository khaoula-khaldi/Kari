CREATE DATABASE Kari;

USE Kari;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_active varchar(255) DEFAULT 'active',
    role ENUM('traveler','host','admin') NOT NULL DEFAULT 'traveler', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    host_id INT NOT NULL,            
    title VARCHAR(255) NOT NULL,
    description TEXT,
    address VARCHAR(255),
    city VARCHAR(100),
    price_per_night DECIMAL(10,2),
    capacity INT,
    image_url VARCHAR(255),
    available_dates TEXT,        
    is_active varchar(255) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (host_id) REFERENCES users(id) ON DELETE CASCADE
);





SELECT users.name,users.email,rentals.title,reservations.start_date
 AS date_debut,reservations.end_date 
AS date_fin ,reservations.id AS reservation_id 
FROM reservations 
INNER JOIN users 
ON reservations.user_id = users.id 
INNER JOIN rentals 
ON reservations.rental_id = rentals.id;



CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,        
    rental_id INT NOT NULL,      
    start_date DATE NOT NULL,    
    end_date DATE NOT NULL,     
    status ENUM('pending','confirmed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) delete on cascade,
    FOREIGN KEY (rental_id) REFERENCES rentals(id)  delete on cascade
);



CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,        
    rental_id INT NOT NULL,     
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5), 
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (rental_id) REFERENCES rentals(id) ON DELETE CASCADE,
    UNIQUE (user_id, rental_id)
);




CREATE TABLE favoris(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,        
    rental_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (rental_id) REFERENCES rentals(id)
);




